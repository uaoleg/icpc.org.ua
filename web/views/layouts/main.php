<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$this->pageTitle?></title>
    <link rel="icon" type="image/x-icon" href="<?=\yii::app()->theme->baseUrl?>/favicon.ico" />

    <?php
        $cs = \yii::app()->getClientScript();

        // jQuery
        $cs->registerCoreScript('jquery');

        // Bootsrtap
        $cs->registerCoreScript('bootstrap');

        // App JS
        $cs->registerScriptFile($cs->getCoreScriptUrl() . '/min/?g=js&v=' . \yii::app()->params['version']);
        $cs->registerCssFile($cs->getCoreScriptUrl() . '/min/?g=css&theme=' . \yii::app()->theme->name . '&v=' . \yii::app()->params['version']);

        // JS global vars
        $this->widget('\web\widgets\HeadScript');
    ?>

</head>


<body>

    <div id="main">

        <div class="container">
            <div class="header-title">
                <table>
                    <tr>
                        <td>
                            <img src="<?=\yii::app()->theme->baseUrl?>/images/layout/herb.png" />
                        </td>
                        <td>
                            <?=\yii::t('app', 'Ukranian Collegiate Programming Contest')?>
                        </td>
                        <td>
                            <img src="<?=\yii::app()->theme->baseUrl?>/images/layout/acm-icpc.gif" style="width: 95px;" />
                        </td>
                    </tr>
                </table>
            </div>
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?=\yii::app()->baseUrl?>/"></a>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <?php $this->widget('\web\widgets\Nav', array(
                        'class'      => 'nav navbar-nav',
                        'activeItem' => $this->getNavActiveItem('main'),
                        'itemList'   => array(
                            'news' => array(
                                'href'      => '/',
                                'caption'   => \yii::t('app', 'News'),
                            ),
                            'docs' => array(
                                'href'      => '/',
                                'caption'   => \yii::t('app', 'Docs'),
                                'itemList'  => array(
                                    'docs-regulations' => array(
                                        'href'      => $this->createUrl('/docs/regulations'),
                                        'caption'   => \yii::t('app', 'Regulations'),
                                    ),
                                    'docs-guidance' => array(
                                        'href'      => $this->createUrl('/docs/guidance'),
                                        'caption'   => \yii::t('app', 'Guidance'),
                                    ),
                                ),
                            ),
                            'lang' => array(
                                'href'      => $this->createUrl('/staff/lang'),
                                'caption'   => \yii::t('app', 'Langs'),
                                'rbac'      => 'admin',
                            ),
                        ),
                    )); ?>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (\yii::app()->user->isGuest): ?>
                            <li class="hide"><a href="<?=$this->createUrl('/auth/login')?>"><?=\yii::t('app', 'Login')?></a></li>
                        <?php else: ?>
                            <li>
                                <p class="navbar-text">
                                    <?=\yii::t('app', 'Hello')?>,
                                    <a href="#"><?=\yii::app()->user->getInstance()->firstName?></a>
                                </p>
                            </li>
                            <li><a href="<?=$this->createUrl('/auth/logout')?>"><?=\yii::t('app', 'Logout')?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
            <?=$content?>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-static-bottom" role="navigation">
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?=\yii::t('app', 'Developed by')?>
                    <a href="http://www.dataart.ru" target="_blank" class="inline">DataArt</a>
                </li>
                <li class="dropdown dropup language-select">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?=isset(\yii::app()->params['languages'][\yii::app()->language])
                            ? \yii::app()->params['languages'][\yii::app()->language]
                            : \yii::t('app', 'Language')
                        ?> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach (\yii::app()->params['languages'] as $langKey => $langVal): ?>
                        <li>
                            <a href="<?=$this->createUrl('/setting/lang', array(
                                'code' => $langKey,
                            ))?>" data-lang="<?=$langKey?>"><?=$langVal?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

</body>

</html>