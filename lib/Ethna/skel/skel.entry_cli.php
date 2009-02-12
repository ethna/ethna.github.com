<?php
/**
 *  {$action_name}.php
 *
 *  @author     {$author}
 *  @package    {$project_id}
 *  @version    $Id: skel.entry_cli.php 488 2007-12-13 22:11:18Z mumumu-org $
 */
chdir(dirname(__FILE__));
require_once '{$dir_app}/{$project_id}_Controller.php';

ini_set('max_execution_time', 0);

{$project_id}_Controller::main_CLI('{$project_id}_Controller', '{$action_name}');
?>
