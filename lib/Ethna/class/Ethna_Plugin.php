<?php
// vim: foldmethod=marker
/**
 *  Ethna_Plugin.php
 *
 *  @author     ICHII Takashi <ichii386@schweetheart.jp>
 *  @author     Kazuhiro Hosoi <hosoi@gree.co.jp>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: Ethna_Plugin.php 625 2008-08-04 21:06:10Z mumumu-org $
 */

// {{{ Ethna_Plugin
/**
 *  プラグインクラス
 *  
 *  @author     ICHII Takashi <ichii386@schweetheart.jp>
 *  @author     Kazuhiro Hosoi <hosoi@gree.co.jp>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_Plugin
{
    /**#@+
     *  @access private
     */

    /** @var    object  Ethna_Controller    コントローラオブジェクト */
    var $controller;

    /** @var    object  Ethna_Controller    コントローラオブジェクト($controllerの省略形) */
    var $ctl;

    /** @var    object  Ethna_Logger        ログオブジェクト */
    var $logger;

    /** @var    array   プラグインのオブジェクト(インスタンス)を保存する配列 */
    var $obj_registry = array();

    /** @var    array   プラグインのクラス名、ソースファイル名を保存する配列 */
    var $src_registry = array();

    /** @var    array       検索対象となるプラグインのアプリケーションIDのリスト */
    var $appid_list;

    /**#@-*/

    // {{{ コンストラクタ
    /**
     *  Ethna_Pluginのコンストラクタ
     *
     *  @access public
     *  @param  object  Ethna_Controller    $controller コントローラオブジェクト
     */
    function Ethna_Plugin(&$controller)
    {
        $this->controller =& $controller;
        $this->ctl =& $this->controller;
        $this->logger = null;
        if (isset($this->controller->plugin_search_appids)
            && is_array($this->controller->plugin_search_appids)) {
            $this->appid_list =& $this->controller->plugin_search_appids;
        } else {
            $this->appid_list = array($this->controller->getAppId(), 'Ethna');
        }
    }

    /**
     *  loggerをsetする。
     *
     *  LogWriterはpluginなので、pluginインスタンス作成時点では
     *  loggerに依存しないようにする。
     *
     *  @access public
     *  @param  object  Ethna_Logger    $logger ログオブジェクト
     */
    function setLogger(&$logger)
    {
        if ($this->logger === null && is_object($logger)) {
            $this->logger =& $logger;
        }
    }
    // }}}

    // {{{ プラグイン呼び出しインタフェース
    /**
     *  プラグインのインスタンスを取得
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @return object  プラグインのインスタンス
     */
    function &getPlugin($type, $name)
    {
        return $this->_getPlugin($type, $name);
    }

    /**
     *  ある種類 ($type) のプラグイン ($name) の全リストを取得
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @return array   プラグインオブジェクトの配列
     */
    function getPluginList($type)
    {
        $plugin_list = array();

        $this->searchAllPluginSrc($type);
        if (isset($this->src_registry[$type]) == false) {
            return $plugin_list;
        }
        foreach ($this->src_registry[$type] as $name => $value) {
            if (is_null($value)) {
                continue;
            }
            $plugin_list[$name] =& $this->getPlugin($type, $name);
        }
        return $plugin_list;
    }
    // }}}

    // {{{ obj_registry のアクセサ
    /**
     *  プラグインのインスタンスをレジストリから取得
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @return object  プラグインのインスタンス
     */
    function &_getPlugin($type, $name)
    {
        if (isset($this->obj_registry[$type]) == false) {
            $this->obj_registry[$type] = array();

            // プラグインの親クラスを(存在すれば)読み込み
            foreach ($this->appid_list as $appid) {
                list($class, $dir, $file) = $this->getPluginNaming($type, null, $appid);
                $this->_includePluginSrc($class, $dir, $file, true);
            }
        }

        // key がないときはプラグインをロードする
        if (array_key_exists($name, $this->obj_registry[$type]) == false) {
            $this->_loadPlugin($type, $name);
        }

        // null のときはロードに失敗している
        if (is_null($this->obj_registry[$type][$name])) {
            return Ethna::raiseWarning('plugin [type=%s, name=%s] is not found',
                E_PLUGIN_NOTFOUND, $type, $name);
        }

        // プラグインのインスタンスを返す
        return $this->obj_registry[$type][$name];
    }

    /**
     *  プラグインをincludeしてnewし，レジストリに登録
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     */
    function _loadPlugin($type, $name)
    {
        // プラグインのファイル名を取得
        $plugin_src = $this->_getPluginSrc($type, $name);
        if (is_null($plugin_src)) {
            $this->obj_registry[$type][$name] = null;
            return;
        }
        list($plugin_class, $plugin_dir, $plugin_file) = $plugin_src;

        // プラグインのファイルを読み込み
        $r =& $this->_includePluginSrc($plugin_class, $plugin_dir, $plugin_file);
        if (Ethna::isError($r)) {
            $this->obj_registry[$type][$name] = null;
            return;
        }

        // プラグイン作成
        $instance =& new $plugin_class($this->controller, $type, $name);
        if (is_object($instance) == false
            || strcasecmp(get_class($instance), $plugin_class) != 0) {
            $this->logger->log(LOG_WARNING, 'plugin [%s::%s] instantiation failed', $type, $name);
            $this->obj_registry[$type][$name] = null;
            return;
        }
        $this->obj_registry[$type][$name] =& $instance;
    }

    /**
     *  プラグインのインスタンスをレジストリから消す
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     */
    function _unloadPlugin($type, $name)
    {
        unset($this->obj_registry[$type][$name]);
    }
    // }}}

    // {{{ src_registry のアクセサ
    /**
     *  プラグインのソースファイル名とクラス名をレジストリから取得
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @return array   ソースファイル名とクラス名からなる配列
     */
    function _getPluginSrc($type, $name)
    {
        if (isset($this->src_registry[$type]) == false) {
            $this->src_registry[$type] = array();
        }

        // key がないときはプラグインの検索をする
        if (array_key_exists($name, $this->src_registry[$type]) == false) {
            $this->_searchPluginSrc($type, $name);
        }

        // プラグインのソースを返す
        return $this->src_registry[$type][$name];
    }
    // }}}

    // {{{ プラグインファイル検索部分
    /**
     *  プラグインのクラス名、ディレクトリ、ファイル名を決定
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前 (nullのときは親クラス)
     *  @param  string  $appid  アプリケーションID
     *  @return array   プラグインのクラス名、ディレクトリ、ファイル名の配列
     *  @todo   class factoryのnaming ruleと整合させる
     */
    function getPluginNaming($type, $name, $appid)
    {
        if ($appid == 'Ethna') {
            if ($name === null) {
                $ext = 'php';
                $dir = ETHNA_BASE . "/class/Plugin";
                $class = "Ethna_Plugin_{$type}";
            } else {
                $ext = 'php';
                $dir = ETHNA_BASE . "/class/Plugin/{$type}";
                $class = "Ethna_Plugin_{$type}_{$name}";
            }
        } else {
            if ($name === null) {
                $ext = $this->controller->getExt('php');
                $dir = $this->controller->getDirectory('plugin');
                $class = "{$appid}_Plugin_{$type}";
            } else {
                $ext = $this->controller->getExt('php');
                $dir = $this->controller->getDirectory('plugin') . "/{$type}";
                $class = "{$appid}_Plugin_{$type}_{$name}";
            }
        }

        $file  = "{$class}.{$ext}";
        return array($class, $dir, $file);
    }

    /**
     *  プラグインのソースを include する
     *
     *  @access private
     *  @param  string  $class  クラス名
     *  @param  string  $dir    ディレクトリ名
     *  @param  string  $file   ファイル名
     *  @param  bool    $parent 親クラスかどうかのフラグ
     *  @return true|Ethna_Error
     */
    function &_includePluginSrc($class, $dir, $file, $parent = false)
    {
        $true = true;
        if (class_exists($class)) {
            return $true;
        }

        $file = $dir . '/' . $file;
        if (file_exists($file) === false) {
            if ($parent === false) {
                return Ethna::raiseWarning('plugin file is not found: [%s]',
                                           E_PLUGIN_NOTFOUND, $file);
            } else {
                return $true;
            }
        }

        include_once $file;

        if (class_exists($class) === false) {
            if ($parent === false) {
                return Ethna::raiseWarning('plugin class [%s] is not defined',
                    E_PLUGIN_NOTFOUND, $class);
            } else {
                return $true;
            }
        }

        if ($parent === false) {
            $this->logger->log(LOG_DEBUG, 'plugin class [%s] is defined', $class);
        }
        return $true;
    }

    /**
     *  アプリケーション, Ethna の順でプラグインのソースを検索する
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     */
    function _searchPluginSrc($type, $name)
    {
        // コントローラで指定されたアプリケーションIDの順に検索
        foreach ($this->appid_list as $appid) {
            list($class, $dir, $file) = $this->getPluginNaming($type, $name, $appid);
            if (class_exists($class)) {
                // すでにクラスが存在する場合は特別にスキップ
                if (isset($this->src_registry[$type]) == false) {
                    $this->src_registry[$type] = array();
                }
                $this->src_registry[$type][$name] = array($class, null, null);
                return;
            }
            if (file_exists("{$dir}/{$file}")) {
                $this->logger->log(LOG_DEBUG, 'plugin file is found in search: [%s]',
                                   "{$dir}/{$file}");
                if (isset($this->src_registry[$type]) == false) {
                    $this->src_registry[$type] = array();
                }
                $this->src_registry[$type][$name] = array($class, $dir, $file);
                return;
            }
        }

        // 見つからなかった場合 (nullで記憶しておく)
        $this->logger->log(LOG_WARNING, 'plugin file for [type=%s, name=%s] is not found in search', $type, $name);
        $this->src_registry[$type][$name] = null;
    }

    /**
     *  プラグインの種類 ($type) をすべて検索する
     *
     *  @access public
     *  @return array
     */
    function searchAllPluginType()
    {
        $type_list = array();
        foreach (array_reverse($this->appid_list) as $appid) {
            list(, $dir, ) = $this->getPluginNaming('', null, $appid);
            if (is_dir($dir) == false) {
                continue;
            }
            $dh = opendir($dir);
            if (is_resource($dh) == false) {
                continue;
            }
            while (($type_dir = readdir($dh)) !== false) {
                if ($type_dir{0} != '.' && is_dir("{$dir}/{$type_dir}")) {
                    $type_list[$type_dir] = 0;
                }
            }
            closedir($dh);
        }
        return array_keys($type_list);
    }

    /**
     *  指定された $type のプラグイン (のソース) をすべて検索する
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     */
    function searchAllPluginSrc($type)
    {
        // 後で見付かったもので上書きするので $this->appid_list の逆順とする
        $name_list = array();
        foreach (array_reverse($this->appid_list) as $appid) {
            //  クラス名として許可された文字であればOKとする
            //  アンダーバーを拒む理由はないし、命名規約からも禁止されていない
            //  @see http://ethna.jp/ethna-document-dev_guide-plugin.html
            //  @see http://www.php.net/manual/en/language.variables.php
            list($class_regexp, $dir, $file_regexp) = $this->getPluginNaming($type, '([a-zA-Z0-9_\x7f-\xff]+)', $appid);

            //ディレクトリの存在のチェック
            if (is_dir($dir) == false) {
                // アプリ側で見付からないのは正常
                continue;
            }

            // ディレクトリを開く
            $dh = opendir($dir);
            if (is_resource($dh) == false) {
                $this->logger->log(LOG_DEBUG, 'cannot open plugin directory: [%s]', $dir);
                continue;
            }
            $this->logger->log(LOG_DEBUG, 'plugin directory opened: [%s]', $dir);

            // 条件にあう $name をリストに追加
            while (($file = readdir($dh)) !== false) {
                if (preg_match('#^'.$file_regexp.'$#', $file, $matches)
                    && file_exists("{$dir}/{$file}")) {
                    $name_list[$matches[1]] = true;
                }
            }

            closedir($dh);
        }

        foreach (array_keys($name_list) as $name) {
            // 冗長だがもう一度探しなおす
            $this->_searchPluginSrc($type, $name);
        }
    }
    // }}}

    // {{{ static な include メソッド
    /**
     *  Ethna 本体付属のプラグインのソースを include する
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @static
     */
    function includeEthnaPlugin($type, $name)
    {
        Ethna_Plugin::includePlugin($type, $name, 'Ethna');
    }

    /**
     *  プラグインのソースを include する
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @param  string  $appid  アプリケーションID
     *  @static
     */
    function includePlugin($type, $name, $appid = null)
    {
        $ctl =& Ethna_Controller::getInstance();
        $plugin =& $ctl->getPlugin();

        if ($appid === null) {
            $appid = $ctl->getAppId();
        }
        list($class, $dir, $file) = $plugin->getPluginNaming($type, $name, $appid);
        $plugin->_includePluginSrc($class, $dir, $file);
    }
    // }}}
}
// }}}
?>
