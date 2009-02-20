<?php
/**
 *  Ether_Plugin_Filter_EndLogger.php
 *
 *  @author     Sotaro KARASAWA <sotaro.k@gmail.com>
 *  @package    Ether
 */

/**
 *  Call logger's end() method at the end.
 *  !! to fix Ethna bug (?) !!
 *
 *  @author     Sotaro KARASAWA <sotaro.k@gmail.com>
 *  @access     public
 *  @package    Ether
 */
class Ether_Plugin_Filter_EndLogger extends Ethna_Plugin_Filter
{

    function preFilter()
    {
    }

    /**
     *  filter which will be executed at the end.
     *
     *  @access public
     */
    function postFilter()
    {
        $this->logger->end();
    }
}
?>
