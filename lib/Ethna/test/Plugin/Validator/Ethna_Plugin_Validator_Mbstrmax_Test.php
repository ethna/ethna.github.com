<?php
// vim: foldmethod=marker
/**
 *  Ethna_Plugin_Validator_Mbstrmax_Test.php
 */

/**
 *  Ethna_Plugin_Validator_Mbstrmaxクラスのテストケース
 *
 *  @access public
 */
class Ethna_Plugin_Validator_Mbstrmax_Test extends Ethna_UnitTestBase
{
    var $vld;

    function setUp()
    {
        $ctl =& Ethna_Controller::getInstance();
        $plugin =& $ctl->getPlugin();
        $this->vld = $plugin->getPlugin('Validator', 'Mbstrmax');
    }

    // {{{ test max mbstr 
    function test_max_mbstr()
    {
        $form_mbstr = array(
                          'type'          => VAR_TYPE_STRING,
                          'required'      => true,
                          'mbstrmax'      => '3',
                          );
        $this->vld->af->setDef('namae_mbstr', $form_mbstr);

        $pear_error = $this->vld->validate('namae_mbstr', 'あいう', $form_mbstr);
        $this->assertFalse(is_a($pear_error, 'Ethna_Error'));

        $pear_error = $this->vld->validate('namae_mbstr', 'あいうえ', $form_mbstr);
        $this->assertTrue(is_a($pear_error, 'Ethna_Error'));
        $this->assertEqual(E_FORM_MAX_STRING,$pear_error->getCode());

        //  TODO: Error Message Test.
    } 
    // }}}

}

?>
