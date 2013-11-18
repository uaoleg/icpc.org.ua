<span class="label label-danger"><?=\yii::t('app', 'To manage news, you must specify your school on the {a}profile page{/a}.', array(
    '{a}'  => '<a href="' . $this->createUrl('/user/me') . '">',
    '{/a}' => '</a>',
))?></span>