<?php
/**
 *  ethna_handle.php
 *
 *  Ethna Handle Gateway
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: ethna_handle.php 647 2008-10-04 16:04:39Z mumumu-org $
 */
while (ob_get_level()) {
    ob_end_clean();
}

$base = dirname(dirname(dirname(__FILE__)));
ini_set('include_path', $base.PATH_SEPARATOR.ini_get('include_path'));

require_once 'Ethna/Ethna.php';
require_once ETHNA_BASE . '/class/Ethna_Getopt.php';

// fetch arguments
$opt = new Ethna_Getopt();
$arg_list = $opt->readPHPArgv();
if (Ethna::isError($arg_list)) {
    echo $arg_list->getMessage()."\n";
    exit(2);
}
array_shift($arg_list);  // remove "ethna_handle.php"

$eh =& new Ethna_Handle();

//  はじめの引数に - が含まれていればそれを分離する
//  含まれていた場合、それは -v|--version でなければならない
list($my_arg_list, $arg_list) = _Ethna_HandleGateway_SeparateArgList($arg_list);
$r = $opt->getopt($my_arg_list, "v", array("version"));
if (Ethna::isError($r)) {
    usage($eh);
    exit(1);
}

// ad-hoc:(
foreach ($r[0] as $opt) {
    if ($opt[0] == "v" || $opt[0] == "--version") {
        _Ethna_HandleGateway_ShowVersion();
        exit(2);
    }
}

if (count($arg_list) == 0) {
    usage($eh);
    exit(1);
}

$id = array_shift($arg_list);

$handler =& $eh->getHandler($id);
if (Ethna::isError($handler)) {
    printf("no such command: %s\n\n", $id);
    usage($eh);
    exit(1);
}

// don't know what will happen:)
$handler->setArgList($arg_list);
$r = $handler->perform();
if (Ethna::isError($r)) {
    printf("error occured w/ command [%s]\n  -> %s\n\n", $id, $r->getMessage());
    if ($r->getCode() == 'usage') {
        $handler->usage();
    }
    exit(1);
}

/**
 *  usage
 */
function usage(&$eh)
{
    $handler_list = $eh->getHandlerList();
    printf("usage: ethna [option] [command] [args...]\n\n");
    printf("available options are as follows:\n\n");
    printf("  -v, --version    show version and exit\n");
    printf("\navailable commands are as follows:\n\n");
    foreach ($handler_list as $handler) {
        printf("  %s -> %s\n", $handler->getId(), $handler->getDescription());
    }
}

/**
 *  fetch options for myself
 */
function _Ethna_HandleGateway_SeparateArgList($arg_list)
{
    $my_arg_list = array();

    //  はじめの引数に - が含まれていたら、
    //  それを $my_arg_list に入れる
    //  これは --version 判定のため 
    for ($i = 0; $i < count($arg_list); $i++) {
        if ($arg_list[$i]{0} == '-') {
            // assume this should be an option for myself
            $my_arg_list[] = $arg_list[$i];
        } else {
            break;
        }
    }
    $arg_list = array_slice($arg_list, $i);

    return array($my_arg_list, $arg_list);
}

/**
 *  show version
 */
function _Ethna_HandleGateway_ShowVersion()
{
    $version = <<<EOD
Ethna %s (using PHP %s)

Copyright (c) 2004-%s,
  Masaki Fujimoto <fujimoto@php.net>
  halt feits <halt.feits@gmail.com>
  Takuya Ookubo <sfio@sakura.ai.to>
  nozzzzz <nozzzzz@gmail.com>
  cocoitiban <cocoiti@comio.info>
  Yoshinari Takaoka <takaoka@beatcraft.com>

http://ethna.jp/

EOD;
    printf($version, ETHNA_VERSION, PHP_VERSION, date('Y'));
}
?>
