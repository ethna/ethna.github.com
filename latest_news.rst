
2011/10/27 Ethna 2.6.0 beat3 リリース
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Ethna 2.6.0 beta3 をリリースしました。2.6.0 beta2 から主に以下の変更がされています。

* PHP 5.3 非推奨な記述の除去 (beta2 での抜けていた分の対応等)
* iniに url が設定されていない場合のURL判定機能
* シンプルな UrlHandler 実装 Ethna_UrlHandler_Simple の同梱 (thx. @riaf)
* simpletest 1.1 alpha3 への対応
* オプションパッケージ Smarty3、simpletest1.1 のPEARパッケージングとEthnaチャネルでの配布
* サポートしないドライバの削除: Ethna_Renderer_Rhaco, Ethna_DB_Creole
* その他バグフィックス

その他変更点の詳細は、 `CHANGES <https://github.com/ethna/ethna/blob/2.6.0beta3/CHANGES.rst>`_ をご覧ください。


また、beta2 から beta3 の間に、以下のとおり運用環境も変更されています。

* ソースコードを SourceForge.JP から GitHub に移行しました
* それにともない、バグトラッキングも GitHub の Issues を利用しています

  * リポジトリはこちらです: https://github.com/ethna/ethna
    バグトラックや、Pull Request 受け付けております

* ドキュメントを、SourceForge.JP のサーバの PukiWiki から、GitHub Pages + Sphinx に変更しました

  * ドキュメントのリポジトリはこちら: https://github.com/ethna/ethna.github.com
    誤字脱字の修正、記事の追加、以前のサイトからの記事の移行等、Pull Request 受け付けております
  * 以前の PukiWiki にあったドキュメントは、静的ファイル化し、 http://ethna.jp/old/ に移動しました。

* PEAR チャネルサーバを、SourceForge.JPのサーバの Chiara から、GitHub Pages + Pirum による運用に変更しました

  * PEARサーバのリポジトリはこちら: https://github.com/ethna/pear
    こちらは、メンテナ以外が編集する必要性等はありません。


.. caution::

  以前からEthnaを利用していて、PEARのチャネルに pear.ethna.jp が登録さてれいる方は、必ず ``channel-update`` を行なってください。 ::

    $ pear channel-update pear.ethna.jp

