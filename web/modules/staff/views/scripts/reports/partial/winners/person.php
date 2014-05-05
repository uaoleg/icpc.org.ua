<?php if ($i): ?>
    </tr><tr>
<?php endif; ?>
<td>
    <?=\web\widgets\user\Name::create(array('user' => $member, 'lang' => 'uk'), true)?>
</td>
<td>
    <?=\web\widgets\user\Name::create(array('user' => $member, 'lang' => 'en'), true)?>
</td>