<?php
/* 检测curl(可选)
if (!in_array('curl', get_loaded_extensions())) {
            throw new Exception('You need to install cURL, see: http://curl.haxx.se/docs/install.html');
        }
*/
$sn = $_SERVER['SCRIPT_NAME'];
$self = $_SERVER['PHP_SELF'];
$query = ltrim($_SERVER['QUERY_STRING'], '/');
$regexp = '/' . addcslashes($sn,'/') . '\/(.+)$/';
header("Pragma: cache");
header('Access-Control-Allow-Origin:*');
header('Access-Control-Max-Age: 86400');  //1day
/*
header("Vary: Accept-Encoding");
$offset = 30*60*60*24; // cache 1 month
$ExpStr = "Expires: ".gmdate("D, d M Y H:i:s", time() + $offset)." GMT";
header($ExpStr);
*/
if (str_split($_SERVER['QUERY_STRING'])[0]=='/') {
    header("Location: {$sn}/{$query}");
    die();
} else {
    if (preg_match($regexp, $self, $matches)) {
        $target = "https://unpkg.com/" . $matches[1];
        //@ print_r($_SERVER);echo "<br />";
    } else {
        if($show_html = @file_get_contents('unpkg.html')){
            // 获取本地文件，否则获取unpkg界面
            echo $show_html;
            }else{
                echo str_replace('="/', '="./', file_get_contents('https://unpkg.com'));
            }
    }
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 40);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
// 获取输出内容
$res = curl_exec($ch);
// 检查是否有错误发生
if ($errno = curl_errno($ch)) {
    die(curl_strerror($errno));
} else {
    $info = curl_getinfo($ch);
    //@ print_r($info);
    $redirect_url = $info['redirect_url'];
    if ($redirect_url) { // 转发跳转
        preg_match("/^https:\/\/unpkg.com\/(.+)$/", $redirect_url, $matches)
         ? (substr_count($_SERVER['PATH_TRANSLATED'],'redirect:')>0 ? header("Location: /{$matches[1]}") : header("Location: {$sn}/{$matches[1]}"))
         : die("An error occurred while redirecting \n Detail: $redirect_url");
    }
    $type = $info['content_type'];
    header("Content-Type:" . $type);
}
curl_close($ch);
if ($type == "text/html; charset=utf-8") { // 添加base标签
    substr_count($_SERVER['PATH_TRANSLATED'],'redirect:')>0
    ? ''
    : $res = "<base href=\"{$self}\">{$res}";
    // $res = str_replace('<head>', "<head><base href=\"{$self}\">", $res);
}
header("Cache-Control: public, max-age=31536000");  //1month
header("strict-transport-security: max-age=31536000; includeSubDomains; preload");
header("x-content-type-options: nosniff");
echo $res;
