<?php
require_once("main.php");  // 引入库文件
\pathHandler\redirect();  // 处理$_GET失效问题

function get_path($arg=0){
    return \pathHandler\get($arg);
}

echo "no query:  ".get_path()."<br>"."has query: ".get_path(1)."<br>";
 print_r($_SERVER);
