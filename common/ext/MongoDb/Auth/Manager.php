<?php

namespace common\ext\MongoDb\Auth;

/**
 * MongoDB Auth Manager
 *
 * @see \yii::app()->authManager
 */
class Manager extends \CAuthManager
{

    /**
     * List of auth items (itemName => item)
     * @var array
     */
	protected $_items = array();

    /**
     * List of children (itemName, childName => child)
     * @var array
     */
	protected $_children = array();

	/**
	 * Initializes the application component.
	 */
	public function init()
    {
        parent::init();

        // Load items and children
		$items = Item::model()->findAll();

        // Set items
        $this->_items = array();
		foreach ($items as $item) {
			$this->_items[$item->name] = new \CAuthItem(
                $this, $item->name, $item->type, $item->description, $item->bizRule, $item->data
            );
        }

        // Set children
        $this->_children = array();
		foreach($items as $item) {
            foreach ($item->children as $childName) {
                if (isset($this->_items[$childName]))
                    $this->_children[$item->name][$childName] = $this->_items[$childName];
            }
		}

    }

	/**
	 * Performs access check for the specified user.
     *
	 * @param string $itemName the name of the operation that need access check
	 * @param mixed $userId the user ID. This should can be either an integer and a string representing
	 * the unique identifier of a user. See {@link IWebUser::getId}.
	 * @param array $params name-value pairs that would be passed to biz rules associated
	 * with the tasks and roles assigned to the user.
	 * @return boolean whether the operations can be performed by the user.
	 */
	public function checkAccess($itemName, $userId, $params = array())
	{
		if (!isset($this->_items[$itemName])) {
			return false;
        }
		$item = $this->_items[$itemName];
		if ($this->executeBizRule($item->getBizRule(), $params, $item->getData())) {
			if (in_array($itemName, $this->defaultRoles)) {
				return true;
            }
            $assignment = $this->getAuthAssignment($itemName, $userId);
            if ($assignment !== null) {
				if ($this->executeBizRule($assignment->getBizRule(), $params, $assignment->getData())) {
					return true;
                }
            }
			foreach ($this->_children as $parentName => $children) {
				if ((isset($children[$itemName])) && ($this->checkAccess($parentName, $userId, $params))) {
					return true;
                }
			}
		}
		return false;
	}

	/**
	 * Adds an item as a child of another item.
     *
	 * @param string $itemName the parent item name
	 * @param string $childName the child item name
	 * @return boolean whether the item is added successfully
	 * @throws CException if either parent or child doesn't exist or if a loop has been detected.
	 */
	public function addItemChild($itemName, $childName)
	{
		if (!isset($this->_items[$childName], $this->_items[$itemName]))
			throw new \CException(\yii::t('app', 'Either "{name}" or "{child}" does not exist.', array(
                '{child}' => $childName,
                '{name}'  => $itemName,
            )));
		$child = $this->_items[$childName];
		$item  = $this->_items[$itemName];
		$this->checkItemChildType($item->getType(), $child->getType());
		if ($this->_detectLoop($itemName, $childName))
			throw new \CException(\yii::t('app', 'Cannot add "{child}" as a child of "{parent}". A loop has been detected.', array(
                '{child}'  => $childName,
                '{parent}' => $itemName,
            )));
		if (isset($this->_children[$itemName][$childName]))
			throw new \CException(\yii::t('app','The item "{parent}" already has a child "{child}".', array(
                '{child}'  => $childName,
                '{parent}' => $itemName,
            )));
		$this->_children[$itemName][$childName] = $this->_items[$childName];
        $this->saveAuthItem($item);
		return true;
	}

	/**
	 * Checks whether there is a loop in the authorization item hierarchy.
     *
	 * @param string $itemName parent item name
	 * @param string $childName the name of the child item that is to be added to the hierarchy
	 * @return boolean whether a loop exists
	 */
	protected function _detectLoop($itemName,$childName)
	{
		if ($childName===$itemName)
			return true;
		if (!isset($this->_children[$childName], $this->_items[$itemName]))
			return false;

		foreach ($this->_children[$childName] as $child) {
			if ($this->_detectLoop($itemName, $child->getName()))
				return true;
		}

		return false;
	}

