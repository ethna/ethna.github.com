Its All Romantic
================

In this section we will talk about ethna, smarty, localhost & webserver (`Heroku <https://www.heroku.com/>`_)
The goal upon this section is to set up ethna on a heroku. Ethna being lightweight
we will not install it on heroku but rather just copy the required libs to the server.

Setting app on Heroku
----------------------

Go to `Heroku <https://www.heroku.com/>`_ and set up your account.
First step here is to set up an app on heroku, lets name it ``ethna-web``.
Upon creating the app, go to settings and get the **Git URL:** ``git@heroku.com:ethna-web.git``

.. Tip::

   Also install the **Heroku Toolbelt** based on your operating system if you haven't done that already.
   https://toolbelt.heroku.com/

Back to Terminal
----------------

Now on the terminal, make a new Directory lets say ``mkdir ~/Documents/Ethna-Web_Heroku``
And go to that directory. 

Lets quickly create a file in that directory,

.. code-block:: bash

   $ echo "<?php echo 'Hello Heroku'; ?>" >index.php

**Initialize the git**

.. code-block:: bash

   $ git init
   $ git add .
   $ git commit -m "Committing the index.php"

**Add the Remote**

Because we have already created the app named ``ethna-web``. Lets just add 
a remote for the existing app using the terminal

.. code-block:: bash

   $ heroku git:remote -a ethna-web

**Push**

.. code-blcok:: bash

   $ git push heroku master

     Counting objects: 5, done.
     Delta compression using up to 4 threads.
     Compressing objects: 100% (2/2), done.
     Writing objects: 100% (3/3), 357 bytes, done.
     Total 3 (delta 0), reused 0 (delta 0)

     -----> PHP app detected
     ....

     To git@heroku.com:ethna-web.git
     ba8dce0..3d9a006  master -> master

.. Note::

   Note that we added ``index.php`` which also indicates heroku that its a PHP application

Test on your url (e.g. http://ethna-web.herokuapp.com/) provided by heroku for your app if ``hello`` is rendered on the web browser.

**Getting Ethna to work**

While in the Dir ``~/Documents/Ethna-Web_Heroku``. Lets do the following to add a project.

.. code-block:: bash

   $ ethna add-project ethnaweb

Now if you have installed Ethna on your local machine, we need to copy the libraries to 
heroku server.

First copy,

.. code-block:: bash

   $ cp -a ~/pear/share/pear/Smarty ethnaweb/app/
   $ cp -a ~/pear/share/pear/Ethna ethnaweb/app/

.. Tip::

   You may also want to copy the DB files

   .. code-block:: bash

      $ cp -a ~/pear/share/pear/DB ethnaweb/app/

**All Done**

Push the changes to heroku's repo

.. code-block:: bash

   $ git add .
   $ git commit -m "pushing ethna"
   $ git push heroku master

  Ethna should render the welcome page on the url http://ethna-web.herokuapp.com/ethnaweb/www/


Setting up Database
-------------------

Setting the database (DB) requires following 2 steps:

1. Create a DB on Heroku
2. Set it up in Ethna

To create a DB on Heroku, I am going to use the free one **Heroku Postgres**. Note that the
previous tutorial about DB uses Ethna's Backend to call a query to MySQL, but we are not 
restricted to just using Ethna's, misc DB can also be easily integrated.

**Getting Heroku username & password**

.. code-block:: bash

   $ heroku config | grep HEROKU_POSTGRESQL

     ...HEROKU_POSTGRESQL_MAROON_URL: postgres://himvd

   $ heroku pg:credentials MAROON

The above will output the username & password like the following

.. code-block:: bash

   "dbname=abcdefg host=****.amazonaws.com port=5432 user=**** password=**** sslmode=require"

**Setting PDO in Ethna**

Setup the username and password in ``etc/ethnaweb-ini.php``

.. code-block:: php

   $config = array(
    // site
    'url' => '',

    // debug
    // (to enable ethna_info and ethna_unittest, turn this true)
    'debug' => false,

    // db
    // sample-1: single db
    // 'dsn' => 'mysql://user:password@server/database',
    //    'dsn' => 'dbname=d5thfeu7cb8dms host=ec2-54-227-252-82.compute-1.amazonaws.com port=5432 user=himvdmapqkjhav password=zGN3cprl66dNc1Qh-HzEsTwez7 sslmode=require',
    'pghost'    => '***82.compute-1.amazonaws.com',
    'pgdbname'  => '*****',
    'pguser'    => '*****',
    'pgpassword'=> '*****',

.. code-block:: php

    <?php

     function prepare()
     {
       //Access the config array
       $host =  $this->config->get('pghost');
       $dbname = $this->config->get('pgdbname');
        
       $user = $this->config->get('pguser');
       $pass = $this->config->get('pgpassword');
       //  $dbh = new PDO('pgsql:host=localhost;dbname=[YOUR_DATABASE_NAME]');
       //  $db = new PDO('pgsql:host='.$host.';'.'dbname='.$dbname.';user='.$user.';password='.$pass);
       $db = new PDO('pgsql:host='.$host.';'.'dbname='.$dbname, $user, $pass);

All Done ! Create the table in heroku using terminal and do the queries from ethna

.. tip::

   CLI interface to connect to heroku's postgresql

   .. code-block:: bash

      $ psql -h HOSTNAME -U USERNAME DBNAME

