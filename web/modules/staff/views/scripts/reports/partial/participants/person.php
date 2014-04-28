<td>
    <?=\web\widgets\user\Name::create(array('user' => $member, 'lang' => 'uk'), true)?><br>
    <?=\web\widgets\user\Name::create(array('user' => $member, 'lang' => 'en'), true)?>
</td>
<td><?=$member->email?></td>
<td>
    <?=\yii::t('app', 'м.:')?><?=$member->info->phoneMobile?><br>
    <?=\yii::t('app', 'д.:')?><?=$member->info->phoneHome?>
</td>
<td><?=$member->info->tShirtSize?></td>
<td><?=array_pop(explode('/', $member->info->dateOfBirth))?></td>
<td><?=(isset($member->info->schoolAdmissionYear)) ? $member->info->schoolAdmissionYear : ''?></td>
<td><?=(isset($member->info->course)) ? $member->info->course : ''?></td>