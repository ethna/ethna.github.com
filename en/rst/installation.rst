Installation
============

Install Using PEAR
------------------

Ethna can be installed using pear command. It is the simplest and recommended. Note that you need to have `pear <http://pear.php.net/>`_ installed on your system. 

Only for the first time, you need to register a channel for Ethna using ``channel-discover`` as:

.. warning::

   If your pear version is old, then it ``channel-discover`` will get to discover. Therefore, please run

   .. code-block:: bash

      pear upgrade pear

.. code-block:: bash

   $ pear channel-discover pear.ethna.jp


Once the channel of Ethna is discovered, you are ready to install Ethna

.. code-block:: bash

   $ pear install -a ethna/ethna

From this command, the dependent library ``Smarty`` and ``simpletest`` will be installed at the same time. If you don't want to install them together then just ommit the option ``-a``.

Once the installation is finished, verify ``ethna``, using the following command.

.. code-block:: bash

   $ ethna -v
   Ethna 2.6.0 (using PHP 5.3.6-6~dotdeb.1)

   Copyright (c) 2004-2011,
   Masaki Fujimoto <fujimoto@php.net>
   halt feits <halt.feits@gmail.com>
   Takuya Ookubo <sfio@sakura.ai.to>
   nozzzzz <nozzzzz@gmail.com>
   cocoitiban <cocoiti@comio.info>
   Yoshinari Takaoka <takaoka@beatcraft.com>
   Sotaro Karasawa <sotaro.k@gmail.com>

   http://ethna.jp/

.. Note::

   The stable Version 2.5.0 will be installed. Ethna 2.6.0 is currently in beta. If you wish to install the beta then choose the following command.

   .. code-block:: bash

      $ pear install ethna/ethna-beta

Update Ethna using PEAR
-----------------------

To update ethna, you may run the following

.. code-block:: bash

   $ pear upgrade ethna/ethna

It is also possible to upgrade via downloading the package using wget.

.. code-block:: bash

   $ wget -O Ethna-2.6.x.tar.gz  https://github.com/ethna/ethna/tarball/2.6.x
   $ pear upgrade Ethna-2.x.y.tgz
