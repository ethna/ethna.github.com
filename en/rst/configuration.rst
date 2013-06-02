Config ``etc/***-ini.php``
==========================

The default location of the configuration file is in ``YOURAPP/etc/YOURAPP-ini.php``
The configurations are defined in ``$config``


We already discussed previously when setting up the Database like the following

.. code-block:: php

   <?php
   $config = array(
    'debug' => false,
    'dsn'   => 'mysql://user:pass@unix+localhost/dbname',
   );

 
Now, to access the config items in ActionClass of your app you can call using the following   

.. code-block:: php

   <?php
   class Sample_Action_Index extends Ethna_ActionClass
   {
       function prepare()
       {
           return null;
       }

       function perform()
       {
           //Will get you the settings for ``dsn``
           $dsn = $this->config->get('dsn');
       }
   }

Similarity we can also define the memcached configuration in the same file as

.. code-block:: php

   <?php
   $config = array(
   // sample-1: single (or default) memcache
   'memcache_host' => 'localhost',   
   'memcache_port' => 11211,         
   'memcache_use_pconnect' => false, //persistent connection
   'memcache_retry' => 3,            
   'memcache_timeout' => 3,          
    );
 
It is also possible to define more than one configs for memcache as

.. code-block:: php

   <?php 
   $config = array(
   // sample-2: multiple memcache servers (distributing w/ namespace and ids)
   'memcache' => array(
        'namespace1' => array(
            0 => array(
                'memcache_host' => 'cache1.example.com',
                'memcache_port' => 11211,
            ),
            1 => array(
                'memcache_host' => 'cache2.example.com',
                'memcache_port' => 11211,
            ),
        ),
     ),
    );

