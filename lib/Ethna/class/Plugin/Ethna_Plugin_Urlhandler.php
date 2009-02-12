<?php
// vim: foldmethod=marker tabstop=4 shiftwidth=4 autoindent
/**
 *  Ethna_Plugin_Urlhandler.php
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: Ethna_Plugin_Urlhandler.php 488 2007-12-13 22:11:18Z mumumu-org $
 */

// {{{ Ethna_Plugin_Urlhandler
/**
 *  Urlhandlerプラグインの基底クラス
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_Plugin_Urlhandler
{
    /**#@+
     *  @access private
     */

    /** @var    object  Ethna_Backend   backendオブジェクト */
    var $backend;

    /** @var    object  Ethna_Logger    ログオブジェクト */
    var $logger;

    /**#@-*/

    /**
     *  Ethna_Plugin_Urlhandlerクラスのコンストラクタ
     *
     *  @access public
     *  @param  object  Ethna_Controller    $controller コントローラオブジェクト
     */
    function Ethna_Plugin_Urlhandler(&$controller)
    {
        $this->backend =& $controller->getBackend();
        $this->logger =& $controller->getLogger();
    }

    /**
     *  アクションをユーザリクエストに変換する
     *
     *  @param string $action
     *  @param array $param
     *  @access public
     *  @return array array($path_string, $path_key)
     */
    function actionToRequest($action, $param)
    {
        die('override!');
    }

    /**
     *  ユーザリクエストをアクションに変換する
     *
     *  @param array $http_vars
     *  @access public
     *  @return array $http_vars with 'action_foobar' => 'true' element.
     */
    function requestToAction($http_vars)
    {
        die('override!');
    }

    /**
     *  アクションをリクエストパラメータに変換する
     *
     *  @access public
     *  @param array $http_vars
     *  @param string $action
     *  @return $http_vars with 'action_foobar' element.
     */
    function buildActionParameter($http_vars, $action)
    {
        if ($action == "") {
            return $http_vars;
        }
        $key = sprintf('action_%s', $action);
        $http_vars[$key] = 'true';
        return $http_vars;
    }

    /**
     *  パラメータをURLに変換する
     *
     *  @access public
     *  @param array $query query list 
     *  @return string query string
     */
    function buildQueryParameter($query)
    {
        $param = '';

        foreach ($query as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    if (is_numeric($k)) {
                        $k = '';
                    }
                    $param .= sprintf('%s=%s&',
                                      urlencode(sprintf('%s[%s]', $key, $k)),
                                      urlencode($v));
                }
            } else if (is_null($value) == false) {
                $param .= sprintf('%s=%s&', urlencode($key), urlencode($value));
            }
        }

        return substr($param, 0, -1);
    }
}
// }}}

?>
