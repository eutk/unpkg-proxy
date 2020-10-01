<?php
namespace pathHandler;

function redirect()
{
    /*
    'localhost/sn.php?/path/to/file?fakeQuery'
    to
    'localhost/sn.php?/path/to/file&fakeQuery'
    then $_GET works
    */
    $uri   = $_SERVER['REQUEST_URI'];
    $query = $_SERVER['QUERY_STRING'];
    if (strpos($query, '?') > 0) {
        $fixed_query = str_replace('?', '&', $query);
        header('Location: ' . str_replace($query, $fixed_query, $uri));
        die();
    }
}

function get($is_include_query = false)
{
    $pi    = $_SERVER['PATH_INFO'];
    $uri   = $_SERVER['REQUEST_URI'];
    $query = $_SERVER['QUERY_STRING'];
    
    if (isset($pi) && strlen($pi) > 0) {
        
        if (!$is_include_query)
            return $pi;
        //$_pi = str_replace('/', '\/', $pi);
        $sn = addcslashes($_SERVER['SCRIPT_NAME'], '/');
        if (preg_match("/{$sn}(.+)$/", $uri, $matches)) {
            return $matches[1];
        }
        
    }
    
    if ($query[0] === '/') {
        
        if ($is_include_query) {
            return $query;
        } else {
            preg_match('/([\w+|\/]*)/', $query, $matches2);
            return $matches2[1];
        }
        
    }
    
    return '/';
}