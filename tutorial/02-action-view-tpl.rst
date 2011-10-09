.. _tutorial_02-action-view-tpl:

2. アクション、ビュー、テンプレートの作成
=========================================

アプリケーションのセットアップが済んだら、"Hello World"アクションを作成してみましょう。


Hello Worldを表示するアクション
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
仕様

下記URLでアクセスすると、画面にHello Worldが表示されるようにします。

http://sample.myhost/index.php?action_hello=true

やるべきことは３つです

* Helloアクションの追加
* Helloビューの作成(省略可能)
* Helloテンプレートの追加

Ethnaコマンドを使ってそれぞれ作成します。 ::

    $ ethna add-action hello
    $ ethna add-view   hello
    $ ethna add-template hello

上記URLでアクセスすれば、Hello Worldが表示されます。

Ethnaにおける処理の流れ
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
ここで、Ethnaの処理の流れについて説明します。

Ethnaは、クライアント(この場合はブラウザ)から上記リクエストを受け取ると、まずhelloアクションを呼び出します。

helloアクションの実体は、sample/app/action/Hello.phpファイルであり、Sample_Action_Helloクラスです。

このクラスでは、peformメソッドが'hello'という文字列を返しています。

これは遷移先をビュー名を意味しています。
「以降の処理は'hello'ビューに任せる」という意味です。 ::

    class Sample_Action_Hello extends Sample_ActionClass
    {
        ...

        function perform()
        {
            return 'hello';
        }
    }    

Ethnaは、アクションクラスからこの指示を受け取ると、Helloビュークラスを呼び出してpreforwardメソッドを実行します。

Helloビュークラスでは、preforwardの中身は空になっているので何も行われません。
(このような場合、ビュークラス作成を省略してもかまいません) ::

    class Sample_View_Hello extends Sample_ViewClass
    {
        function preforward()
        {
        }
    }


最後に、Ethnaがhelloテンプレートを呼び出して、レスポンスとして返します(ブラウザに画面が表示されます)。


