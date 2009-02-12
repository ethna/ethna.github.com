<?php
// vim: foldmethod=marker
/**
 *  Ethna_Plugin_Handle_ClearCache.php
 *
 *  @author     ICHII Takashi <ichii386@schweetheart.jp>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: Ethna_Plugin_Handle_ClearCache.php 488 2007-12-13 22:11:18Z mumumu-org $
 */

require_once ETHNA_BASE . '/class/Ethna_PearWrapper.php';

// {{{ Ethna_Plugin_Handle_ClearCache
/**
 *  clear-cache handler
 *
 *  @author     ICHII Takashi <ichii386@schweetheart.jp>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_Plugin_Handle_ClearCache extends Ethna_Plugin_Handle
{
    /**
     *  clear cache files.
     *
     *  @access public
     *  @todo   implement Ethna_Renderer::clear_cache();
     *  @todo   implement Ethna_Plugin_Cachemanager::clear_cache();
     *  @todo   avoid echo, printf
     */
    function perform()
    {
        $r =& $this->_getopt(array('basedir=', 
                                   'any-tmp-files', 'smarty', 'pear', 'cachemanager'));
        if (Ethna::isError($r)) {
            return $r;
        }
        list($args,) = $r;

        $basedir = isset($args['basedir']) ? realpath(end($args['basedir'])) : getcwd();
        $controller =& Ethna_Handle::getAppController($basedir);
        if (Ethna::isError($controller)) {
            return $controller;
        }
        $tmp_dir = $controller->getDirectory('tmp');

        if (isset($args['smarty']) || isset($args['any-tmp-files'])) {
            echo "cleaning smarty caches, compiled templates...";
            $renderer =& $controller->getRenderer();
            if (strtolower(get_class($renderer)) == "ethna_renderer_smarty") {
                $renderer->engine->clear_all_cache();
                $renderer->engine->clear_compiled_tpl();
            }
            echo " done\n";
        }

        if (isset($args['cachemanager']) || isset($args['any-tmp-files'])) {
            echo "cleaning Ethna_Plugin_Cachemanager caches...";
            $cache_dir = sprintf("%s/cache", $tmp_dir);
            Ethna_Util::purgeDir($cache_dir);
            echo " done\n";
        }

        if (isset($args['pear']) || isset($args['any-tmp-files'])) {
            echo "cleaning pear caches...";
            ob_start();
            $pear =& new Ethna_PearWrapper();
            $r =& $pear->init('local', $basedir); 
            if (Ethna::isError($r)) {
                echo ob_get_clean();
                return $r;
            }
            $r =& $pear->doClearCache();
            if (Ethna::isError($r)) {
                echo ob_get_clean();
                return $r;
            }
            ob_get_clean();
            echo " done\n";
        }

        if (isset($args['any-tmp-files'])) {
            echo "cleaning tmp dirs...";
            // purge only entries in tmp.
            if ($dh = opendir($tmp_dir)) {
                while (($entry = readdir($dh)) !== false) {
                    if ($entry === '.' || $entry === '..') {
                        continue;
                    }
                    Ethna_Util::purgeDir("{$tmp_dir}/{$entry}");
                }
                closedir($dh);
            }
            echo " done\n";
        }

        return true;
    }

    // {{{ getDescription()
    /**
     *  @access public
     */
    function getDescription()
    {
        return <<<EOS
clear project's cache files:
    {$this->id} [-b|--basedir=dir] [-a|--any-tmp-files] [-s|--smarty] [-p|--pear] [-c|--cachemanager]

EOS;
    }
    // }}}

    // {{{ getUsage()
    /**
     *  @access public
     */
    function getUsage()
    {
        return <<<EOS
ethna {$this->id} [-b|--basedir=dir] [-a|--any-tmp-files] [-s|--smarty] [-p|--pear] [-c|--cachemanager]
EOS;
    }
    // }}}
}
// }}}
?>
