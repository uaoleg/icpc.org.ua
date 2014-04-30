<td>
    <?=\web\widgets\user\Name::create(array('user' => $member, 'lang' => 'uk'), true)?>
</td>
<td>
    <?=\web\widgets\user\Name::create(array('user' => $member, 'lang' => 'en'), true)?>
</td>
<td><?=$member->email?></td>
<td>
    <?php if (!empty($member->info->phoneMobile)): ?>
        <?=\yii::t('app', 'Mobile phone')?>:<?=$member->info->phoneMobile?>
        <br />
    <?php endif; ?>
    <?php if (!empty($member->info->phoneMobile)): ?>
        <?=\yii::t('app', 'Home phone')?>:<?=$member->info->phoneHome?>
    <?php endif; ?>
</td>
<td><?=$member->info->tShirtSize?></td>
<td><?=array_pop(explode('/', $member->info->dateOfBirth))?></td>
<td><?=(isset($member->info->schoolAdmissionYear)) ? $member->info->schoolAdmissionYear : ''?></td>
<td><?=(isset($member->info->course)) ? $member->info->course : ''?></td>