<?php
// vim: foldmethod=marker
/**
 *  Docbook_ActionForm.php
 *
 *  @author     Sotaro KARASAWA <sotrao.k@gmail.com>
 *  @package    Docbook
 *  @version    $Id: app.actionform.php 568 2008-06-07 22:55:10Z mumumu-org $
 */

// {{{ Docbook_ActionForm
/**
 *  ActionForm class.
 *
 *  @author     Sotaro KARASAWA <sotrao.k@gmail.com>
 *  @package    Docbook
 *  @access     public
 */
class Docbook_ActionForm extends Ethna_ActionForm
{
    /**#@+
     *  @access private
     */

    /** @var    array   form definition (default) */
    var $form_template = array();

    /**#@-*/

    /**
     *  Error handling of form input validation.
     *
     *  @access public
     *  @param  string      $name   form item name.
     *  @param  int         $code   error code.
     */
    function handleError($name, $code)
    {
        return parent::handleError($name, $code);
    }

    /**
     *  setter method for form template.
     *
     *  @access protected
     *  @param  array   $form_template  form template
     *  @return array   form template after setting.
     */
    function _setFormTemplate($form_template)
    {
        return parent::_setFormTemplate($form_template);
    }

    /**
     *  setter method for form definition.
     *
     *  @access protected
     */
    function _setFormDef()
    {
        return parent::_setFormDef();
    }

}
// }}}

?>
