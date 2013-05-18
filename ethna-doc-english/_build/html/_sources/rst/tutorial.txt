Tutorial
========

Setup 1 Projects
----------------

This section teaches you to build your project 
in just a few steps with Ethna using **command line**.

.. hint::

   Make sure once the Ethna is installed on your computer, you have made 
   changes to your ``php.ini`` files. i.e. pear libraries are in the include
   path. On a Mac, you would do something like the following

   .. code-block:: bash

      $ emacs /etc/php.ini
      
      And then add the appropriate path

      ; include_path = ".:/Users/YOUR-USER-NAME/pear/share/pear/"

   Similarly, make the changes to your php.ini file on other Operating Systems.


Simple Blog Application
+++++++++++++++++++++++


Here, we are going to create a simple blog application with Ethna and ethna's command line tool.

In this tutorial, there are two important learnings

1. ``Ethna`` flow of creating an application
2. How to set up a url


1. Application information
+++++++++++++++++++++++++++

Before developing an Application, there are two points to keep in mind.

1. Application ID (*must be letters*)
   e.g. miniblog

2. Application Directory. Usually on Linux, it is ``/var/www/``. Although, you may change it your directory by modifying the 
   ``/etc/apache/httpd.config`` file.

In this tutorial, we are going to use ``/var/www/``.

To create a new project command ``ethna add-project AwesomeName``

.. code-block:: bash

   $ cd /var/www
   $ ethna add-project miniblog

The above command will create a skeleton for the application. Following is the sample output.

.. code-block:: bash

   $ ethna add-project miniblog
   creating directory (/var/www/miniblog) [y/n]: y
   project sub directory created [/var/www/miniblog/app]
   project sub directory created [/var/www/miniblog/app/action]

   ...

   file generated [/usr/share/php/Ethna/skel/skel.view_test.php -> /var/www/miniblog/skel/skel.view_test.php]

   project skeleton for [miniblog] is successfully generated at [/var/www/miniblog]

Above application has been generated.

Verifying the Directory Structure
+++++++++++++++++++++++++++++++++

Let's take a peek at the directory and the files generated.

::

   | - App (directory of the application) 
   | | - Action (Action Script) 
   | | - plugin (filter script) 
   | | - test (test scripts) 
   | `- View (view script) 
   | - bin ( command line scripts) 
   | - etc (configuration files, etc.) 
   | - lib library) (application 
   | - locale 
   | `- ja_JP 
   | - log (log file) 
   | - schema (DB schema, etc.) 
   | - - skel (skeleton application file) 
   | - template 
   | `- ja_JP (template file) 
   | - tmp (temp files) 
   `- www (web publishing file)

Common use is in the following directory.

- ``app/``
- ``app/action``
- ``app/view``
- ``template/ja_JP``

2. Setting Application's Url
++++++++++++++++++++++++++++

Although you may see it on the ``localhost/miniblog/www``. Also, in order to access the application from web browser, i.e. ``var/www/``. 
We are going to set the **Apache Virtual Host** to ``http://miniblog.myhost/`` like the following:

::

   <VirtualHost *:80>
      ServerName miniblog.myhost
      DocumentRoot /var/www/miniblog/www
   </VirtualHost>

Set up is complete lets try to view in the browser

:: 

   http://miniblog.myhost/

If the set up is done correctly, you may should be able to see the following output

.. image:: ../images/tutorial_01-setup-01.png
   :scale: 100 %
   :alt: alternate text
   :align: center

Next we are create action using ethna

Flow of creation & processing: Action, View, Template
------------------------------------------------------

Prior to creating a real application, we are going to add action, view and template to our miniblog.

Create action, view, template
+++++++++++++++++++++++++++++

Next we are going to create action hello, which will be accessible from the following url

::

  http://miniblog.myhost/?action_hello=true

There are 3 things to do

- ``add-action hello``
- ``add-view hello`` 
- ``add-template hello``

Let's jump to the command line and do the above 3 steps.

.. code-block:: bash

   $ ethna add-action hello
   file generated [/var/www/miniblog/skel/skel.action.php -> /var/www/miniblog/app/action/Hello.php]
   action script(s) successfully created [/var/www/miniblog/app/action/Hello.php]

   $ ethna add-view hello
   file generated [/var/www/miniblog/skel/skel.view.php -> /var/www/miniblog/app/view/Hello.php]
   view script(s) successfully created [/var/www/miniblog/app/view/Hello.php]

   $ ethna add-template hello
   file generated [/var/www/miniblog/skel/skel.template.tpl -> /var/www/miniblog/template/ja_JP/hello.tpl]
   template file(s) successfully created [/var/www/miniblog/template/ja_JP/hello.tpl]

.. tip::

   You can add a view and template in one command by adding ``-t`` like this 
     ::

       add-view -t hello

Now, the view for the added action named ``hello`` can be viewed in the browser with the following url

::

  http://miniblog.myhost/?action_hello=true

The browser should display the following

.. image:: ../images/tutorial_02-02.png
   :scale: 100 %
   :alt: alternate text
   :align: center

Flow of processing in Ethna
+++++++++++++++++++++++++++

This diagram illustrates the flow of processing Ethna

.. image:: ../images/tutorial_02-action-view-template-01.png
   :scale: 100 %
   :alt: alternate text
   :align: center










   


 





      