<?php

namespace console\controllers;

use \common\models\Document;
use \common\models\News;
use \common\models\School;
use \common\models\Team;
use \common\models\Result;
use \common\models\Qa;
use \common\models\User;

class DbController extends BaseController
{

    /**
     * Create DB backup
     *
     * @param string $name backup file name
     */
    public function actionDump($name, $host = 'localhost')
    {
        // Create backup
        echo "Dumping DB...\n";
        $dumpFolder = uniqid('mongodump-' . $name);
        $dumpPath = \yii::getAlias('@console/runtime') . DIRECTORY_SEPARATOR . $dumpFolder;
        if (!is_dir($dumpPath)) {
            mkdir($dumpPath);
        }
        $dbName = \yii::$app->mongodb->dbName;
        chmod(__DIR__ . '/../mongodump', 0100);
        $commandDump = __DIR__ . "/../mongodump --host={$host} --db={$dbName} --out={$dumpPath}";
        exec($commandDump);

        // Archive
        echo "Archiving...\n";
        $zipPath = \yii::getAlias('@common/runtime') . DIRECTORY_SEPARATOR . "{$name}.zip";
        \yii::$app->archive->compress($dumpPath, $zipPath);

        // Delete the dump
        echo "Deleting DB dump...\n";
        $it = new \RecursiveDirectoryIterator($dumpPath);
        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if (($file->getFilename() === '.') || ($file->getFilename() === '..')) {
                continue;
            } elseif ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dumpPath);

