このドキュメントについて
=======================================

book.ethna.jp は、Ethna のドキュメントを整理するプロジェクトです。 `Sphinx` を使って作成されています。


環境
------

* `Sphinx 1.0.7 <http://sphinx.pocoo.org/>`_
* `git-flow 0.4 <https://github.com/nvie/gitflow>`_


リポジトリ
------------

*  `book.ethna.jp - GitHub <https://github.com/ethna/book.ethna.jp>`_

  * 内容は、 `http://ethna.jp/` に表示されます。

Sphinxインストール方法
------------------------

Macの場合 ::

    $ sudo easy_install sphinx

Linuxの場合

aptitude/yum で python-setuptoolsをインストールした後、 ::

    $ sudo easy_install sphinx


ドキュメントのビルド方法
--------------------------

簡単です。
clone したディレクトリで ::

    $ make html

するだけです。 ``_build/html`` ディレクトリに HTML が生成されるため、HTML ファイルをブラウザで確認しましょう。


Sphinxドキュメントの書き方
--------------------------

* `Sphinxドキュメント <http://sphinx-users.jp/doc10/>`_

方針
-------


元々の `http://ethna.jp/old/` の内容をベースに、バージョンに沿った内容に書きなおしたりしています。

生成済み Sphinx ドキュメントは GitHub Pages でホスティングされており、 `http://ethna.jp/doc` に適用されます。


ドキュメントの追加など
-----------------------

ドキュメントの間違いの指摘、修正、追加などは `GitHub` から直接 pull request を送っていただいても構いませんし、 `ML <http://ml.ethna.jp/mailman/listinfo/users>`_ で相談していただいても構いません。Pull request を送る際は、master ブランチへ直接はコミットせず、他の名前でブランチを適当に区切ってから送ってください。

* 参考: `GitHubへpull requestする際のベストプラクティス <http://d.hatena.ne.jp/hnw/20110528>`_


ドキュメントを充実させることに協力いただけるのは大歓迎です！


各項の簡単なルール
--------------------

ドキュメントの名前
^^^^^^^^^^^^^^^^^^

ドキュメント名前は、 ドキュメントファイル名のスラッシュをアンダースコアに変換したものを使います。

例:
  * ``install.rst`` の場合 ``.. _install:``
  * ``reference/action.rst`` の場合 ``.. _reference_action:``


PHPコードの書き方
^^^^^^^^^^^^^^^^^^

PHPコードは、次のように code-block をつかうとハイライトされます ::

    .. code-block:: php-inline

    class Sample_Action_Sample extends Sample_ActionClass
    {
        // ...
    }


その他
-------

* API ドキュメントは、生成済みのものを /api 以下に配置しているだけで Sphinx とは関係ありません
