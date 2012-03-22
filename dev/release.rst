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
    * phpdoc
    * Pirum
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


PEAR チャネルの更新
-------------------

ドキュメントの更新
------------------

* お知らせの更新
* API ドキュメントの更新

リリースアナウンス
------------------


.. note::

   このドキュメントは作成中です。