        // Done
        echo "Done\n";
    }

    /**
     * Temp action to update schools' data
     */
	public function actionSchools()
	{
		$schools = new \common\models\School();
		$dups = [];
		foreach ($schools->findAll() as $school) {
			if ($school->shortNameEn === null) {
				continue;
			}
			if (!isset($dups[$school->shortNameEn])) {
				$dups[$school->shortNameEn] = -1;
			}
			$dups[$school->shortNameEn]++;
		}
		var_dump(array_filter($dups));
	}

    /**
     * Temp action to migrate from MongoDB to MySQL
     */
    public function actionMigrate()
    {
        \yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0;')->execute();
        \yii::$app->db->createCommand()->truncateTable('translation')->execute();
        \yii::$app->db->createCommand()->truncateTable(School::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(User::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(User\ApprovalRequest::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(User\EmailConfirmation::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(User\InfoCoach::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(User\InfoStudent::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(User\Photo::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(User\Settings::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Team::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Team\Member::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Result::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Result\Task::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Qa\Answer::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Qa\Question::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Qa\QuestionTagRel::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Qa\Tag::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(News::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(News\Image::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(News\PublishLog::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(News\Revision::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable(Document::tableName())->execute();
        \yii::$app->db->createCommand()->truncateTable('auth_item')->execute();
        \yii::$app->db->createCommand()->truncateTable('auth_item_child')->execute();
        \yii::$app->db->createCommand()->truncateTable('auth_assignment')->execute();
        \yii::$app->db->createCommand()->truncateTable('auth_rule')->execute();
        \yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 1;')->execute();

        // Translations
        echo "Translations...\n";
        $rows = \yii::$app->mongodb->getCollection('translation')->find();
        foreach ($rows as $row) {
            $row['message'] = str_replace('{a}', '{a_}', $row['message']);
            $row['message'] = str_replace('{/a}', '{_a}', $row['message']);
            \yii::$app->db->createCommand()->insert('translation', [
                'language'      => $row['language'],
                'category'      => $row['category'],
                'message'       => $row['message'],
                'translation'   => $row['translation'],
            ])->execute();
        }
        echo "\n\n";

        // Schools
        echo "Schools...\n";
        $schoolsIds = [];
        $rows = \yii::$app->mongodb->getCollection('school')->find();
        foreach ($rows as $row) {
            $school = new School([
                'fullNameUk' => $row['fullNameUk'],
                'fullNameEn' => $row['fullNameEn'],
                'shortNameUk' => $row['shortNameUk'],
                'shortNameEn' => $row['shortNameEn'],
                'region' => $row['region'],
                'state' => $row['state'],
                'type' => $row['type'],
            ]);
            $school->save();
            $schoolsIds[(string)$row['_id']] = $school->id;
        }
        echo "\n\n";

        // Users
        echo "Users...\n";
        $usersIds = [];
        $rows = \yii::$app->mongodb->getCollection('user')->find();
        foreach ($rows as $row) {
            if (!isset($schoolsIds[(string)$row['schoolId']])) {
                echo "Empty school: {$row['email']}\n";
                continue;
            }
            $user = new User([
                'email' => $row['email'],
                'type'  => $row['type'],
                'coordinator'   => $row['coordinator'],
                'firstNameUk'   => $row['firstNameUk'],
                'middleNameUk'  => $row['middleNameUk'],
                'lastNameUk'    => $row['lastNameUk'],
                'firstNameEn'   => $row['firstNameEn'],
                'middleNameEn'  => $row['middleNameEn'],
                'lastNameEn'    => $row['lastNameEn'],
                'schoolId'      => $schoolsIds[(string)$row['schoolId']],
                'isEmailConfirmed'  => $row['isEmailConfirmed'],
                'isApprovedStudent' => $row['isApprovedStudent'],
                'isApprovedCoach'   => $row['isApprovedCoach'],
                'isApprovedCoordinator' => $row['isApprovedCoordinator'],
                'passwordHash'  => $row['hash'],
                'timeCreated'   => $row['dateCreated'],
            ]);
            if (!$user->save(false)) {
                var_dump((string)$row['email']);
                var_dump($user->errors);
            } else {
                $usersIds[(string)$row['_id']] = $user->id;
            }
        }
        echo "\n\n";

        // Users approval requests
        echo "Users approval requests...\n";
        $rows = \yii::$app->mongodb->getCollection('user.approvalRequest')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $approval = new User\ApprovalRequest([
                'userId'        => $usersIds[(string)$row['userId']],
                'role'          => $row['role'],
                'timeCreated'   => $row['dateCreated'],
            ]);
            if (!$approval->save()) {
                var_dump($approval->errors);
            }
        }
        echo "\n\n";

        // Users email confirmations
        echo "Users email confirmations...\n";
        $rows = \yii::$app->mongodb->getCollection('user.emailConfirmation')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $confirmation = new User\EmailConfirmation([
                'userId'        => $usersIds[(string)$row['userId']],
                'timeConfirmed' => isset($row['dateConfirmed']) ? $row['dateConfirmed']->toDateTime()->format('U') : time(),
            ]);
            if (!$confirmation->save()) {
                var_dump($confirmation->errors);
            }
        }
        echo "\n\n";

        // Users info
        echo "Users info...\n";
        $rows = \yii::$app->mongodb->getCollection('user.info')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $user = User::findOne($usersIds[(string)$row['userId']]);
            if ($user->type === User::ROLE_STUDENT) {
                $info = new User\InfoStudent([
                    'scenario'      => User\Info::SC_ALLOW_EMPTY,
                    'userId'        => $usersIds[(string)$row['userId']],
                    'lang'          => $row['lang'],
                    'dateOfBirth'   => $row['dateOfBirth'] ?? null,
                    'phoneHome'     => $row['phoneHome'] ?? null,
                    'phoneMobile'   => $row['phoneMobile'] ?? null,
                    'skype'         => $row['skype'] ?? null,
                    'tShirtSize'    => $row['tShirtSize'] ?? null,
                    'acmNumber'     => $row['acmNumber'] ?? null,
                    'studyField'    => $row['studyField'] ?? null,
                    'speciality'    => $row['speciality'] ?? null,
                    'faculty'       => $row['faculty'] ?? null,
                    'group'         => $row['group'] ?? null,
                    'course'        => $row['course'] ?? null,
                    'document'      => $row['document'] ?? null,
                    'schoolAdmissionYear' => $row['schoolAdmissionYear'] ?? null,
                ]);
            } elseif ($user->type === User::ROLE_COACH) {
                $info = new User\InfoCoach([
                    'scenario'      => User\Info::SC_ALLOW_EMPTY,
                    'userId'        => $usersIds[(string)$row['userId']],
                    'lang'          => $row['lang'],
                    'dateOfBirth'   => $row['dateOfBirth'] ?? null,
                    'phoneHome'     => $row['phoneHome'] ?? null,
                    'phoneMobile'   => $row['phoneMobile'] ?? null,
                    'skype'         => $row['skype'] ?? null,
                    'tShirtSize'    => $row['tShirtSize'] ?? null,
                    'acmNumber'     => $row['acmNumber'] ?? null,
                    'position'      => $row['position'] ?? null,
                    'officeAddress' => $row['officeAddress'] ?? null,
                    'phoneWork'     => $row['phoneWork'] ?? null,
                    'fax'           => $row['fax'] ?? null,
                ]);
            }
            if (!$info->save()) {
                var_dump($info->errors);
            }
        }
        echo "\n\n";

        // Users photos
        echo "Users photos...\n";
        $rows = \yii::$app->mongodb->getCollection('user.photo')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $document = (new \yii\mongodb\file\Query)
                ->from('uploadedFile')
                ->andWhere(['uniqueId' => "common\\models\\User\\Photo\\{$row['_id']}"])
                ->one()
            ;
            $photo = new User\Photo([
                'userId'    => $usersIds[(string)$row['userId']],
                'content'   => $document['file']->toString(),
            ]);
            if (!$photo->save()) {
                var_dump($photo->errors);
            }
        }
        echo "\n\n";

        // Users settings
        echo "Users settings...\n";
        $rows = \yii::$app->mongodb->getCollection('user.settings')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $settings = new User\Settings([
                'userId'    => $usersIds[(string)$row['userId']],
                'year'      => $row['year'] ?? 2017,
                'geo'       => $row['geo'] ?? 'ukraine',
                'lang'      => $row['lang'] ?? 'uk',
            ]);
            if (!$settings->save()) {
                var_dump($settings->errors);
            }
        }
        echo "\n\n";

        // Teams
        echo "Teams...\n";
        $teamsIds = [];
        $rows = \yii::$app->mongodb->getCollection('team')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['coachId']])) {
                echo "Empty user ID: {$row['coachId']}\n";
                continue;
            }
            if (!isset($schoolsIds[(string)$row['schoolId']])) {
                echo "Empty school ID: {$row['_id']}\n";
                continue;
            }
            $team = new Team([
                'name'      => $row['name'],
                'year'      => $row['year'],
                'phase'     => $row['phase'],
                'coachId'   => $usersIds[(string)$row['coachId']],
                'schoolId'  => $schoolsIds[(string)$row['schoolId']],
                'baylorId'  => $row['baylorId'] ?? null,
                'league'    => $row['league'] ?? null,
                'isDeleted' => $row['isDeleted'] ?? 0,
                'isOutOfCompetition' => $row['isOutOfCompetition'] ?? 0,
            ]);
            if (!$team->save(false)) {
                var_dump($team->errors);
            } else {
                $teamsIds[(string)$row['_id']] = $team->id;
                foreach ($row['memberIds'] as $userId) {
                    $member = new Team\Member([
                        'teamId'    => $team->id,
                        'userId'    => $usersIds[$userId],
                    ]);
                    $member->save();
                }
            }
        }
        echo "\n\n";

        // Results
        echo "Results...\n";
        $rows = \yii::$app->mongodb->getCollection('results')->find();
        foreach ($rows as $row) {
            if (!isset($teamsIds[(string)$row['teamId']])) {
                echo "Empty team ID: {$row['teamId']}\n";
                continue;
            }
            $result = new Result([
                'teamId'    => $teamsIds[(string)$row['teamId']],
                'year'      => $row['year'],
                'phase'     => $row['phase'],
                'geo'       => $row['geo'],
                'place'     => $row['place'],
                'placeText' => $row['placeText'],
                'prizePlace'=> $row['prizePlace'],
                'total'     => $row['total'],
                'penalty'   => $row['penalty'],
            ]);
            if (!$result->save(false)) {
                var_dump($result->errors);
            } else {
                foreach ($row['tasksTries'] as $letter => $triesCount) {
                    $task = new Result\Task([
                        'resultId'      => $result->id,
                        'letter'        => $letter,
                        'triesCount'    => $triesCount,
                        'secondsSpent'  => $row['tasksTries'][$letter] ?? null,
                    ]);
                    $task->save();
                }
            }
        }
        echo "\n\n";

        // QA tags
        echo "QA tags...\n";
        $rows = \yii::$app->mongodb->getCollection('qa.tag')->find();
        foreach ($rows as $row) {
            $tag = new Qa\Tag([
                'name'          => $row['name'],
                'desc'          => $row['desc'],
                'timeCreated'   => $row['dateCreated'] ?? time(),
            ]);
            if (!$tag->save(false)) {
                var_dump($tag->errors);
            }
        }
        echo "\n\n";

        // QA questions
        echo "QA questions...\n";
        $questionsIds = [];
        $rows = \yii::$app->mongodb->getCollection('qa.question')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $question = new Qa\Question([
                'userId'        => $usersIds[(string)$row['userId']],
                'title'         => $row['title'],
                'content'       => $row['content'],
                'timeCreated'   => $row['dateCreated'] ?? time(),
            ]);
            if (!$question->save(false)) {
                var_dump($question->errors);
            } else {
                $questionsIds[(string)$row['_id']] = $question->id;
                foreach ($row['tagList'] as $tagName) {
                    $tag = Qa\Tag::findOne(['name' => $tagName]);
                    $tagRel = new Qa\QuestionTagRel([
                        'questionId'    => $question->id,
                        'tagId'         => $tag->id,
                    ]);
                    $tagRel->save();
                }
            }
        }
        echo "\n\n";

        // QA answers
        echo "QA answers...\n";
        $rows = \yii::$app->mongodb->getCollection('qa.answer')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $answer = new Qa\Answer([
                'userId'        => $usersIds[(string)$row['userId']],
                'questionId'    => $questionsIds[(string)$row['questionId']],
                'content'       => $row['content'],
                'timeCreated'   => $row['dateCreated'] ?? time(),
            ]);
            if (!$answer->save(false)) {
                var_dump($question->errors);
            }
        }
        echo "\n\n";

        // News
        echo "News...\n";
        $newsIds = [];
        $rows = \yii::$app->mongodb->getCollection('news')->find();
        foreach ($rows as $row) {
            $news = new News([
                'commonId'      => $newsIds[(string)$row['commonId']] ?? null,
                'lang'          => $row['lang'],
                'title'         => $row['title'],
                'content'       => $row['content'],
                'isPublished'   => $row['isPublished'],
                'geo'           => $row['geo'],
                'yearCreated'   => $row['yearCreated'],
                'timeCreated'   => $row['dateCreated'] ?? time(),
            ]);
            if (!$news->save(false)) {
                var_dump($news->errors);
            } else {
                $newsIds[(string)$row['_id']] = $news->id;
            }
        }
        echo "\n\n";

        // News images
        echo "News images...\n";
        $rows = \yii::$app->mongodb->getCollection('news.images')->find();
        foreach ($rows as $row) {
            if (!isset($newsIds[(string)$row['newsId']])) {
                echo "Empty news ID: {$row['newsId']}\n";
                continue;
            }
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $document = (new \yii\mongodb\file\Query)
                ->from('uploadedFile')
                ->andWhere(['uniqueId' => "common\\models\\News\\Image\\{$row['_id']}"])
                ->one()
            ;
            $image = new News\Image([
                'newsId'    => $newsIds[(string)$row['newsId']] ?? null,
                'userId'    => $usersIds[(string)$row['userId']] ?? null,
                'content'   => $document['file']->toString(),
            ]);
            if (!$image->save(false)) {
                var_dump($image->errors);
            }
        }
        echo "\n\n";

        // News revisions
        echo "News revisions...\n";
        $newsRevisionsIds = [];
        $rows = \yii::$app->mongodb->getCollection('news.revision')->find();
        foreach ($rows as $row) {
            if (!isset($newsIds[(string)$row['newsId']])) {
                echo "Empty news ID: {$row['newsId']}\n";
                continue;
            }
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $revision = new News\Revision([
                'newsId'            => $newsIds[(string)$row['newsId']] ?? null,
                'userId'            => $usersIds[(string)$row['userId']] ?? null,
                'newsAttributes'    => $row['newsAttributes'],
                'timeCreated'       => $row['timestamp'],
            ]);
            if (!$revision->save(false)) {
                var_dump($revision->errors);
            } else {
                $newsAttributes = $revision->newsAttributes;
                $newsAttributes['commonId'] = $newsIds[$revision->newsAttributes['commonId']];
                $revision->newsAttributes = $newsAttributes;
                $revision->save();
                $newsRevisionsIds[(string)$row['_id']] = $revision->id;
            }
        }
        echo "\n\n";

        // News publish log
        echo "News publish log...\n";
        $rows = \yii::$app->mongodb->getCollection('news.publishLog')->find();
        foreach ($rows as $row) {
            if (!isset($newsIds[(string)$row['newsId']])) {
                echo "Empty news ID: {$row['newsId']}\n";
                continue;
            }
            if (!isset($newsRevisionsIds[(string)$row['revisionId']])) {
                echo "Empty revision ID: {$row['revisionId']}\n";
                continue;
            }
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            $image = new News\PublishLog([
                'newsId'        => $newsIds[(string)$row['newsId']] ?? null,
                'revisionId'    => $newsRevisionsIds[(string)$row['revisionId']] ?? null,
                'userId'        => $usersIds[(string)$row['userId']] ?? null,
                'isPublished'   => $row['isPublished'],
                'timeCreated'   => $row['timestamp'] ?? time(),
            ]);
            if (!$image->save(false)) {
                var_dump($image->errors);
            }
        }
        echo "\n\n";

        // Documents
        echo "Documents...\n";
        $rows = \yii::$app->mongodb->getCollection('document')->find();
        foreach ($rows as $row) {
            $file = (new \yii\mongodb\file\Query)
                ->from('uploadedFile')
                ->andWhere(['uniqueId' => "common\\models\\Document\\{$row['_id']}"])
                ->one()
            ;
            $document = new Document([
                'title'         => $row['title'],
                'desc'          => $row['desc'],
                'type'          => $row['type'],
                'fileExt'       => $row['fileExt'],
                'isPublished'   => $row['isPublished'],
                'content'       => $file['file']->toString(),
                'timeCreated'   => $row['dateCreated'],
            ]);
            if (!$document->save(false)) {
                var_dump($document->errors);
            }
        }
        echo "\n\n";

        // Auth items
        echo "Auth items...\n";
        $rows = \yii::$app->mongodb->getCollection('auth.item')->find();
        foreach ($rows as $row) {
            if ($row['bizRule']) {
                $bizRule = str_replace([
                    'return \\yii::$app->rbac->bizRule',
                    '($params);',
                ], '', $row['bizRule']) . 'Rule';
                $bizRuleClass = "\\common\\rbac\\{$bizRule}";
                \yii::$app->db->createCommand()->insert('auth_rule', [
                    'name'          => $bizRule,
                    'data'          => serialize(new $bizRuleClass),
                    'created_at'    => time(),
                    'updated_at'    => null,
                ])->execute();
            } else {
                $bizRule = null;
            }
            \yii::$app->db->createCommand()->insert('auth_item', [
                'name'          => $row['name'],
                'type'          => in_array($row['name'], User::getConstants('ROLE_')) ? \yii\rbac\Item::TYPE_ROLE : \yii\rbac\Item::TYPE_PERMISSION,
                'description'   => $row['description'],
                'rule_name'     => $bizRule,
                'data'          => null,
                'created_at'    => time(),
                'updated_at'    => null,
            ])->execute();
        }
        $rows = \yii::$app->mongodb->getCollection('auth.item')->find();
        foreach ($rows as $row) {
            foreach ($row['children'] as $childName) {
                \yii::$app->db->createCommand()->insert('auth_item_child', [
                    'parent'    => $row['name'],
                    'child'     => $childName,
                ])->execute();
            }
        }
        echo "\n\n";

        // Auth assignment
        echo "Auth assignment...\n";
        $rows = \yii::$app->mongodb->getCollection('auth.assignment')->find();
        foreach ($rows as $row) {
            if (!isset($usersIds[(string)$row['userId']])) {
                echo "Empty user ID: {$row['userId']}\n";
                continue;
            }
            try {
                \yii::$app->db->createCommand()->insert('auth_assignment', [
                    'item_name'     => $row['itemName'],
                    'user_id'       => $usersIds[(string)$row['userId']],
                    'created_at'    => time(),
                ])->execute();
            } catch (\Exception $ex) {
                echo "Eror for {$row['itemName']}\n";
            }
        }
        echo "\n\n";

    }

}