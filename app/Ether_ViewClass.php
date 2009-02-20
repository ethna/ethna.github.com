<?php
/**
 *  Ether_ViewClass.php
 *
 *  @description    ViewClass Ether Expansion: expand methods, utilities.
 *  @author         Sotaro KARASAWA <sotaro.k@gmail.com>
 *  @package        Ether :  Ethna Expansion
 *  @date           2008/09/23
 *  @version        $Id: app.viewclass.php 600 2008-06-30 23:12:42Z mumumu-org $
 */


//  Ether_ViewClass
/**
 *  View class.
 *
 *  @author     Sotaro KARASAWA <sotaro.k@gmail.com>
 *  @package    Ether :  Ethna Expansion
 *  @access     public
 */
class Ether_ViewClass extends Ethna_ViewClass
{

    /**
     *  @purotected string  Layout template filename
     */
    protected $_layoutFile = 'layout.tpl';

    /**
     *  @public     boolean  flag of use layout template
     */
    public $hasLayout = true;

    public $hasDefaultHeader = true;

    public $defaultHeader = array(
        "Pragma" => "no-cache",
        "Cache-Control" => "no-cache, no-store, must-revalidate",
    );

    /**
     *  Constructor of ViewClas
     *  to over ride
     *
     *  @access public
     *  @param  object  Ethna_Backend   $backend    backendオブジェクト
     *  @param  string  $forward_name   ビューに関連付けられている遷移名
     *  @param  string  $forward_path   ビューに関連付けられているテンプレートファイル名
     */
    public function Ether_ViewClass(&$backend, $forward_name, $forward_path)
    {
        parent::Ethna_ViewClass($backend, $forward_name, $forward_path);

        //$this->db =& Strk_DB::getInstance($backend);

    }

    /**
     *  set common default value.
     *
     *  @access protected
     *  @param  object  Deadline_Renderer  Renderer object.
     */
    function _setDefault(&$renderer)
    {
        // get config setting 
        $isDebug = $this->backend->getConfig()->get('debug');
        $isTplDebug = $this->backend->getConfig()->get('debug_tpl');

        $smarty =& $renderer->engine;

        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        // for debug
        $smarty->force_compile = $isDebug;
        //$smarty->debugging = $isTplDebug;

        /*
        $smarty->cacing = 1;
        $c =& $this->backend->getController();
        $smarty->cache_dir = $c->getDirectory('tmp');
        */

        $config =& $this->backend->getConfig();
        //$smarty->assign('conf', $config->config);
    }

    /**
     *  set language using actionform value, cookie ... etc.
     *
     *  @access protected
     */
    function _setLanguage()
    {
    }

    /**
     * Override parent method to set Layout Template
     *
     * @access public
     */
    public function forward()
    {
        $this->_setLanguage();
        $renderer =& $this->_getRenderer();
        $this->_setDefault($renderer);

        if ($this->hasDefaultHeader) {
            $this->defaultHeader['Content-Type'] = 'text/html; charset=' . $this->backend->getController()->getClientEncoding();
            $this->header($this->defaultHeader);
        }

        // using layout.tpl flag
        if ($this->hasLayout) {
            // check : layout file existance
            $layout = $this->getLayout();
            if ($this->isTemplateExists($layout)) {
                $content = $renderer->perform($this->forward_path, true);

                if (Ethna::isError($content)) {
                    if ($content->getCode() == E_GENERAL) {
                        $error = 404;
                    }
                    else {
                        $error = 500;
                    }

                    $this->error($error);
                    $content = $renderer->perform($this->forward_path, true);
                }

                $renderer->assign('content', $content);
                $renderer->display($layout, serialize($_SERVER['REQUEST_URI']));
            } else {
                return Ethna::raiseWarning('file "'.$layout.'" not found');
            }
        } else {
            $renderer->perform($this->forward_path);
        }
    }

    /**
     * sending header
     *
     *  @param mixed    array   send header : heade => value
     *                  int     HTTP status code
     *                  string  Header string
     */
    public function header ($status) {
        if (is_array($status)) {
            foreach ($status as $key => $status) {
                header ($key . ": " . $status);
            }
        } else if (is_int($status)) {
            $codes = array(
                100 => "Continue",
                101 => "Switching Protocols",
                200 => "OK",
                201 => "Created",
                202 => "Accepted",
                203 => "Non-Authoritative Information",
                204 => "No Content",
                205 => "Reset Content",
                206 => "Partial Content",
                300 => "Multiple Choices",
                301 => "Moved Permanently",
                302 => "Found",
                303 => "See Other",
                304 => "Not Modified",
                305 => "Use Proxy",
                307 => "Temporary Redirect",
                400 => "Bad Request",
                401 => "Unauthorized",
                402 => "Payment Required",
                403 => "Forbidden",
                404 => "Not Found",
                405 => "Method Not Allowed",
                406 => "Not Acceptable",
                407 => "Proxy Authentication Required",
                408 => "Request Time-out",
                409 => "Conflict",
                410 => "Gone",
                411 => "Length Required",
                412 => "Precondition Failed",
                413 => "Request Entity Too Large",
                414 => "Request-URI Too Large",
                415 => "Unsupported Media Type",
                416 => "Requested range not satisfiable",
                417 => "Expectation Failed",
                500 => "Internal Server Error",
                501 => "Not Implemented",
                502 => "Bad Gateway",
                503 => "Service Unavailable",
                504 => "Gateway Time-out"
            );

            if (array_key_exists($status, $codes)) {
                header("HTTP/1.1: {$status} {$codes[$status]}");
                //vd("HTTP/1.1: {$status} {$codes[$status]}");
            }
        } else {
            // check valid header
            if (preg_match("/^.+\:\s.+$/", $status)) {
                header($status);
            }
        }
    }

    public function redirect ($url)
    {
        $this->hasDefaultHeader = false;
        $this->hasLayout = false;

        $this->header(302);
        $this->header(array('Location' => $url));
    }

    public function flush ($url, $message = "", $wait = 3)
    {
        $flush = compact($url, $message, $wait);
        $this->af->setApp('flush', $flush);
    }

    /**
     *  set layout
     */
    public function setLayout ($filename)
    {
        // check layout file existance
        if ($this->isTemplateExists($filename)) {
            $this->_layoutFile = $filename;
            return true;
        }
        else {
            return Ethna::raiseWarning('file "'.$filename.'" not found');
        }
    }

    /**
     * get layout
     */
    public function getLayout ()
    {
        return $this->_layoutFile;
    }

    /**
     * check template existance
     *
     * @param   string  $filename   template file name
     * @access  public
     * @return  boolean
     */
    public function isTemplateExists($filename)
    {
        $renderer = $this->_getRenderer();
        if ($renderer->templateExists($filename)) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Error
     */
    function error($code)
    {
        $this->hasDefaultHeader = false;

        $this->header($code);

        $html = array(
            'title' => 'ページが見つかりません | ',
        );
        $this->af->setApp('html', $html);
        $this->forward_path = "error{$code}.tpl";
    }
}
//

class V extends Ether_ViewClass {};
