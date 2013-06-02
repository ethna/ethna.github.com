Writing Logs
============

In the configuration  file e.g. ``appname/etc/appname-ini.php

**Add the following lines for log in config**

.. code-block:: php
    
   <?php   
   $config = array(
       'url' => '',
       'debug' => false,


       'log_facility'          => 'default',
       'log_level'             => 'warning',
       'log_option'            => 'pid,function,pos',
       'log_filter_do'         => '',
       'log_filter_ignore'     => 'Undefined index.*%%.*tpl',


       'session' => array(
          'handler'                => 'files',
          'path'                   => '../tmp', //THIS IS IF YOU WANT TO SET THE SESSION FILES PATH
          'check_remote_addr'      => true,
       ),
   
    'log' => array(
        'file' => array(
            'level'           => 'notice',
            'option'          => 'pid,function,pos',
            //'filter_do'     => '',
            //'filter_ignore' => 'Undefined index.*%%.*tpl',
            'file'            => '/tmp/error.log', 
     //     'dir'             => '/tmp/', //DONOT MENTION DIR here
            'mode'            => 666, //SET THE MODE TO 666 for writable and NOT 777
            ),
        ),
     );


**Now to write to a log**

.. code-block:: php

    <?php
    function prepare()
    {
 
        $logger = $this->backend->getLogger();
        $logger->log(LOG_NOTICE, "Testing Dir. File Should be Created in appname/tmp/error.log");
        
        //ALSO a session file sess_**** should also be created in appname/tmp/sess_*****
        $this->session->start();

    }
