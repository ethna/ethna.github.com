<?php
/**
 *  {$action_name}.php
 *
 *  @author     {$author}
 *  @package    Docbook
 *  @version    $Id: skel.entry_cli.php 488 2007-12-13 22:11:18Z mumumu-org $
 */
chdir(dirname(__FILE__));
require_once '{$dir_app}/Docbook_Controller.php';

ini_set('max_execution_time', 0);

Docbook_Controller::main_CLI('Docbook_Controller', '{$action_name}');
?>
