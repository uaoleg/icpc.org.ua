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
    <style>
        table > thead > tr > th {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table width="100%" border="1">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th><?=\yii::t('app', 'University full name (ukrainian and english), team name')?></th>
                            <th colspan="2"><?=\yii::t('app', 'Full names of students and coach')?></th>
                            <th><?=\yii::t('app', 'E-mail')?></th>
                            <th><?=\yii::t('app', 'Phone number (mobile, home, work)')?></th>
                            <th><?=\yii::t('app', 'T-shirt size')?></th>
                            <th><?=\yii::t('app', 'Year of birth')?></th>
                            <th><?=\yii::t('app', 'Admission year')?></th>
                            <th><?=\yii::t('app', 'Year')?></th>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th><?=\yii::t('app', 'Ukrainian language')?></th>
                            <th><?=\yii::t('app', 'English language')?></th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($participants as $participant): ?>
                            <tr>
                                <td rowspan="4"><?=$i++?></td>
                                <td rowspan="4">
                                    <p>
                                        <?=$participant['schoolNameUk']?><br/><br/>
                                        <?=$participant['schoolNameEn']?><br/><br/>
                                        <strong><?=$participant['teamName']?></strong>
                                    </p>
                                </td>
                                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][0])); ?>
                            </tr>
                            <tr>
                                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][1])); ?>
                            </tr>
                            <tr>
                                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][2])); ?>
                            </tr>
                            <tr>
                                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['coach'])); ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>