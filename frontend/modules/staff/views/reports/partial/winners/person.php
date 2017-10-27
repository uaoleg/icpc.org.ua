<?php if ($i): ?>
    </tr><tr>
<?php endif; ?>
<td>
    <?= \frontend\widgets\user\Name::widget(['user' => $member, 'lang' => 'uk']) ?>
</td>
<td>
    <?= \frontend\widgets\user\Name::widget(['user' => $member, 'lang' => 'en']) ?>
</td>