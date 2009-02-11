<?php
/**
 *  {$app_path}
 *
 *  @author     {$author}
 *  @package    Docbook
 *  @version    $Id: skel.app_object.php 532 2008-05-13 22:41:22Z mumumu-org $
 */

/**
 *  {$app_object}Manager
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Docbook
 */
class {$app_object}Manager extends Ethna_AppManager
{
}

/**
 *  {$app_object}
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Docbook
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
