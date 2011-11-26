.. _tutorial_03-logic:

3. アプリケーションの実装
=====================================================

ここから、ひとことブログアプリの実装を始めます。


このページでの目標
^^^^^^^^^^^^^^^^^^

#. 投稿を処理するアクションを追加し、フォームを定義する
#. フォームから入力された値を出力する
#. フォームから入力された値を検証する


アクションを追加
^^^^^^^^^^^^^^^^^^

さっそく、アクションを追加しましょう。今回作成するひとことブログでは、トップページにブログのリストを表示し、そこに投稿フォームを設置します。トップページのアクションは、アプリケーション作成時に自動的に `Indexアクション` が生成されているため、追加で必要となるアクションは、フォームを処理するアクションです。ここでは、 `Commitアクション` としましょう。

次のように、 `Commitアクション` を作成します。 ::

  $ ethna add-action commit
  file generated [/var/www/miniblog/skel/skel.action.php -> /var/www/miniblog/app/action/Commit.php]
  action script(s) successfully created [/var/www/miniblog/app/action/Commit.php]


このアクションは、

* 投稿の内容を検証
* 投稿をデータベースに保存
* トップページにリダイレクト

といった処理を行います。リダイレクトしてしまうため、ビュークラスとテンプレートは不要なので、生成しません。


フォームの作成
^^^^^^^^^^^^^^^^^^

投稿にあたって、どのようなフォームが必要となるかを考えましょう。ひとことブログなので、「内容」だけあればよさそうですね。


フォームの定義
--------------

``app/action/Commit.php`` を開き、アクションフォームに次のような設定をします。

.. code-block:: php-inline

  class Miniblog_Form_Commit extends Miniblog_ActionForm
  {
      protected $form = array(
          'comment' => array(
              'type' => VAR_TYPE_STRING,
              'form_type' => FORM_TYPE_TEXTAREA,
              'name' => 'コメント',
              'max' => 140,
              'required' => true,
          ),
      );
  }

これは、

* 「コメント」という名前のフォーム
* 値のタイプは文字列
* フォームタイプは TEXTAREA
* 140文字以内
* 必須項目

という、フォームを定義しています。

また、アクションクラスは、 `index` に戻るようにしておきましょう。 [#ref1]_

.. code-block:: php-inline

  class Miniblog_Action_Commit extends Miniblog_ActionClass
  {
      public function prepare()
      {
          return null;
      }

      public function perform()
      {
          return 'index';
      }
  }


フォームの表示
---------------

続いて、フォームを表示します。フォームは、トップページ (`Indexアクション`) に表示するため、テンプレートファイル ``template/ja_JP/index.tpl`` を編集します。

フォームを出力するための ``{form}`` タグと ``{form_input}`` タグ、 ``{form_submit}`` タグを用います（これらのタグは、フォームヘルパと呼ばれます）。

.. code-block:: html

  <h2>投稿</h2>

  {form name="form_comment" ethna_action="commit"}
    投稿内容:
    {form_input name="comment"}

    {form_submit}
  {/form}


``{form}`` タグには、 ``name`` フォーム名（適当でOK）と、送信したときどのアクションを実行するか (``ethna_action``)、を記述します。 ``ethna_action`` を設定することにより、そのアクションフォーム `Miniblog_Form_Commit` の設定が浸かるようになります。

``{form_input}`` タグは、フォームの要素を出力します。 `Miniblog_Form_Commit` の ``$form`` プロパティに設定した、 ``comment`` を出力するため、 ``name="comment"`` としています。

``{form_submit}`` タグは、送信ボタンを出力します。

ここまでできたら、ブラウザでアクセスしてみましょう。うまくいけば、フォームが出力されています。

.. image:: ../images/tutorial_03-01.png


投稿内容を表示
^^^^^^^^^^^^^^^

ここまでの状態では、 `submit` をクリックしてもなにも表示できない状態ですね。投稿内容を表示させてみましょう。先ほどの ``index.tpl`` に、次のように ``{$form.comment}`` を追記します。

.. code-block:: html

  <h2>投稿内容</h2>
  {$form.comment}


こうすると、テキストエリアに入力したコメントの内容が出力されたことがわかります。
このように、フォームに入力された内容は、テンプレートの中では ``$form`` 変数を用いてアクセスすることができます。

ところで、今フォームのテキストエリア内にも、内容が表示されていることがわかりますか？
`Ethna` では、フォームヘルパを用いれば、フォームの値をあらかじめフォームに埋めておくような処理はフレームワークが勝手にやってくれます。
これは、例えば、エラーで入力画面に戻った場合に、送信された値をフォームに入れておく、などの処理を書く必要がなくアクションフォームとフォームヘルパがうまく連携してやってくれる、ということです。


投稿内容の検証とエラーの表示
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

このままでは、まだフォームの入力内容をなにもチェックしていない状態ですし、内容に不備があった場合でも何のメッセージも表示されませんね。

投稿内容の検証
--------------

まず、アクションクラスに、フォームの検証をする処理を追加してみます。フォームの検証は、 `Commitアクション` の ``prepare()`` メソッド内で行います。

.. code-block:: php-inline

      public function prepare()
      {
          if ($this->af->validate() > 0) {
              return 'index';
          }

          return null;
      }

``$this->af`` には、アクションフォームオブジェクト (`ActionForm` なので、 `af`) が入っています。 ``validate()`` メソッドを実行すると、フォーム値の検証が行われます。その戻り値はエラー数です。ここでは、エラー数が 0 より大きければ ``return 'index'`` として、 `Indexビュー` に遷移します。

ここでのポイントは、 ``prepare()`` で ``return 'index'`` とすることによって、 ``perform()`` メソッドが実行されない、ということです。 ``prepare()`` メソッドと ``perform()`` メソッドの戻り値は、それが `null` でなければ、ビュー名として扱われます。検証した結果 ``prepare()`` メソッドで ``'index'`` が返されることにより、このアクションは、 **エラーが発生したら perform() メソッドにはいかず、Indexビューに遷移する** といった処理になります。


エラーの表示
-------------

それでは、 ``index.tpl`` に戻り、どのようなエラーが発生したのかを表示してみます。フォームを次のように編集します。

.. code-block:: html

  <h2>投稿</h2>
  {if count($errors) > 0}
    入力内容にエラーがあります。
  {/if}

  {form name="form_comment" ethna_action="commit"}

    投稿内容:<br />
    {message name="comment"}<br />
    {form_input name="comment"}

    {form_submit}

  {/form}

フォームのエラー内容は ``{$errors}`` 変数に入っています。これが 0 より大きければ、「入力内容にエラーがあります。」と出力します。
また、 ``{message}`` タグをもちいて、 `comment` のエラー内容を取得しています。

例えば 、こうすると、何も入力せずに `POST` したとき、次のように、エラーが表示されます。

.. image:: ../images/tutorial_03-02.png


また、140文字以上入力して送信した場合「コメントは140文字以下で入力して下さい」を出力されます。


^^^^^^^

フォームの定義から検証・出力の流れがつかめましたか？

続いて、データベースに接続し、この投稿内容を保存できるようにしてみましょう。

注釈
^^^^^^^^^^^^^^^

.. [#ref1]
  デフォルトで作成されるアクションクラスは、 `Commitビュー` を使うようになっていますが、今回は `Commitビュー` は作成していないためです。後々、ここは正常に処理が終了した場合はリダイレクトする処理へとなります。