	/**
	 * Removes a child from its parent.
	 * Note, the child item is not deleted. Only the parent-child relationship is removed.
     *
	 * @param string $itemName the parent item name
	 * @param string $childName the child item name
	 * @return boolean whether the removal is successful
	 */
	public function removeItemChild($itemName, $childName)
	{
		if (isset($this->_children[$itemName][$childName])) {
			unset($this->_children[$itemName][$childName]);
            $this->saveAuthItem($this->_items[$itemName]);
			return true;
		} else {
			return false;
        }
	}

	/**
	 * Returns a value indicating whether a child exists within a parent.
     *
	 * @param string $itemName the parent item name
	 * @param string $childName the child item name
	 * @return boolean whether the child exists
	 */
	public function hasItemChild($itemName, $childName)
	{
        return isset($this->_children[$itemName][$childName]);
	}

	/**
	 * Returns the children of the specified item.
     *
	 * @param mixed $names the parent item name. This can be either a string or an array.
	 * The latter represents a list of item names.
	 * @return array all child items of the parent
	 */
	public function getItemChildren($names)
	{
		if (is_string($names))
			return isset($this->_children[$names]) ? $this->_children[$names] : array();

		$children = array();
		foreach ($names as $name) {
			if (isset($this->_children[$name]))
				$children = array_merge($children, $this->_children[$name]);
		}
		return $children;
	}

	/**
	 * Assigns an authorization item to a user.
     *
	 * @param string $itemName the item name
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @param string $bizRule the business rule to be executed when {@link checkAccess} is called
	 * for this particular authorization item.
	 * @param mixed $data additional data associated with this assignment
	 * @return CAuthAssignment the authorization assignment information.
	 * @throws CException if the item does not exist or if the item has already been assigned to the user
	 */
	public function assign($itemName, $userId, $bizRule = null, $data = null)
	{
        $userId = (string)$userId;
		if (!isset($this->_items[$itemName])) {
			throw new \CException(\yii::t('app', 'Unknown authorization item "{name}".', array(
               '{name}' => $itemName,
            )));
        } else {
            $assignment = $this->getAuthAssignment($itemName, $userId);
            if ($assignment !== null) {
                throw new \CException(\yii::t('app', 'Authorization item "{item}" has already been assigned to user "{user}".', array(
                    '{item}' => $itemName,
                    '{user}' => $userId,
                )));
            } else {
                $assignment = new Assignment();
                $assignment->setAttributes(array(
                    'itemName'  => $itemName,
                    'userId'    => $userId,
                    'bizRule'   => $bizRule,
                    'data'      => $data,
                ), false);
                $assignment->save();
                return new \CAuthAssignment($this, $itemName, $userId, $bizRule, $data);
            }
        }
	}

	/**
	 * Revokes an authorization assignment from a user.
     *
	 * @param string $itemName the item name
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @return boolean whether removal is successful
	 */
	public function revoke($itemName, $userId)
	{
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('itemName', '==', (string)$itemName)
            ->addCond('userId', '==', (string)$userId);
        Assignment::model()->deleteAll($criteria);
        return true;
	}

    /**
     * Get list of user's roles
     *
     * @param string $userId
     * @return array
     */
    public function getUserRoles($userId)
    {
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('userId', '==', (string)$userId);
        $assignmentList = Assignment::model()->findAll($criteria);

        $roleList = array();
        foreach ($assignmentList as $assignment) {
            $roleList[] = $assignment->itemName;
        }

        return $roleList;
    }

	/**
	 * Returns a value indicating whether the item has been assigned to the user.
     *
	 * @param string $itemName the item name
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @return boolean whether the item has been assigned to the user.
	 */
	public function isAssigned($itemName, $userId)
	{
        $count = Assignment::model()->countByAttributes(array(
            'itemName'  => $itemName,
            'userId'    => $userId,
        ));
        return !($count === 0);
	}

	/**
	 * Returns the item assignment information.
     *
	 * @param string $itemName the item name
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @return \CAuthAssignment the item assignment information. Null is returned if
	 * the item is not assigned to the user.
	 */
	public function getAuthAssignment($itemName, $userId)
	{
        $row = Assignment::model()->findByAttributes(array(
            'itemName'  => (string)$itemName,
            'userId'    => (string)$userId
        ));
		if ($row !== null) {
			return new \CAuthAssignment(
                $this, $row->itemName, $row->userId, $row->bizRule, $row->data
            );
		} else {
			return null;
        }
	}

