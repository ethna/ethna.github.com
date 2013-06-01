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
