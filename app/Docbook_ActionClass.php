<?php
// vim: foldmethod=marker
/**
 *  Docbook_ActionClass.php
 *
 *  @author     Sotaro KARASAWA <sotrao.k@gmail.com>
 *  @package    Docbook
 *  @version    $Id: app.actionclass.php 532 2008-05-13 22:41:22Z mumumu-org $
 */

// {{{ Docbook_ActionClass
/**
 *  action execution class
 *
 *  @author     Sotaro KARASAWA <sotrao.k@gmail.com>
 *  @package    Docbook
 *  @access     public
 */
class Docbook_ActionClass extends Ethna_ActionClass
{
    /**
     *  authenticate before executing action.
     *
     *  @access public
     *  @return string  Forward name.
     *                  (null if no errors. false if we have something wrong.)
     */
    function authenticate()
    {
        return parent::authenticate();
    }

    /**
     *  Preparation for executing action. (Form input check, etc.)
     *
     *  @access public
     *  @return string  Forward name.
     *                  (null if no errors. false if we have something wrong.)
     */
    function prepare()
    {
        return parent::prepare();
    }

    /**
     *  execute action.
     *
     *  @access public
     *  @return string  Forward name.
     *                  (we does not forward if returns null.)
     */
    function perform()
    {
        return parent::perform();
    }
}
// }}}

?>
