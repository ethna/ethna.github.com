このドキュメントについて
=======================================

book.ethna.jp は、Ethna のドキュメントを整理するプロジェクトです。

Ethna のコミッタである `@sotarok <http://twitter.com/sotarok>`_ がドキュメント整備のために始めました。 `Sphinx` を使って作成されています。


環境
----------------

* `Sphinx 1.0.7 <http://sphinx.pocoo.org/>`_
* `git-flow 0.4 <https://github.com/nvie/gitflow>`_


リポジトリ
----------------

*  `book.ethna.jp - GitHub <https://github.com/sotarok/book.ethna.jp>`_


方針
----------------

多分結構適当です。元々の http://ethna.jp/ の内容をベースに、バージョンに沿った内容に書きなおしたりしています。

* develop ブランチはソースコードの develop ブランチを追従
* マイナーバージョンごとに develop ブランチ からのブランチを作成

  * バージョンごとのドキュメントはそのブランチ上で作業

* ソースコードの master ブランチに対するドキュメントが整ったタイミングで master に merge

  * その後リリースされているバージョンに対するドキュメントの更新は master からの hotfix で作業


ドキュメントの追加など
-----------------------

ドキュメントの間違いの指摘、修正、追加などは `GitHub` から直接 pull request を送っていただいても構いませんし、 `ML <http://ml.ethna.jp/mailman/listinfo/users>`_ で相談していただいても構いません。Pull request を送る際は、develop ブランチえ直接はコミットせず、他の名前でブランチを適当に区切ってから送ってください。

* 参考: `GitHubへpull requestする際のベストプラクティス <http://d.hatena.ne.jp/hnw/20110528>`_


ドキュメントを充実させることに協力いただけるのは大歓迎です！
