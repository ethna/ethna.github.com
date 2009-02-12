<?php
/**
 *  {$action_name}.php
 *
 *  @author     {$author}
 *  @package    {$project_id}
 *  @version    $Id: skel.entry_www.php 488 2007-12-13 22:11:18Z mumumu-org $
 */
require_once '{$dir_app}/{$project_id}_Controller.php';

{$project_id}_Controller::main('{$project_id}_Controller', '{$action_name}');
?>
