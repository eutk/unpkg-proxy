<?php
/**
 * Script for test
*/
require_once("./main.php");
\pathHandler\redirect();

$path0 = \pathHandler\get(0);
$path1 = \pathHandler\get(1);

echo "no querystring $path0";
echo PHP_EOL;
echo "has querystring $path1";
echo PHP_EOL;
print_r($_SERVER);