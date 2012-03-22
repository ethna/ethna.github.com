.. _tutorial_04-database:

4. データベースの接続
======================

いよいよ `Ethna` からデータベースに接続してみます。

このページでの目標
^^^^^^^^^^^^^^^^^^

#. Ethna でデータベースに接続する
#. データベースから取り出した値を値をテンプレートで表示する


データベースの設定
^^^^^^^^^^^^^^^^^^

`etc/miniblog-ini.php` を見てみましょう。ここには、データベースなどのアプリケーションの設定が記述されています。


.. code-block:: php

  <?php

  $config = array(
      // site
      'url' => '',

      // debug
      // (to enable ethna_info and ethna_unittest, turn this true)
      'debug' => true,

      // db
      // sample-1: single db
      // 'dsn' => 'mysql://user:password@server/database',
      // ...



