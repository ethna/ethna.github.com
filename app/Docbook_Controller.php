<?php
/**
 *  Docbook_Controller.php
 *
 *  @author     Sotaro KARASAWA <sotrao.k@gmail.com>
 *  @package    Docbook
 *  @version    $Id: app.controller.php 596 2008-06-30 14:12:24Z mumumu-org $
 */

/** Application base directory */
define('BASE', dirname(dirname(__FILE__)));

/** include_path setting (adding "/app" and "/lib" directory to include_path) */
$app = BASE . "/app";
$lib = BASE . "/lib";
ini_set('include_path', implode(PATH_SEPARATOR, array($app, $lib)) . PATH_SEPARATOR . ini_get('include_path'));

require_once 'Ether_Utility.php';

/** including application library. */
require_once 'Ethna/Ethna.php';
require_once 'Docbook_Error.php';
require_once 'Docbook_ActionClass.php';
require_once 'Docbook_ActionForm.php';
require_once 'Docbook_ViewClass.php';


/**
 *  Docbook application Controller definition.
 *
 *  @author     Sotaro KARASAWA <sotrao.k@gmail.com>
 *  @access     public
 *  @package    Docbook
 */
class Docbook_Controller extends Ethna_Controller
{
    /**#@+
     *  @access private
     */

    /**
     *  @var    string  Application ID(appid)
     */
    var $appid = 'DOCBOOK';

    /**
     *  @var    array   forward definition.
     */
    var $forward = array(
        /*
         *  TODO: write forward definition here.
         *
         *  Example:
         *
         *  'index'         => array(
         *      'view_name' => 'Docbook_View_Index',
         *  ),
         */
    );

    /**
     *  @var    array   action definition.
     */
    var $action = array(
        /*
         *  TODO: write action definition here.
         *
         *  Example:
         *
         *  'index'     => array(),
         */
    );

    /**
     *  @var    array   SOAP action definition.
     */
    var $soap_action = array(
        /*
         *  TODO: write action definition for SOAP application here.
         *  Example:
         *
         *  'sample'            => array(),
         */
    );

    /**
     *  @var    array       application directory.
     */
    var $directory = array(
        'action'        => 'app/action',
        'action_cli'    => 'app/action_cli',
        'action_xmlrpc' => 'app/action_xmlrpc',
        'app'           => 'app',
        'plugin'        => 'app/plugin',
        'bin'           => 'bin',
        'etc'           => 'etc',
        'filter'        => 'app/filter',
        'locale'        => 'locale',
        'log'           => 'tmp/log',
        'plugins'       => array(),
        'template'      => 'app/template',
        'template_c'    => 'tmp/c',
        'tmp'           => 'tmp',
        'view'          => 'app/view',
        'www'           => 'www',
        'test'          => 'app/test',
    );

    /**
     *  @var    array       database access definition.
     */
    var $db = array(
        ''              => DB_TYPE_RW,
    );

    /**
     *  @var    array       extention(.php, etc) configuration.
     */
    var $ext = array(
        'php'           => 'php',
        'tpl'           => 'tpl',
    );

    /**
     *  @var    array   class definition.
     */
    var $class = array(
        /*
         *  TODO: When you override Configuration class, Logger class,
         *        SQL class, don't forget to change definition as follows!
         */
        'class'         => 'Ethna_ClassFactory',
        'backend'       => 'Ethna_Backend',
        'config'        => 'Ethna_Config',
        'db'            => 'Ethna_DB_PEAR',
        'error'         => 'Ethna_ActionError',
        'form'          => 'Docbook_ActionForm',
        'i18n'          => 'Ethna_I18N',
        'logger'        => 'Ethna_Logger',
        'plugin'        => 'Ethna_Plugin',
        'session'       => 'Ethna_Session',
        'sql'           => 'Ethna_AppSQL',
        'view'          => 'Docbook_ViewClass',
        'renderer'      => 'Ethna_Renderer_Smarty',
        'url_handler'   => 'Docbook_UrlHandler',
    );

    /**
     *  @var    array       list of application id where Ethna searches plugin.
     */
    var $plugin_search_appids = array(
        /*
         *  write list of application id where Ethna searches plugin.
         *
         *  Example:
         *  When there are plugins whose name are like "Common_Plugin_Foo_Bar" in
         *  application plugin directory, Ethna searches them in the following order.
         *
         *  1. Common_Plugin_Foo_Bar,
         *  2. Docbook_Plugin_Foo_Bar
         *  3. Ethna_Plugin_Foo_Bar
         *
         *  'Common', 'Docbook', 'Ethna',
         */
        'Docbook', 'Ethna',
    );

    /**
     *  @var    array       filter definition.
     */
    var $filter = array(
        /*
         *  TODO: when you use filter, write filter plugin name here.
         *  (If you specify class name, Ethna reads filter class in 
         *   filter directory)
         *
         *  Example:
         *
         *  'ExecutionTime',
         */
    );

    /**
     *  @var    array   smarty modifier definition.
     */
    var $smarty_modifier_plugin = array(
        /*
         *  TODO: write user defined smarty modifier here.
         *
         *  Example:
         *
         *  'smarty_modifier_foo_bar',
         */
    );

    /**
     *  @var    array   smarty function definition.
     */
    var $smarty_function_plugin = array(
        /*
         *  TODO: write user defined smarty function here.
         *
         *  Example:
         *
         *  'smarty_function_foo_bar',
         */
    );

    /**
     *  @var    array   smarty block definition.
     */
    var $smarty_block_plugin = array(
        /*
         *  TODO: write user defined smarty block here.
         *
         *  Example:
         * 
         *  'smarty_block_foo_bar',
         */
    );

    /**
     *  @var    array   smarty prefilter definition.
     */
    var $smarty_prefilter_plugin = array(
        /*
         *  TODO: write user defined smarty prefilter here.
         *
         *  Example:
         *
         *  'smarty_prefilter_foo_bar',
         */
    );

    /**
     *  @var    array   smarty postfilter definition.
     */
    var $smarty_postfilter_plugin = array(
        /*
         *  TODO: write user defined smarty postfilter here.
         *
         *  Example:
         *
         *  'smarty_postfilter_foo_bar',
         */
    );

    /**
     *  @var    array   smarty outputfilter definition.
     */
    var $smarty_outputfilter_plugin = array(
        /*
         *  TODO: write user defined smarty outputfilter here.
         *
         *  Example:
         *
         *  'smarty_outputfilter_foo_bar',
         */
    );

    /**#@-*/

    /**
     *  Get Default language and locale setting.
     *  If you want to change Ethna's output encoding, override this method.
     *
     *  @access protected
     *  @return array   locale name(e.x ja_JP, en_US .etc),
     *                  system encoding name,
     *                  client encoding name(= template encoding)
     *                  (locale name is "ll_cc" format. ll = language code. cc = country code.)
     */
    function _getDefaultLanguage()
    {
        return array('ja_JP', 'UTF-8', 'UTF-8');
    }
}

?>
