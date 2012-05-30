.. _dev-release:

リリース手順
==============

新しいリリースを出すときの手順のメモです。これもいっしょにやってくれよ、というのを見落としてたら追記していただけると助かります。


環境の前提
----------

Linux での作業を前提にしています。

必要環境
    * PHP
    * Git
    * `PEAR_PackageProjector <http://openpear.org/package/PEAR_PackageProjector>`_
    * `phpDocumentor2 <http://phpdoc.org/>`_
    * `Pirum <http://pirum.sensiolabs.org/>`_
    * Sphinx


コードフリーズし、master に merge
----------------------------------

2.6.0 を例に。gitflow 上で release ブランチを作成し、修正が済んだ状態とします。 ::

    $ git flow release finish 2.6.0

この場合、 ``2.6.0`` の annotated tag が付けられます。続いて、GitHub へ push します。 ::

    $ git checkout master
    $ git push origin master
    $ git checkout develop
    $ git push origin develop
    $ git push --tags

パッケージング
--------------

PEAR パッケージを作成します。 ``./bin/ethna_make_package.sh`` を実行します。
beta 版パッケージの場合、 ``-b`` をつけて実行します。 ::

    $ ./bin/ethna_make_package.sh
    または
    $ ./bin/ethna_make_package.sh -b

正常に実行されると、 ``/tmp/ethna`` 以下に Ethna, Smarty (2, 3), simpletest (1.0.x, 1.1.x) のパッケージが生成されます。 ::

    $ ls -la /tmp/ethna
    drwxr-xr-x 10 sotarok sotarok    4096 2012-05-30 23:03 Ethna-2.6.0beta2012053023
    -rw-r--r--  1 sotarok sotarok 1210104 2012-05-30 23:03 Ethna-2.6.0beta2012053023.tgz
    -rw-r--r--  1 sotarok sotarok 1495395 2012-05-30 23:03 Ethna-2.6.0beta2012053023.zip
    -rw-r--r--  1 sotarok sotarok   67946 2012-05-30 23:03 Smarty-2.6.26.tgz
    -rw-r--r--  1 sotarok sotarok  147445 2012-05-30 23:03 Smarty3-3.1.4.tgz
    -rw-r--r--  1 sotarok sotarok   39554 2012-05-30 23:03 package.xml
    -rw-r--r--  1 sotarok sotarok  271591 2012-05-30 23:03 simpletest-1.0.1.tgz
    -rw-r--r--  1 sotarok sotarok  283269 2012-05-30 23:03 simpletest-1.1.0.tgz

PEAR チャネルの更新
-------------------

Pirum がインストールされていない場合はインストールします。 ::

    $ pear channel-discover pear.pirum-project.org
    $ pear install pirum/Pirum

PEAR パッケージがホストされている Git リポジトリを clone してきます。 `ethna/pear - GitHub <https://github.com/ethna/pear>`_ ::

    $ git clone git@github.com:ethna/pear.git

先程生成された Ethna のパッケージを add します。optional package も、更新があれば add します。Success となれば完了。 ::

    $ pirum add . /tmp/ethna/Ethna-2.6.0beta2012053023.tgz
    ...
    Running the add command:
    ...
       INFO   Building release 2.6.0beta2012053023 for Ethna.
    ...
       INFO   Building index.
       INFO   Building feed.
       INFO   Updating PEAR server files.
       INFO   Command add run successfully.

すべて git add し、GitHub に push します (push 前に手元で確認を)。
GitHub Pages をホスティングとして使っているので、push すれば pear コマンド経由で新しいバージョンをインストールすることができるようになります。

ドキュメントの更新
------------------

* お知らせの更新

  * ``news.rst`` と ``latest_news.rst`` を更新します (公式サイトでのアナウンス)
  * ML で告知します

API ドキュメントの更新
^^^^^^^^^^^^^^^^^^^^^^

API ドキュメントは phpdoc で更新します。phpdoc は 2.0 系を使用します。 ::

    $ pear channel-discover pear.phpdoc.org
    $ pear install phpdoc/phpDocumentor-alpha

ソースコードのディレクトリで実行すると、 ``phpdoc.dist.xml`` にしたがってAPIドキュメントが生成されます。 ::

    $ phpdoc

データは ``data/phpdoc`` に生成されます。これを、ドキュメントのリポジトリの ``api/{VERSION}`` にコピーします。add したら push して完了。



