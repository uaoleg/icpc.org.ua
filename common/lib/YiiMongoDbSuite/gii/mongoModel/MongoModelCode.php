<?php

/**
 * @since v1.3.4
 */
class MongoModelCode extends CCodeModel
{
	public $tablePrefix;
	public $tableName;
	public $modelClass;
	public $mongoCollectionName;
	public $modelPath='application.models';
	public $baseClass='EMongoDocument';

	/**
	 * @var array list of candidate relation code. The array are indexed by AR class names and relation names.
	 * Each element represents the code of the one relation in one AR class.
	 */
	protected $relations;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('tablePrefix, baseClass, tableName, modelClass, modelPath', 'filter', 'filter'=>'trim'),
			array('tableName, modelPath, baseClass, mongoCollectionName', 'required'),
			array('tablePrefix, tableName, modelPath, mongoCollectionName', 'match', 'pattern'=>'/^(\w+[\w\.]*|\*?|\w+\.\*)$/', 'message'=>'{attribute} should only contain word characters, dots, and an optional ending asterisk.'),
			array('tableName', 'validateTableName', 'skipOnError'=>true),
			array('tablePrefix, modelClass, baseClass, mongoCollectionName', 'match', 'pattern'=>'/^[a-zA-Z_]\w*$/', 'message'=>'{attribute} should only contain word characters.'),
			array('modelPath', 'validateModelPath', 'skipOnError'=>true),
			array('baseClass, modelClass, mongoCollectionName', 'validateReservedWord', 'skipOnError'=>true),
			array('baseClass', 'validateBaseClass', 'skipOnError'=>true),
			array('tablePrefix, modelPath, baseClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'tablePrefix'=>'Table Prefix',
			'tableName'=>'Table Name',
			'modelPath'=>'Model Path',
			'modelClass'=>'Model Class',
			'baseClass'=>'Base Class',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'model.php',
		);
	}

	public function init()
	{
		if(Yii::app()->db===null)
			throw new CHttpException(500,'An active "db" connection is required to run this generator.');
		$this->tablePrefix=Yii::app()->db->tablePrefix;
		parent::init();
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;

		if(($pos=strrpos($this->tableName,'.'))!==false)
		{
			$schema=substr($this->tableName,0,$pos);
			$tableName=substr($this->tableName,$pos+1);
		}
		else
		{
			$schema='';
			$tableName=$this->tableName;
		}
		if($tableName[strlen($tableName)-1]==='*')
		{
			$tables=Yii::app()->db->schema->getTables($schema);
			if($this->tablePrefix!='')
			{
				foreach($tables as $i=>$table)
				{
					if(strpos($table->name,$this->tablePrefix)!==0)
						unset($tables[$i]);
				}
			}
		}
		else
			$tables=array($this->getTableSchema($this->tableName));

		$this->relations=$this->generateRelations();

		foreach($tables as $table)
		{
			$tableName=$this->removePrefix($table->name);
			$className=$this->generateClassName($table->name);
			$params=array(
				'tableName'=>$schema==='' ? $tableName : $schema.'.'.$tableName,
				'modelClass'=>$className,
				'collectionName'=>$this->mongoCollectionName,
				'columns'=>$table->columns,
				'labels'=>$this->generateLabels($table),
				'rules'=>$this->generateRules($table),
				'relations'=>isset($this->relations[$className]) ? $this->relations[$className] : array(),
				'primaryKey'=>$table->primaryKey,
			);
			$this->files[]=new CCodeFile(
				Yii::getPathOfAlias($this->modelPath).'/'.$className.'.php',
				$this->render($templatePath.'/model.php', $params)
			);
		}
	}

	public function validateTableName($attribute,$params)
	{
		if($this->tableName!='' && $this->tableName[strlen($this->tableName)-1]==='*')
			$this->modelClass='';
		else
		{
			if($this->getTableSchema($this->tableName)===null)
				$this->addError('tableName',"Table '{$this->tableName}' does not exist.");
			if($this->modelClass==='')
				$this->addError('modelClass','Model Class cannot be blank.');
		}
	}

	public function validateModelPath($attribute,$params)
	{
		if(Yii::getPathOfAlias($this->modelPath)===false)
			$this->addError('modelPath','Model Path must be a valid path alias.');
	}

	public function validateBaseClass($attribute,$params)
	{
		$class=@Yii::import($this->baseClass,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('baseClass', "Class '{$this->baseClass}' does not exist or has syntax error.");
		else if($class!=='EMongoDocument' && !is_subclass_of($class,'EMongoDocument'))
			$this->addError('baseClass', "'{$this->model}' must extend from EMongoDocument.");
	}

	public function getTableSchema($tableName)
	{
		return Yii::app()->db->getSchema()->getTable($tableName);
	}

	public function generateLabels($table)
	{
		$labels=array();
		foreach($table->columns as $column)
		{
			$label=ucwords(trim(strtolower(str_replace(array('-','_'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $column->name)))));
			$label=preg_replace('/\s+/',' ',$label);
			if(strcasecmp(substr($label,-3),' id')===0)
				$label=substr($label,0,-3);
			if($label==='Id')
				$label='ID';
			$labels[$column->name]=$label;
		}
		return $labels;
	}

	public function generateRules($table)
	{
		$rules=array();
		$required=array();
		$integers=array();
		$numerical=array();
		$length=array();
		$safe=array();
		foreach($table->columns as $column)
		{
			if($column->isPrimaryKey && $table->sequenceName!==null)
				continue;
			$r=!$column->allowNull && $column->defaultValue===null;
			if($r)
				$required[]=$column->name;
			if($column->type==='integer')
				$integers[]=$column->name;
			else if($column->type==='double')
				$numerical[]=$column->name;
			else if($column->type==='string' && $column->size>0)
				$length[$column->size][]=$column->name;
			else if(!$column->isPrimaryKey && !$r)
				$safe[]=$column->name;
		}
		if($required!==array())
			$rules[]="array('".implode(', ',$required)."', 'required')";
		if($integers!==array())
			$rules[]="array('".implode(', ',$integers)."', 'numerical', 'integerOnly'=>true)";
		if($numerical!==array())
			$rules[]="array('".implode(', ',$numerical)."', 'numerical')";
		if($length!==array())
		{
			foreach($length as $len=>$cols)
				$rules[]="array('".implode(', ',$cols)."', 'length', 'max'=>$len)";
		}
		if($safe!==array())
			$rules[]="array('".implode(', ',$safe)."', 'w')";

		return $rules;
	}

	public function getRelations($className)
	{
		return isset($this->relations[$className]) ? $this->relations[$className] : array();
	}

	protected function removePrefix($tableName,$addBrackets=true)
	{
		if($addBrackets && Yii::app()->db->tablePrefix=='')
			return $tableName;
		$prefix=$this->tablePrefix!='' ? $this->tablePrefix : Yii::app()->db->tablePrefix;
		if($prefix!='')
		{
			if($addBrackets && Yii::app()->db->tablePrefix!='')
			{
				$prefix=Yii::app()->db->tablePrefix;
				$lb='{{';
				$rb='}}';
			}
			else
				$lb=$rb='';
			if(($pos=strrpos($tableName,'.'))!==false)
			{
				$schema=substr($tableName,0,$pos);
				$name=substr($tableName,$pos+1);
				if(strpos($name,$prefix)===0)
					return $schema.'.'.$lb.substr($name,strlen($prefix)).$rb;
			}
			else if(strpos($tableName,$prefix)===0)
				return $lb.substr($tableName,strlen($prefix)).$rb;
		}
		return $tableName;
	}

	protected function generateRelations()
	{
		$relations=array();
		foreach(Yii::app()->db->schema->getTables() as $table)
		{
			if($this->tablePrefix!='' && strpos($table->name,$this->tablePrefix)!==0)
				continue;
			$tableName=$table->name;

			if ($this->isRelationTable($table))
			{
				$pks=$table->primaryKey;
				$fks=$table->foreignKeys;

				$table0=$fks[$pks[0]][0];
				$table1=$fks[$pks[1]][0];
				$className0=$this->generateClassName($table0);
				$className1=$this->generateClassName($table1);

				$unprefixedTableName=$this->removePrefix($tableName);

				$relationName=$this->generateRelationName($table0, $table1, true);
				$relations[$className0][$relationName]="array(self::MANY_MANY, '$className1', '$unprefixedTableName($pks[0], $pks[1])')";

				$relationName=$this->generateRelationName($table1, $table0, true);
				$relations[$className1][$relationName]="array(self::MANY_MANY, '$className0', '$unprefixedTableName($pks[1], $pks[0])')";
			}
			else
			{
				$className=$this->generateClassName($tableName);
				foreach ($table->foreignKeys as $fkName => $fkEntry)
				{
					// Put table and key name in variables for easier reading
					$refTable=$fkEntry[0]; // Table name that current fk references to
					$refKey=$fkEntry[1];   // Key in that table being referenced
					$refClassName=$this->generateClassName($refTable);

					// Add relation for this table
					$relationName=$this->generateRelationName($tableName, $fkName, false);
					$relations[$className][$relationName]="array(self::BELONGS_TO, '$refClassName', '$fkName')";

					// Add relation for the referenced table
					$relationType=$table->primaryKey === $fkName ? 'HAS_ONE' : 'HAS_MANY';
					$relationName=$this->generateRelationName($refTable, $this->removePrefix($tableName,false), $relationType==='HAS_MANY');
					$relations[$refClassName][$relationName]="array(self::$relationType, '$className', '$fkName')";
				}
			}
		}
		return $relations;
	}

	/**
	 * Checks if the given table is a "many to many" pivot table.
	 * Their PK has 2 fields, and both of those fields are also FK to other separate tables.
	 * @param CDbTableSchema table to inspect
	 * @return boolean true if table matches description of helpter table.
	 */
	protected function isRelationTable($table)
	{
		$pk=$table->primaryKey;
		return (count($pk) === 2 // we want 2 columns
			&& isset($table->foreignKeys[$pk[0]]) // pk column 1 is also a foreign key
			&& isset($table->foreignKeys[$pk[1]]) // pk column 2 is also a foriegn key
			&& $table->foreignKeys[$pk[0]][0] !== $table->foreignKeys[$pk[1]][0]); // and the foreign keys point different tables
	}

	protected function generateClassName($tableName)
	{
		if($this->tableName===$tableName || ($pos=strrpos($this->tableName,'.'))!==false && substr($this->tableName,$pos+1)===$tableName)
			return $this->modelClass;

		$tableName=$this->removePrefix($tableName,false);
		$className='';
		foreach(explode('_',$tableName) as $name)
		{
			if($name!=='')
				$className.=ucfirst($name);
		}
		return $className;
	}

	/**
	 * Generate a name for use as a relation name (inside relations() function in a model).
	 * @param string the name of the table to hold the relation
	 * @param string the foreign key name
	 * @param boolean whether the relation would contain multiple objects
	 * @return string the relation name
	 */
	protected function generateRelationName($tableName, $fkName, $multiple)
	{
		if(strcasecmp(substr($fkName,-2),'id')===0 && strcasecmp($fkName,'id'))
			$relationName=rtrim(substr($fkName, 0, -2),'_');
		else
			$relationName=$fkName;
		$relationName[0]=strtolower($relationName);

		$rawName=$relationName;
		if($multiple)
			$relationName=$this->pluralize($relationName);

		$table=Yii::app()->db->schema->getTable($tableName);
		$i=0;
		while(isset($table->columns[$relationName]))
			$relationName=$rawName.($i++);

		$names=preg_split('/_+/',$relationName,-1,PREG_SPLIT_NO_EMPTY);
		if(empty($names)) return $relationName;  // unlikely
		for($name=$names[0], $i=1;$i<count($names);++$i)
			$name.=ucfirst($names[$i]);
		return $name;
	}
}