    /**
     * Returns wheter auth item has assigned users
     *
     * @param string $itemName
     * @return bool
     */
    public function hasAssignedUsers($itemName)
    {
        $count = Assignment::model()->countByAttributes(array(
            'itemName' => $itemName,
        ));
		return ($count > 0);
    }

	/**
	 * Returns the item assignments for the specified user.
     *
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @return array the item assignment information for the user. An empty array will be
	 * returned if there is no item assigned to the user.
	 */
	public function getAuthAssignments($userId)
	{
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('userId', '==', (string)$userId)
            ->sort('itemName', \EMongoCriteria::SORT_ASC);
        $rowList = Assignment::model()->findAll($criteria);
		$assignments = array();
		foreach ($rowList as $row) {
			$assignments[$row->itemName] = new \CAuthAssignment(
                $this, $row->itemName, $row->userId, $row->bizRule, $row->data
            );
        }
		return $assignments;
	}

	/**
	 * Saves the changes to an authorization assignment.
     *
	 * @param CAuthAssignment $assignment the assignment that has been changed.
	 */
	public function saveAuthAssignment($assignment)
	{
        $assignment = Assignment::model()->findByAttributes(array(
            'itemName'  => $assignment->getItemName(),
            'userId'    => $assignment->getUserId(),
        ));
        if ($assignment === null)
            $assignment = new Assignment();
        $assignment->setAttributes(array(
            'itemName'  => $assignment->getItemName(),
            'userId'    => $assignment->getUserId(),
            'bizRule'   => $assignment->getBizRule(),
            'data'      => $assignment->getData(),
        ), false);
        $assignment->save();
	}

	/**
	 * Returns the authorization items of the specific type and user.
     *
	 * @param integer $type the item type (0: operation, 1: task, 2: role). Defaults to null,
	 * meaning returning all items regardless of their type.
	 * @param mixed $userId the user ID. Defaults to null, meaning returning all items even if
	 * they are not assigned to a user.
	 * @return array the authorization items of the specific type.
	 */
	public function getAuthItems($type = null, $userId = null)
	{
		if (($type === null) && ($userId === null))
			return $this->_items;
		$items = array();
		if ($userId === null) {
			foreach ($this->_items as $name => $item) {
				if ($item->getType() == $type)
					$items[$name] = $item;
			}
		} elseif (isset($this->_assignments[$userId])) {
			foreach ($this->_assignments[$userId] as $assignment) {
				$name = $assignment->getItemName();
				if ((isset($this->_items[$name])) && (($type === null) || ($this->_items[$name]->getType() == $type)))
					$items[$name] = $this->_items[$name];
			}
		}
		return $items;
	}

	/**
	 * Creates an authorization item.
	 * An authorization item represents an action permission (e.g. creating a post).
	 * It has three types: operation, task and role.
	 * Authorization items form a hierarchy. Higher level items inheirt permissions representing
	 * by lower level items.
     *
	 * @param string $name the item name. This must be a unique identifier.
	 * @param integer $type the item type (0: operation, 1: task, 2: role).
	 * @param string $description description of the item
	 * @param string $bizRule business rule associated with the item. This is a piece of
	 * PHP code that will be executed when {@link checkAccess} is called for the item.
	 * @param mixed $data additional data associated with the item.
	 * @return CAuthItem the authorization item
	 * @throws CException if an item with the same name already exists
	 */
	public function createAuthItem($name, $type, $description = '', $bizRule = null, $data = null)
	{
		if (isset($this->_items[$name])) {
			throw new \CException(\yii::t('app', 'Unable to add an item whose name is the same as an existing item.'));
        }
		$this->_items[$name] = new \CAuthItem($this, $name, $type, $description, $bizRule, $data);
        $this->saveAuthItem($this->_items[$name]);
        return $this->_items[$name];
	}

	/**
	 * Removes the specified authorization item.
     *
	 * @param string $name the name of the item to be removed
	 * @return boolean whether the item exists in the storage and has been removed
	 */
	public function removeAuthItem($name)
	{
		if (isset($this->_items[$name])) {
			foreach ($this->_children as &$children)
				unset($children[$name]);
			unset($this->_items[$name]);

            // Remove item from DB
            $criteria = new \EMongoCriteria();
            $criteria->addCond('name', '==', $name);
            Item::model()->deleteAll($criteria);

            // Remove assignments to this item from DB
            $criteria = new \EMongoCriteria();
            $criteria->addCond('itemName', '==', $name);
            Assignment::model()->deleteAll($criteria);

            // Return TRUE
			return true;
		} else {
			return false;
        }
	}

