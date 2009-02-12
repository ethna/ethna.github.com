<?php
/**
 *  Ethna_Plugin_Handle_AddActionTest.php
 *
 *  @author     halt feits <halt.feits@gmail.com>
 *  @package    Ethna
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @version    $Id: Ethna_Plugin_Handle_AddActionTest.php 488 2007-12-13 22:11:18Z mumumu-org $
 */

require_once ETHNA_BASE . '/class/Plugin/Handle/Ethna_Plugin_Handle_AddAction.php';

// {{{ Ethna_Plugin_Handle_AddActionTest
/**
 *  add-action-test handler
 *
 *  @author     halt feits <halt.feits@gmail.com>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_Plugin_Handle_AddActionTest extends Ethna_Plugin_Handle_AddAction
{
    /**
     *  add action test
     *
     *  @access public
     */
    function perform()
    {
        $r =& $this->_getopt(array('basedir=', 'skelfile='));
        if (Ethna::isError($r)) {
            return $r;
        }
        list($opt_list, $arg_list) = $r;

        // action_name
        $action_name = array_shift($arg_list);
        if ($action_name == null) {
            return Ethna::raiseError('action name isn\'t set.', 'usage');
        }
        $r =& Ethna_Controller::checkActionName($action_name);
        if (Ethna::isError($r)) {
            return $r;
        }

        $ret =& $this->_perform('ActionTest', $action_name, $opt_list);
        return $ret;
    }

    /**
     *  get handler's description
     *
     *  @access public
     */
    function getDescription()
    {
        return <<<EOS
add new action test to project:
    {$this->id} [-b|--basedir=dir] [-s|--skelfile=file] [action]

EOS;
    }

    /**
     *  @access public
     */
    function getUsage()
    {
        return <<<EOS
ethna {$this->id} [-b|--basedir=dir] [-s|--skelfile=file] [action]
EOS;
    }
}
// }}}
?>
