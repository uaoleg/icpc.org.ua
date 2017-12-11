<?php

/* @var $this \yii\web\View */

use \common\models\User;
use \yii\helpers\Html;
use \yii\helpers\Json;
use \yii\helpers\Url;

$user = \yii::$app->user->identity;

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=\yii::$app->language?>">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/x-icon" href="<?=Url::to('@web/favicon.ico')?>" />
    <?=\frontend\widgets\HeadScript::widget()?>
    <?php $this->head() ?>
</head>


<body>

    <?php $this->beginBody() ?>

    <?=\frontend\widgets\AppEnv::widget()?>

    <script>
        new appBootstrap(<?= Json::encode([
            'baseUrl'   => '',
            'homeUrl'   => \yii::$app->homeUrl,
            'language'  => \yii::$app->language,
            'csrfToken' => \yii::$app->request->csrfToken,
            'formatter' => [
                'dateFormat'        => \DATE_FORMAT_JS,
                'datetimeFormat'    => \DATE_TIME_FORMAT_JS,
            ],
            'user' => [
                'isGuest' => \yii::$app->user->isGuest,
            ],
        ]) ?>);
    </script>

    <div id="main">

        <div class="container">
            <div class="header-title">
                <table>
                    <tr>
                        <td>
                            <img src="<?=Url::to('@web/images/layout/icpc.png')?>" style="width: 98px;" />
                        </td>
                        <td>
                            <?=\yii::t('app', 'Ukrainian Collegiate Programming Contest')?>
                        </td>
                        <td>
                            <img src="<?=Url::to('@web/images/layout/acm-icpc.gif')?>" style="width: 95px;" />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="slogan">
                &mdash; «<?=\yii::t('app', 'Do it with us, do it like us, do it better than us!')?>»
            </div>
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <?php if ($user && !empty($user->coordinator) && !$user->isApprovedCoordinator): ?>
                        <div class="alert alert-danger text-center">
                            <?=\yii::t('app', '<b>Warning!</b> Your coordinator status is not approved yet!')?><br/>
                            <?php if ($user->approver): ?>
                                <?=\yii::t('app', '{a_}{person}{_a} can approve your status.', [
                                    'a_'      => '<a href="' . Url::toRoute(['/user/view', 'id' => $user->approver->id]) . '">',
                                    'person'  => \frontend\widgets\user\Name::widget(['user' => $user->approver]),
                                    '_a'      => '</a>'
                                ])?>
                            <?php endif; ?>
                            <br><br>
                            <button type="button" class="btn btn-default js-user-approval-request-button <?= User\ApprovalRequest::isSentRecently(\yii::$app->user->id, User\ApprovalRequest::ROLE_COORDINATOR) ? 'hide' : '' ?>"
                                    data-role="<?= User\ApprovalRequest::ROLE_COORDINATOR ?>">
                                <?= \yii::t('app', 'Send approval request') ?>
                            </button>
                            <p class="js-user-approval-request-label <?= !User\ApprovalRequest::isSentRecently(\yii::$app->user->id, User\ApprovalRequest::ROLE_COORDINATOR) ? 'hide' : '' ?>">
                                <?=\yii::t('app', 'Your request has been recently sent. You can send next request in a day.')?>
                            </p>
                        </div>
                        <script>
                            $(document).ready(function() {
                                new appUserApprovalRequest();
                            });
                        </script>
                    <?php endif; ?>
                    <?php if ($user && ($user->type === \common\models\User::ROLE_COACH) && (!$user->isApprovedCoach)): ?>
                        <div class="alert alert-danger text-center">
                            <?=\yii::t('app', '<b>Warning!</b> Your coach status is not approved yet!')?><br/>
                            <?php if ($user->approver): ?>
                                <?=\yii::t('app', '{a}{person}{/a} can approve your status.', [
                                    'a'       => '<a href="' . Url::toRoute(['/user/view', 'id' => $user->approver->id]) . '">',
                                    'person'  => \frontend\widgets\user\Name::widget(['user' => $user->approver]),
                                    '/a'      => '</a>'
                                ])?>
                            <?php endif; ?>
                            <br><br>
                            <button type="button" class="btn btn-default js-user-approval-request-button <?= User\ApprovalRequest::isSentRecently(\yii::$app->user->id, User\ApprovalRequest::ROLE_COACH) ? 'hide' : '' ?>"
                                    data-role="<?= User\ApprovalRequest::ROLE_COACH ?>">
                                <?= \yii::t('app', 'Send approval request') ?>
                            </button>
                            <p class="js-user-approval-request-label <?= !User\ApprovalRequest::isSentRecently(\yii::$app->user->id, User\ApprovalRequest::ROLE_COACH) ? 'hide' : '' ?>">
                                <?=\yii::t('app', 'Your request has been recently sent. You can send next request in a day.')?>
                            </p>
                        </div>
                        <script>
                            $(document).ready(function() {
                                new appUserApprovalRequest();
                            });
                        </script>
                    <?php endif; ?>
                    <?php if (\yii::$app->user->getState(\frontend\models\WebUser::SESSION_INFO_NOT_FULL)): ?>
                        <div class="alert alert-danger text-center">
                            <?= \yii::t('app', 'Please fill in your additional info in {uk}ukrainian{/a} and {en}english{/a} languages', array(
                                'uk' => '<a href="' . Url::toRoute(['/user/additional', 'lang' => 'uk']) . '">',
                                'en' => '<a href="' . Url::toRoute(['/user/additional', 'lang' => 'en']) . '">',
                                '/a' => '</a>'
                            )) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?=Url::toRoute(['/'])?>/"></a>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <?=\frontend\widgets\Nav::widget(array(
                            'cssClass'   => 'nav navbar-nav',
                            'activeItem' => \yii::$app->controller->getNavActiveItem('main'),
                            'itemList'   => array(
                                'news' => array(
                                    'href'      => '/',
                                    'caption'   => \yii::t('app', 'News'),
                                ),
                                'docs' => array(
                                    'href'      => '#',
                                    'caption'   => \yii::t('app', 'Docs'),
                                    'itemList'  => array(
                                        'docs-regulations' => array(
                                            'href'      => Url::toRoute(['/docs/regulations']),
                                            'caption'   => \yii::t('app', 'Regulations'),
                                        ),
                                        'docs-guidance' => array(
                                            'href'      => Url::toRoute(['/docs/guidance']),
                                            'caption'   => \yii::t('app', 'Guidance'),
                                        ),
                                    ),
                                ),
                                'team' => array(
                                    'href'     => Url::toRoute(['/team/list']),
                                    'caption'  => \yii::t('app', 'Teams'),
                                ),
                                'results' => array(
                                    'href'      => '/results',
                                    'caption'   => \yii::t('app', 'Results'),
                                ),
                                'users' => array(
                                    'href'      => '#',
                                    'caption'   => \yii::t('app', 'Users'),
                                    'rbac'      => \common\models\User::ROLE_COORDINATOR_STATE,
                                    'itemList'  => array(
                                        'users-students' => array(
                                            'href'      => Url::toRoute(['/staff/students']),
                                            'caption'   => \yii::t('app', 'Students'),
                                        ),
                                        'users-coaches' => array(
                                            'href'      => Url::toRoute(['/staff/coaches']),
                                            'caption'   => \yii::t('app', 'Coaches'),
                                        ),
                                        'users-coordinators' => array(
                                            'href'      => Url::toRoute(['/staff/coordinators']),
                                            'caption'   => \yii::t('app', 'Coordinators'),
                                        ),
                                    ),
                                ),
                                'qa' => array(
                                    'href'     => Url::toRoute(['/qa']),
                                    'caption'  => \yii::t('app', 'Q&A'),
                                ),
                                'admin' => array(
                                    'href'      => '#',
                                    'caption'   => \yii::t('app', 'Admin'),
                                    'rbac'      => \common\models\User::ROLE_COORDINATOR_UKRAINE,
                                    'itemList'  => array(
                                        'lang' => array(
                                            'href'      => Url::toRoute(['/staff/lang']),
                                            'caption'   => \yii::t('app', 'Langs'),
                                        ),
                                        'organizations' => array(
                                            'href'      => Url::toRoute(['/staff/organizations']),
                                            'caption'   => \yii::t('app', 'Organizations'),
                                        ),
                                    ),
                                ),
                            ),
                        ))?>
                        <ul class="nav navbar-nav navbar-right">
                            <?php if (\yii::$app->user->isGuest): ?>
                                <li><a href="<?=Url::toRoute(['/auth/login'])?>"><?=\yii::t('app', 'Login')?></a></li>
                            <?php else: ?>
                                <li>
                                    <p class="navbar-text">
                                        <?=\yii::t('app', 'Hello')?>,
                                        <a href="<?=Url::toRoute(['/user/me'])?>"><?=\frontend\widgets\user\Name::widget([
                                            'user'  => $user,
                                            'view'  => \frontend\widgets\user\Name::VIEW_FIRST,
                                            'lang'  => 'uk',
                                        ])?></a>
                                    </p>
                                </li>
                                <li><a href="<?=Url::toRoute(['/auth/logout'])?>"><?=\yii::t('app', 'Logout')?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <?=$content?>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-static-bottom" role="navigation">
        <div class="container-fluid">
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        &copy; <?=date('Y')?>
                        <a href="http://olymp.dp.ua/" target="_blank" class="inline"
                           title="<?=\yii::t('app', 'Regional Distant Center for University and School Olympiads at DNU Oles\' Honchar')?>"
                           rel="tooltip"><?= \yii::t('app', 'RDCUSO') ?></a>,
                        <a href="http://www.dataart.ua" target="_blank" class="inline">DataArt</a>
                    </li>
                    <li>
                        <a href="https://github.com/uaoleg/icpc.org.ua" target="_blank" class="inline">
                            <span class="img-layout-github-24"></span></a>
                        <a href="https://github.com/uaoleg/icpc.org.ua" target="_blank" class="inline">GitHub</a>
                    </li>
                    <li>
                        <a href="https://twitter.com/IcpcOrgUa" target="_blank" class="inline">
                            <span class="img-layout-twitter-24"></span></a>
                        <a href="https://twitter.com/IcpcOrgUa" target="_blank" class="inline">Twitter</a>
                    </li>
                    <li>
                        <span class="img-layout-mail-24"></span>
                        <?=\frontend\widgets\Mailto::widget(array('email' => 'info@icpc.org.ua', 'attr' => array('class'=>'inline')))?>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropup language-select">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none;">
                            <span class="img-language-<?=\yii::$app->language?>-16"></span>
                            <?=isset(\yii::$app->params['languages'][\yii::$app->language])
                                ? \yii::$app->params['languages'][\yii::$app->language]
                                : \yii::t('app', 'Language')
                            ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach (\yii::$app->params['languages'] as $langKey => $langVal): ?>
                            <li>
                                <a href="<?=Url::toRoute(['/setting/lang', 'code' => $langKey])?>" data-lang="<?=$langKey?>">
                                    <span class="img-language-<?=$langKey?>-16"></span>
                                    <?=$langVal?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?=\frontend\widgets\GoogleAnalytics::widget()?>

    <?php $this->endBody() ?>

</body>

</html>

<?php $this->endPage() ?>