	/**
	 * Returns the authorization item with the specified name.
     *
	 * @param string $name the name of the item
	 * @return CAuthItem the authorization item. Null if the item cannot be found.
	 */
	public function getAuthItem($name)
	{
        return isset($this->_items[$name]) ? $this->_items[$name] : null;
	}

	/**
	 * Saves an authorization item to persistent storage.
     *
	 * @param CAuthItem $item the item to be saved.
	 * @param string $oldName the old item name. If null, it means the item name is not changed.
	 */
	public function saveAuthItem($item, $oldName = null)
	{
        // If name was changed
		if (($oldName !== null) && (($newName = $item->getName()) !== $oldName)) { // name changed
			if (isset($this->_items[$newName]))
				throw new \CException(\yii::t('app', 'Unable to change the item name. The name "{name}" is already used by another item.', array(
                    '{name}' => $newName,
                )));
			if ((isset($this->_items[$oldName])) && ($this->_items[$oldName] === $item)) {
				unset($this->_items[$oldName]);
				$this->_items[$newName] = $item;
				if (isset($this->_children[$oldName])) {
					$this->_children[$newName] = $this->_children[$oldName];
					unset($this->_children[$oldName]);
				}
				foreach ($this->_children as &$children) {
					if(isset($children[$oldName])) {
						$children[$newName] = $children[$oldName];
						unset($children[$oldName]);
					}
				}

                // Delete auth item with $oldName
                $criteria = new \EMongoCriteria();
                $criteria->addCond('name', '==', $oldName);
                Item::model()->deleteAll($criteria);

                // Update assignments from $oldName to $newName
                $modifier = new \EMongoModifier();
                $modifier->addModifier('itemName', 'set', $newName);
                $criteria = new \EMongoCriteria();
                $criteria->addCond('itemName', '==', $oldName);
                Assignment::model()->updateAll($modifier, $criteria);
			}
		}

        // Save auth item
        $itemDb = Item::model()->findByAttributes(array(
            'name' => $item->getName(),
        ));
        if ($itemDb === null)
            $itemDb = new Item();
        $itemDb->setAttributes(array(
            'name'          => $item->getName(),
            'type'          => $item->getType(),
            'description'   => $item->getDescription(),
            'bizRule'       => $item->getBizRule(),
            'data'          => $item->getData(),
            'children'      => array_keys($item->getChildren()),
        ), false);
        $itemDb->save();
	}

	/**
	 * Saves the authorization data to persistent storage.
	 */
	public function save()
	{
	}

	/**
	 * Removes all authorization data.
     *
     * @param bool $clearAssignments
	 */
	public function clearAll($clearAssignments = true)
	{
        // Clear assignments
        if ($clearAssignments) {
            $this->clearAuthAssignments();
        }

        // Clear items and children
        $this->_items    = array();
        $this->_children = array();

        // Remove from DB
        Item::model()->deleteAll();
	}

	/**
	 * Removes all authorization assignments.
	 */
	public function clearAuthAssignments()
	{
        Assignment::model()->deleteAll();
	}

	/**
	 * Removes all authorization assignments.
     *
     * @param string $userId
	 */
	public function clearAuthAssignmentsByUser($userId)
	{
        $criteria = new \EMongoCriteria();
        $criteria->addCond('userId', '==', (string)$userId);
        Assignment::model()->deleteAll($criteria);
	}

    /**
     * Get list of all operations
     *
     * @return array
     */
    public function getOperationList()
    {
        return array(
            'paid'              => array(
                'description' => \yii::t('app', 'Membership.'),
                'isPaid'      => true,
            ),
            'fb_viewProfile'    => array(
                'description' => \yii::t('app', 'View Facebook profile basic information.'),
                'isPaid'      => false,
            ),
        );
    }

    /**
     * Get description of the operation
     *
     * @param string $operation
     * @return string
     */
    public function getOperationDescription($operation)
    {
        $list = $this->getOperationList();
        if (isset($list[$operation]['description']))
            return $list[$operation]['description'];
        else
            return \yii::t('app', 'Unknown operation.');
    }

}