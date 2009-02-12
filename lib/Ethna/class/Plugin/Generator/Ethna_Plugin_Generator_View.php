<?php
// vim: foldmethod=marker
/**
 *  Ethna_Plugin_Generator_View.php
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: Ethna_Plugin_Generator_View.php 488 2007-12-13 22:11:18Z mumumu-org $
 */

// {{{ Ethna_Plugin_Generator_View
/**
 *  スケルトン生成クラス
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_Plugin_Generator_View extends Ethna_Plugin_Generator
{
    /**
     *  ビューのスケルトンを生成する
     *
     *  @access public
     *  @param  string  $forward_name   ビュー名
     *  @param  string  $skelton        スケルトンファイル名
     *  @return true|Ethna_Error        true:成功 Ethna_Error:失敗
     */
    function &generate($forward_name, $skelton = null, $gateway = GATEWAY_WWW)
    {
        $view_dir = $this->ctl->getViewdir();
        $view_class = $this->ctl->getDefaultViewClass($forward_name, $gateway);
        $view_path = $this->ctl->getDefaultViewPath($forward_name);

        // entity
        $entity = $view_dir . $view_path;
        Ethna_Util::mkdir(dirname($entity), 0755);

        // skelton
        if ($skelton === null) {
            $skelton = 'skel.view.php';
        }

        // macro
        $macro = array();
        $macro['project_id'] = $this->ctl->getAppId();
        $macro['forward_name'] = $forward_name;
        $macro['view_class'] = $view_class;
        $macro['view_path'] = $view_path;

        // user macro
        $user_macro = $this->_getUserMacro();
        $macro = array_merge($macro, $user_macro);


        // generate
        if (file_exists($entity)) {
            printf("file [%s] already exists -> skip\n", $entity);
        } else if ($this->_generateFile($skelton, $entity, $macro) == false) {
            printf("[warning] file creation failed [%s]\n", $entity);
        } else {
            printf("view script(s) successfully created [%s]\n", $entity);
        }

        $true = true;
        return $true;
    }
}
// }}}
?>
