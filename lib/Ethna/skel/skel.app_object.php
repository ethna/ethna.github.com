<?php
/**
 *  {$app_path}
 *
 *  @author     {$author}
 *  @package    {$project_id}
 *  @version    $Id: skel.app_object.php 532 2008-05-13 22:41:22Z mumumu-org $
 */

/**
 *  {$app_object}Manager
 *
 *  @author     {$author}
 *  @access     public
 *  @package    {$project_id}
 */
class {$app_object}Manager extends Ethna_AppManager
{
}

/**
 *  {$app_object}
 *
 *  @author     {$author}
 *  @access     public
 *  @package    {$project_id}
 */
class {$app_object} extends Ethna_AppObject
{
    /**
     *  property display name getter.
     *
     *  @access public
     */
    function getName($key)
    {
        return $this->get($key);
    }
}

?>
