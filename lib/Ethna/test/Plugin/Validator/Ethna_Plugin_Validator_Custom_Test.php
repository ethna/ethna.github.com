<?php
// vim: foldmethod=marker
/**
 *  Ethna_Plugin_Validator_Custom_Test.php
 */

/**
 *  Ethna_Plugin_Validator_Customクラスのテストケース
 *
 *  @access public
 */
class Ethna_Plugin_Validator_Custom_Test extends Ethna_UnitTestBase
{
    var $vld;

    function setUp()
    {
        $ctl =& Ethna_Controller::getInstance();
        $plugin =& $ctl->getPlugin();
        $this->vld = $plugin->getPlugin('Validator', 'Custom');
    }

    // {{{ checkMailAddress
    function test_checkMailAddress()
    {
        // mailaddressカスタムチェックのテスト
        $form_string = array(
                             'type'          => VAR_TYPE_STRING,
                             'required'      => true,
                             'custom' => 'checkMailaddress',
                             );
        $this->vld->af->form_vars['namae_string'] = 'hoge@fuga.net';
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = '-hoge@fuga.net';
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = '.hoge@fuga.net';
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = '+hoge@fuga.net';
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        // @がない
        $this->vld->af->form_vars['namae_string'] = 'hogefuga.net';
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));

        // @の前に文字がない
        $this->vld->af->form_vars['namae_string'] = '@hogefuga.net';
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));

        // @の後に文字がない
        $this->vld->af->form_vars['namae_string'] = 'hogefuga.net@';
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));

        // 先頭文字が許されていない
        $this->vld->af->form_vars['namae_string'] = '%hoge@fuga.net';
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));

        // 末尾文字が許されていない
        $this->vld->af->form_vars['namae_string'] = 'hoge@fuga.net.';
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));
    }
    // }}}

    // {{{ checkBoolean
    function test_checkBoolean()
    {
        //    このテストは、純粋に Ethna_ActionForm#checkBoolean のテスト
        //    であり、Ethna_ActionForm#validate を通していないことに注意。
        //
        //    空文字列, false, 空配列などは、Ethna_ActionForm#Validateを
        //    通すと、'required' => true という設定の時点でエラーと判定さ
        //    れる。また、HTML Form からboolean型が入ることは基本的にない。
        //
        //    @see http://php.benscom.com/manual/ja/types.comparisons.php
        $form_boolean = array(
                              'type'          => VAR_TYPE_BOOLEAN,
                              'required'      => true,
                              'custom' => 'checkBoolean',
                              );

        $this->vld->af->form_vars['namae_boolean'] = true;
        $this->assertTrue($this->vld->validate('namae_boolean', '', $form_boolean));

        $this->vld->af->form_vars['namae_boolean'] = false;
        $this->assertTrue($this->vld->validate('namae_boolean', '', $form_boolean));

        $this->vld->af->form_vars['namae_boolean'] = '';
        $this->assertTrue($this->vld->validate('namae_boolean', '', $form_boolean));

        $this->vld->af->form_vars['namae_boolean'] = array();
        $this->assertTrue($this->vld->validate('namae_boolean', '', $form_boolean));

        $this->vld->af->form_vars['namae_boolean'] = array(true);
        $this->assertTrue($this->vld->validate('namae_boolean', '', $form_boolean));

        // 0,1以外の値
        $this->vld->af->form_vars['namae_boolean'] = 3;
        $this->assertFalse($this->vld->validate('namae_boolean', '', $form_boolean));
    }
    // }}}

    // {{{ checkURL
    function test_checkURL()
    {
        //    このテストは、純粋に Ethna_ActionForm#checkBoolean のテスト
        //    であり、Ethna_ActionForm#validate を通していないことに注意。
        //
        //    空文字列, false, 空配列などは、Ethna_ActionForm#Validateを
        //    通すと、'required' => true という設定の時点でエラーと判定さ
        //    れる。
        $form_url = array(
                          'type'          => VAR_TYPE_STRING,
                          'required'      => true,
                          'custom' => 'checkURL',
                          );
        $this->vld->af->form_vars['namae_url'] = 'http://uga.net';
        $this->assertTrue($this->vld->validate('namae_url', '', $form_url));

        $this->vld->af->form_vars['namae_url'] = 'https://uga.net';
        $this->assertTrue($this->vld->validate('namae_url', '', $form_url));

        $this->vld->af->form_vars['namae_url'] = 'ftp://uga.net';
        $this->assertTrue($this->vld->validate('namae_url', '', $form_url));

        $this->vld->af->form_vars['namae_url'] = 'http://';
        $this->assertTrue($this->vld->validate('namae_url', '', $form_url));

        $this->vld->af->form_vars['namae_url'] = '';
        $this->assertTrue($this->vld->validate('namae_url', '', $form_url));

        // '/'が足りない
        $this->vld->af->form_vars['namae_url'] = 'http:/';
        $this->assertFalse($this->vld->validate('namae_url', '', $form_url));

        // 接頭辞がない
        $this->vld->af->form_vars['namae_url'] = 'hoge@fuga.net';
        $this->assertFalse($this->vld->validate('namae_url', '', $form_url));
    }
    // }}}

    // {{{ checkVendorChar
    function test_checkVendorChar()
    {
        $form_string = array(
                             'type'          => VAR_TYPE_STRING,
                             'required'      => true,
                             'custom' => 'checkVendorChar',
                             );
        $this->vld->af->form_vars['namae_string'] = 'http://uga.net';
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0x00);
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0x79);
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0x80);
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0x8e);
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0x8f);
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0xae);
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0xf8);
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0xfd);
        $this->assertTrue($this->vld->validate('namae_string', '', $form_string));

        /* IBM拡張文字 / NEC選定IBM拡張文字 */
        //$c == 0xad || ($c >= 0xf9 && $c <= 0xfc)
        $this->vld->af->form_vars['namae_string'] = chr(0xad);
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0xf9);
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0xfa);
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));

        $this->vld->af->form_vars['namae_string'] = chr(0xfc);
        $this->assertFalse($this->vld->validate('namae_string', '', $form_string));
    }
    // }}}
}

?>
