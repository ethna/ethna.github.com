<?php
/**
 *  {$view_path}
 *
 *  @author     {$author}
 *  @package    {$project_id}
 *  @version    $Id: skel.view.php 532 2008-05-13 22:41:22Z mumumu-org $
 */

 _et("view global");

/**
 *  {$forward_name} view implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    {$project_id}
 */
class {$view_class} extends {$project_id}_ViewClass
{
    /**
     *  preprocess before forwarding.
     *
     *  @access public
     */
    function preforward()
    {
        _et('view prepare');
        _et("view

   prepare
 multiple
  line");

    }
}

?>
