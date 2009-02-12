<?php
// vim: foldmethod=marker
/**
 *  action_class.php
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: Ethna_CLI_ActionClass.php 488 2007-12-13 22:11:18Z mumumu-org $
 */

// {{{ Ethna_CLI_ActionClass
/**
 *  コマンドラインaction実行クラス
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @access     public
 *  @package    Ethna
 *  @obsolete
 */
class Ethna_CLI_ActionClass extends Ethna_ActionClass
{
    /**
     *  action処理
     *
     *  @access public
     */
    function Perform()
    {
        parent::Perform();
        $_SERVER['REMOTE_ADDR'] = "0.0.0.0";
        $_SERVER['HTTP_USER_AGENT'] = "";
    }
}
// }}}
?>
