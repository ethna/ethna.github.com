.. memo
   .. danger::
   .. error::
   .. attention::
   .. caution::
   .. important::
   .. hint::
   .. note::
   .. tip::


.. warning::

   このウェブサイトは現在、2.6リリースにむけて新しく整備中です (また、Sphinx での運用をテスト中です)

   ドキュメントが完全に整備されるまでは、以前のドキュメントのアーカイブを参照してください

   * http://ethna.jp/old/


.. _index:

Ethna
===================

ようこそ!
---------

`Ethna` (えすな)は、PHPを利用したウェブアプリケーションフレームワークです。

`Ethna` 以下のような特徴をもっています:

* わかりやすい MVC 風の構造
* 圧倒的に簡潔で強力なフォーム機能
* 「理想の追及」よりも「実際のアプリケーション開発」に重点をおいた現実的な設計思想

Ethna には `『絶妙に妥協』` という合言葉があります。いかに PHP らしく複雑すぎず簡単に、しかしロジカルにアプリケーションを記述するか、その絶妙なバランス感を持つフレームワークです。


.. hlist::

  * :ref:`install`
  * :ref:`news`


最新のニュース
--------------

.. include:: latest_news.rst


> :ref:`news-archive`


Quick Start
------------

PEAR をつかって今すぐ Ethna をインストール ::

  $ pear channel-discover pear.ethna.jp
  $ pear install -a ethna/ethna

Ethna コマンドでプロジェクトを作成 ::

  $ ethna add-project myproject


ドキュメント
-------------

.. toctree::
   :maxdepth: 3
   :titlesonly:
   :glob:

   install
   tutorial
   reference
   api
   cookbook
   upgrade
   article
   docdoc


.. _index-link:

リンク
----------------

* `Ethna <http://ethna.jp>`_
* `Github ethna/ethna <https://github.com/ethna/ethna>`_


.. Indices and tables
   ==================

   * :ref:`genindex`
   * :ref:`modindex`
   * :ref:`search`

