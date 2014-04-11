<!DOCTYPE html>
<html lang="<?=\yii::app()->language?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$this->pageTitle?></title>
    <link rel="icon" type="image/x-icon" href="<?=\yii::app()->theme->baseUrl?>/favicon.ico" />
    <?php
    $cs = \yii::app()->clientScript;
    // Bootsrtap
    $cs->registerCoreScript('bootstrap');
    // MSIE fixes
    if (\yii::app()->request->userAgentIsMsie()) {
        $cs->registerCoreScript('msie');
    }
    ?>
</head>
<body>
<?php //var_dump($winners); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                            <th><?=\yii::t('app', 'Place')?></th>
                            <th><?=\yii::t('app', 'Team name')?></th>
                            <th><?=\yii::t('app', 'University full name')?></th>
                            <th><?=\yii::t('app', 'Names of students and coach')?></th>
                            <th><?=\yii::t('app', 'Tasks count')?></th>
                            <th><?=\yii::t('app', 'Total time')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($winners as $winner): ?>
                        <tr>
                            <td><?=$winner['place']?></td>
                            <td><?=$winner['teamName']?></td>
                            <td><?=$winner['schoolName']?></td>
                            <td>
                                <?php for ($i = 0; $i < count($winner['members']); $i++): ?>
                                    <?=\web\widgets\user\Name::create(array('user' => $winner['members'][$i], 'lang' => 'uk'), true)?>,
                                    <?=\web\widgets\user\Name::create(array('user' => $winner['members'][$i], 'lang' => 'en'), true)?>;<br>
                                <?php endfor; ?>
                                <?php if(isset($winner['coach'])): ?>
                                    <strong><?=\yii::t('app', 'Coach')?>:</strong>
                                    <?=\web\widgets\user\Name::create(array('user' => $winner['coach'], 'lang' => 'uk'), true)?>,
                                    <?=\web\widgets\user\Name::create(array('user' => $winner['coach'], 'lang' => 'en'), true)?>;
                                <?php endif; ?>
                            </td>
                            <td><?=$winner['tasks']?></td>
                            <td><?=$winner['totalTime']?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>