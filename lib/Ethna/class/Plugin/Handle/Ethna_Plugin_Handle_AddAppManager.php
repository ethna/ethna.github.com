<?php
/**
 *  Ethna_Plugin_Handle_AddAppManager.php
 *
 *  @author     nozzzzz <nozzzzz@gmail.com>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: Ethna_Plugin_Handle_AddAppManager.php 488 2007-12-13 22:11:18Z mumumu-org $
 */

require_once ETHNA_BASE . '/class/Plugin/Handle/Ethna_Plugin_Handle_AddAppObject.php';

// {{{ Ethna_Plugin_Handle_AddAppManager
/**
 *  add-app-manager handler
 *
 *  @author     nozzzzz <nozzzzz@gmail.com>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_Plugin_Handle_AddAppManager extends Ethna_Plugin_Handle_AddAppObject
{
    /**
     *  add app-manager
     *
     *  @access public
     */
    function perform()
    {
        return $this->_perform('AppManager');
    }

    /**
     *  get handler's description
     *
     *  @access public
     */
    function getDescription()
    {
        return <<<EOS
add new app-manager to project:
    {$this->id} [-b|--basedir=dir] [app-manager name]

EOS;
    }

    /**
     *  get usage
     *
     *  @access public
     */
    function getUsage()
    {
        return <<<EOS
ethna {$this->id} [-b|--basedir=dir] [app-manager name]
EOS;
    }
}
// }}}
?>
