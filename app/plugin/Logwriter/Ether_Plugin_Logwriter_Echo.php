<?php
/** Ether_Plugin_Logwriter_Echo
 *
 * @author  Sotaro KARASAWA <sotaro.k@gmail.com>
 * @date    2008/12/01
 */


class Ether_Plugin_Logwriter_Echo extends Ethna_Plugin_Logwriter
{
    var $log_array = array();

    /**
     *  ログを出力する
     *
     *  @access public
     *  @param  int     $level      ログレベル(LOG_DEBUG, LOG_NOTICE...)
     *  @param  string  $message    ログメッセージ(+引数)
     */
    function log($level, $message)
    {
        $c =& Ethna_Controller::getInstance();

        $prefix = $this->ident;
        if (array_key_exists("pid", $this->option)) {
            $prefix .= sprintf('[%d]', getmypid());
        }
        $pre_prefix = '<div class="ethna-debug-log ethna-debug-log-' . $this->_getLogLevelName($level) . '">';
        $prefix .= sprintf($c->getGateway() != GATEWAY_WWW ? '(%s): ' : '(<span class="ethna-debug-log-loglevel ethna-debug-log-loglevel-' . $this->_getLogLevelName($level) . ' ">%s</span>): ',
            $this->_getLogLevelName($level)
        );
        $post_prefix = '</div>';

        if (array_key_exists("function", $this->option) ||
            array_key_exists("pos", $this->option)) {
            $tmp = "";
            $bt = $this->_getBacktrace();
            if ($bt && array_key_exists("function", $this->option) && $bt['function']) {
                $tmp .= $bt['function'];
            }
            if ($bt && array_key_exists("pos", $this->option) && $bt['pos']) {
                $tmp .= $tmp ? sprintf('(%s)', $bt['pos']) : $bt['pos'];
            }
            if ($tmp) {
                $prefix .= $tmp . ": ";
            }
        }

        $br = $c->getGateway() != GATEWAY_WWW ? "" : "<br />";

        //var_dump($c);
        $log_content = ($pre_prefix . $prefix . $message . $post_prefix . "\n");
        $this->log_array[] = $log_content;
        //var_dump($this);
        //echo "hoge";

        return $log_content;
    }

    function end()
    {
        if (!$this->ctl->view->hasDefaultHeader) {
            return null;
        }
        echo '<div class="ethna-debug" id="ethna-debug-logwindow">';
        echo '<div class="ethna-debug-title">Log</div>';
        foreach ($this->log_array as $log) {
            echo $log;
        }
        echo '</div>';
    }

    /**
     *  ログ出力箇所の情報(関数名/ファイル名等)を取得する
     *
     *  @access private
     *  @return array   ログ出力箇所の情報
     */
    function _getBacktrace()
    {
        $skip_method_list = array(
            array('ethna', 'raise'),
            array(null, 'raiseerror'),
            array(null, 'handleerror'),
            array('ethna_logger', null),
            array('ethna_plugin_logwriter', null),
            array('ethna_error', null),
            array('ethna_apperror', null),
            array('ethna_actionerror', null),
            array('ethna_backend', 'log'),
            array(null, 'ethna_error_handler'),
            array(null, 'trigger_error'),
            array('ether_plugin_logwriter', null), // この1行を足すためにメソッドまるごとコピーですよ・・・
        );

        if ($this->have_backtrace == false) {
            return null;
        }

        $bt = debug_backtrace();
        $i = 0;
        while ($i < count($bt)) {
            if (isset($bt[$i]['class']) == false) {
                $bt[$i]['class'] = null;
            }
            $skip = false;

            // メソッドスキップ処理
            foreach ($skip_method_list as $method) {
                $class = $function = true;
                if ($method[0] != null) {
                    $class = preg_match("/^$method[0]/i", $bt[$i]['class']);
                }
                if ($method[1] != null) {
                    $function = preg_match("/^$method[1]/i", $bt[$i]['function']);
                }
                if ($class && $function) {
                    $skip = true;
                    break;
                }
            }

            if ($skip) {
                $i++;
            } else {
                break;
            }
        }


        $c =& Ethna_Controller::getInstance();
        $basedir = $c->getBasedir();

        $function = sprintf("%s.%s", isset($bt[$i]['class']) ? $bt[$i]['class'] : 'global', $bt[$i]['function']);

        $file = $bt[$i]['file'];
        if (strncmp($file, $basedir, strlen($basedir)) == 0) {
            $file = substr($file, strlen($basedir));
        }
        if (strncmp($file, ETHNA_BASE, strlen(ETHNA_BASE)) == 0) {
            $file = preg_replace('#^/+#', '', substr($file, strlen(ETHNA_BASE)));
        }
        $line = $bt[$i]['line'];
        return array('function' => $function, 'pos' => sprintf('%s:%s', $file, $line));
    }
}

