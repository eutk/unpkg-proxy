<?php
/**
 * Handle path with ease
 * If rewrite engine is on, request must handled by '/index.php' but not only '/'
 * correct statement like this: RewriteRule ^(.*)$ index.php [L,E=PATH_INFO:$1]
 * returned query will starts with '/'
 *
 * @author    YieldRay <moe@mailo.com>
 * @copyright 2021 (c) YieldRay - pathHandler
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/YieldRay/unpkg-proxy/tree/master/lib/pathHandler
 * @since     1.1.0
 */

namespace pathHandler;

function redirect()
{
    /*
    'localhost/sn.php?/path/to/file?fakeQuery'  to  'localhost/sn.php?/path/to/file&fakeQuery'
    then $_GET works
    */
    $request_uri = $_SERVER['REQUEST_URI'];
    $query_string = $_SERVER['QUERY_STRING'];

    if (strpos($query_string, '?') > 0) {
        $fixed_query = str_replace('?', '&', $query_string);
        header('Location: ' . str_replace($query_string, $fixed_query, $request_uri));
        die();
    }
}

function get($is_include_query = false)
{
    $path_info = $_SERVER['REDIRECT_PATH_INFO'] ? $_SERVER['REDIRECT_PATH_INFO'] : $_SERVER['PATH_INFO'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $query_string = $_SERVER['QUERY_STRING'];
    $script_name = $_SERVER['SCRIPT_NAME'];
    
    if ($query_string[0] === '/') {  //  localhost/[filename.php]?/query
        /* for querystring */
        if ($is_include_query) {
            return $query_string;
        } else {
            $p = strpos($query_string, '?');
            if (!$p) {
                $p = strpos($query_string, '&');
                if (!$p) {
                    return $query_string;
                }
            }
            return substr($query_string, 0, $p);
        }
    }

$computed = '/';
    if(startsWith($path_info,'/')) 
    {
        $computed = $path_info;
    }
    else{
         $computed = '/'.$path_info;
    }
    if(!$is_include_query) {
        $computed = str_replace('?'.$query_string, '', $computed);
    }
    return $computed;
}

function startsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
}
function endsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}
