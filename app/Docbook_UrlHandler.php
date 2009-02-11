<?php
/**
 *  Docbook_UrlHandler.php
 *
 *  @author     Sotaro KARASAWA <sotrao.k@gmail.com>
 *  @package    Docbook
 *  @version    $Id: app.url_handler.php 532 2008-05-13 22:41:22Z mumumu-org $
 */

/**
 *  URLHandler class.
 *
 *  @author     Sotaro KARASAWA <sotrao.k@gmail.com>
 *  @access     public
 *  @package    Docbook
 */
class Docbook_UrlHandler extends Ethna_UrlHandler
{
    /** @var    array   Action Mapping */
    var $action_map = array(
        /*
        'user'  => array(
            'user_login' => array(
                'path'          => 'login',
                'path_regexp'   => false,
                'path_ext'      => false,
                'option'        => array(),
            ),
        ),
         */
    );

    /**
     *  get Docbook_UrlHandler class instance.
     *
     *  @access public
     */
    function &getInstance($class_name = null)
    {
        $instance =& parent::getInstance(__CLASS__);
        return $instance;
    }

    // {{{ normalize gateway request method.
    /**
     *  normalize request(via user defined gateway)
     *
     *  @access private
     */
    /*
    function _normalizeRequest_User($http_vars)
    {
        return $http_vars;
    }
     */
    // }}}

    // {{{ generate gateway path method.
    /**
     *  generate path(via user defined gateway)
     *
     *  @access private
     */
    /*
    function _getPath_User($action, $param)
    {
        return array("/user", array());
    }
     */
    // }}}

    // {{{ filter 
    // }}}
}

// vim: foldmethod=marker tabstop=4 shiftwidth=4 autoindent
?>
