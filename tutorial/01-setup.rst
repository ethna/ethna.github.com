.. _tutorial_01-setup:

1. プロジェクトのセットアップ
==============================

`Ethna` でアプリケーションを作成するには、まず `プロジェクト` を作成します。


アプリケーション情報の決定
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

アプリケーションを構築する前に、少なくとも以下の 2 点を決定しておく必要があります。

#. アプリケーションID(英字のみ)

   | 例: `Sample`

#. アプリケーション配置ディレクトリ (どこでも構いません)

   | 例: ``/var/www/sample/`` とか ``C:\codes\php\`` とか適当に


アプリケーションの雛形の生成
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

``ethna`` コマンドを利用してアプリケーションを使って生成します。 ::


kアプリケーションIDが **sample** 、アプリケーション配置ディレクトリが ``/var/www/sample`` とすると、次のように ``add-project`` コマンドを使ってアプリケーションの雛形を自動的に生成することができます。 [#ref1]_ ::

    $ cd /var/www
    $ ethna add-project sample
    creating directory (/var/www/sample) [y/n]: y
    project sub directory created [/var/www/sample/app]
    project sub directory created [/var/www/sample/app/action]
    
    ...
    
    file generated [/usr/share/php/Ethna/skel/skel.view_test.php -> /var/www/sample/skel/skel.view_test.php]
    
    project skelton for [sample] is successfully generated at [/var/www/sample]

以上で、最小構成のアプリケーションが生成されます。


ディレクトリ構成の確認
^^^^^^^^^^^^^^^^^^^^^^^^^

生成されたディレクトリをのぞいてみましょう。次のような構成となっています。(一部抜粋) ::

    |-- app                 (アプリケーションのディレクトリ)
    |   |-- action          (アクションスクリプト)
    |   |-- plugin          (フィルタスクリプト)
    |   |-- test            (テストスクリプト)
    |   `-- view            (ビュースクリプト)
    |-- bin                 (コマンドラインスクリプト)
    |-- etc                 (設定ファイル等)
    |-- lib                 (アプリケーションのライブラリ)
    |-- locale
    |   `-- ja_JP
    |-- log                 (ログファイル)
    |-- schema              (DBスキーマ等)
    |-- skel                (アプリケーション用スケルトンファイル)
    |-- template
    |   `-- ja_JP           (テンプレートファイル)
    |-- tmp                 (一時ファイル)
    `-- www                 (ウェブ公開用ファイル)

よく使うのは下記のディレクトリです。

* ``app``
* ``app/action``
* ``app/view``
* ``template/ja_JP``


エントリポイントの設定
^^^^^^^^^^^^^^^^^^^^^^^^^

生成したアプリケーションにアクセスするには、 ``www`` ディレクトリを、ウェブサーバを通じてアクセス可能にするか、シンボリックリンクを作成します。

今回は、 `Apache` の `VirtualHost` を設定し、 ``http://sample.myhost/`` でアクセスできるようにしてみましょう。 ::

    $ cd ~/public_html/
    $ ln -s /tmp/sample/www/index.php .
    $ cp -r /tmp/sample/www/css ./css

以上で設定は完了です。ブラウザから ::

    http://sample.myhost/


具体的なアプリケーションの作成については :ref:`tutorial_02-action-view-tpl` を御覧下さい。


注釈
------------------

.. [#ref1] ``/var/www`` ディレクトリに適切な権限を設定する必要があります。
