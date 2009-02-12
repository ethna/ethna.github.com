<?php
// vim: foldmethod=marker
/**
 *  Ethna_Filter.php
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: Ethna_Filter.php 488 2007-12-13 22:11:18Z mumumu-org $
 */

// {{{ Ethna_Filter
/**
 *  フレームワークのフィルタ基底クラス
 *
 *  Mojaviの真似です（きっぱり）。アクション実行前に各種処理を行うことが
 *  出来ます。
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @access     public
 *  @package    Ethna
 *  @obsolete
 */
class Ethna_Filter
{
    /**#@+
     *  @access private
     */

    /** @var    object  Ethna_Controller    controllerオブジェクト */
    var $controller;

    /** @var    object  Ethna_Controller    controllerオブジェクト($controllerの省略形) */
    var $ctl;

    /** @var    object  Ethna_Config        設定オブジェクト */
    var $config;

    /** @var    object  Ethna_Logger        ログオブジェクト */
    var $logger;

    /**#@-*/


    /**
     *  Ethna_Filterのコンストラクタ
     *
     *  @access public
     *  @param  object  Ethna_Controller    &$controller    コントローラオブジェクト
     */
    function Ethna_Filter(&$controller)
    {
        // オブジェクトの設定
        $this->controller =& $controller;
        $this->ctl =& $this->controller;

        $this->config =& $controller->getConfig();
        $this->logger =& $this->controller->getLogger();
    }

    /**
     *  実行前フィルタ
     *
     *  @access public
     *  @return Ethna_Error:実行中止 any:正常終了
     */
    function preFilter()
    {
    }

    /**
     *  アクション実行前フィルタ
     *
     *  @access public
     *  @param  string  $action_name    実行されるアクション名
     *  @return string  null:正常終了 (string):実行するアクション名を変更
     */
    function preActionFilter($action_name)
    {
        return null;
    }

    /**
     *  アクション実行後フィルタ
     *
     *  @access public
     *  @param  string  $action_name    実行されたアクション名
     *  @param  string  $forward_name   実行されたアクションからの戻り値
     *  @return string  null:正常終了 (string):遷移名を変更
     */
    function postActionFilter($action_name, $forward_name)
    {
        return null;
    }

    /**
     *  実行後フィルタ
     *
     *  @access public
     *  @return Ethna_Error:実行中止 any:正常終了
     */
    function postFilter()
    {
    }
}
// }}}
?>
