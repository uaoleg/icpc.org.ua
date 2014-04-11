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
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th><?=\yii::t('app', 'University full name, team name')?></th>
                            <th><?=\yii::t('app', 'Full names of students and coach')?></th>
                            <th><?=\yii::t('app', 'E-mail')?></th>
                            <th><?=\yii::t('app', 'Phone number')?></th>
                            <th><?=\yii::t('app', 'T-shirt size')?></th>
                            <th><?=\yii::t('app', 'Year of birth')?></th>
                            <th><?=\yii::t('app', 'Admission year')?></th>
                            <th><?=\yii::t('app', 'Year')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($participants as $participant): ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><?=$participant['schoolNameUk']?></td>
                                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][0])); ?>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?=$participant['schoolNameEn']?></td>
                                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][1])); ?>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong><?=$participant['teamName']?></strong></td>
                                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][2])); ?>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
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