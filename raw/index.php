<?php
require_once('../lib/MimeType/MimeType.php');
require_once('../lib/MimeType/MimeTypesCollection.php');
require_once('../lib/pathHandler/main.php');
use Josantonius\MimeType\MimeType;
\pathHandler\redirect();
$path0 = \pathHandler\get(0);
$path1 = \pathHandler\get(1);

header('Access-Control-Allow-Origin: *');
if (strlen($path0) <= 7) {
    die('Please enter the correct path.');
}


if (preg_match("/.*(\.\w[^\/]+)$/i", $path0, $matches)) {
    $ext = $matches[1];
    $c_t = MimeType::getMimeFromExtension($ext);
    header("Content-Type: $c_t");
    $url = 'https://raw.githubusercontent.com' . $path0;
} else if (endsWith($path0, '/')) {
    header("Content-Type: text/html");
    $url = 'https://raw.githubusercontent.com' . $path0 . 'index.html';
} else {
    die('The requested path ususally ends with \'/\' .<br />Please check:  https://raw.githubusercontent.com' . $path0);
}

$text = file_get_contents($url);
if ($text)
    echo $text;
else
    die('No content was retrieved.<br />You may have entered the wrong path which is not exists.<br /> Or you may need to specify the branch name.(e.g. add \'master/\' in the end of the path)<br /> Please check:  https://raw.githubusercontent.com' . $path0);


function startsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
}
function endsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}