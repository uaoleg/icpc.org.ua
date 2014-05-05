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
                <?=$content?>
            </div>
        </div>
    </div>

</body>
</html>