.. _install:

インストール
===================

ここでは Ethna のインストール方法について説明します。


PEAR コマンドを使ったインストール
-----------------------------------

PEAR コマンドを使ったインストールが最も簡単であるため、推奨します。
システムに PEAR がインストールされている必要があります。 [#ref1]_

最初の1回だけ、 ``channel-discover`` で Ethna のチャネルを登録する必要があります。 ::

    $ pear channel-discover pear.ethna.jp

Ethna の PEAR チャネルが登録されたら、次のようにインストールします。 ::

    $ pear install -a ethna/ethna

このコマンドでは、依存ライブラリである `Smarty` や `simpletest` なども同時にインストールされます。もし依存ライブラリを同時にインストールしたくない場合は、 ``-a`` オプションを付けずに、 ::

    $ pear install ethna/ethna

としてください。

インストールが終われば、 ``ethna`` コマンドが使えるようになっているはずです。 ::

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


PEAR コマンドを使ったアップグレード
-----------------------------------

アップデートは、次のコマンドで実行します。 ::

    $ pear upgrade ethna/ethna

ダウンロードしたを利用してアップグレードすることも可能です。 ::

    $ wget -OEthna-2.x.y.tgz http://..../Ethna-2.x.y.tgz
    上記のURLは、実際には、 github 上のURLを取得してください
    $ pear upgrade Ethna-2.x.y.tgz


注釈
-------------------

.. [#ref1] 共有のレンタルサーバ等で、PEAR コマンドを使えない場合でも、ソースコードのアーカイブを取得して展開すればインストールできます。本質的には、 ``include_path`` の通った場所に置けば問題ありません (ただし、Ethna コマンドを使うには別途設定が必要)
