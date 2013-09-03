<?php

$params = array(
);

// Local configuration
$file = __DIR__ . '/local/params.php';
if (is_file($file))
    $params = \CMap::mergeArray($params, require($file));

return $params;