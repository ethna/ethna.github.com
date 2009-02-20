<?php
/**
 *
 *
 */


function __autoload($class)
{
    $dirs = array(
        'app/db',
    );

    foreach ($dirs as $dir) {
        if (file_exists(BASE . "/{$dir}/" . $class . ".php")) {
            require_once BASE . "/{$dir}/" . $class . ".php";
            return true;
        }
    }

    if (file_exists("./" . $class . ".php")) {
        require_once "./" . $class . ".php";
        return true;
    }
    else {
        foreach(explode(":", ini_get('include_path')) as $dir) {
            if (file_exists($dir . "/" . $class . ".php")) {
                require_once $dir . "/" . $class . ".php";
                return true;
            }
        }
    }
}

function vd ($mixed)
{
    var_dump($mixed);
}

function h ($mixed)
{
    return htmlspecialchars($mixed, ENT_QUOTES);
}

function a ()
{
    return array(func_get_args());
}

function mes($str)
{
    return mysql_real_escape_string($str);
}
