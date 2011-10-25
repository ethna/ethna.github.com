.. _reference_actionform_formtemplate:

フォームテンプレート
=======================

`ActionForm` の定義を毎回配列の形で書いていくのは、数が多くなってくると非常に面倒です。フォームテンプレートは、そんな要求があった場合に、親クラスに共通の雛形を定義することで、子クラスでその定義を省略させることができる機能です。

複数の画面で共通するフォームがあったような場合に、この機能は特に有用です。

例えば、ページング処理に使う処理に使う、現在のページを表す値を ``'page'`` というキーで受け取りたいとします。ページング処理はアプリケーション全体でおそらく数カ所必要となるような頻繁に用いられる処理です。このような処理を記述するたびに、フォーム定義に ``'page' => array(...`` などと定義をしたり、他の ``'page'`` からコピーしてきたりするのは、あまり賢くありません。ほとんど共通の定義に関しては、1度定義して使い回したいですね。

そこで、 `Ethna` ではフォーム定義に使い回しのため、フォームテンプレートという機能を利用できます。


フォームテンプレートの定義
---------------------------

`Sample` というアプリケーションでは、次のようなファイル構成をしています。 ::

    .
    |-- app
    |   |-- Sample_ActionClass.php
    |   |-- Sample_ActionForm.php   <- フォームテンプレートを定義する親クラス
    |   |-- Sample_Controller.php
    |   |-- Sample_ViewClass.php
    |   |-- action
    |   |   `-- Index.php           <- テンプレートを利用してフォーム定義をする個々の ActionForm クラス
    |   ...
    ...


`ActionForm` の親クラス (例では、 `Sample_ActionForm` ) に以下のように書くだけで、子クラスの `ActionForm` でフォーム名を書くだけでその定義が使えるようになります。また、その定義の上書きも可能です。 ::

    class Sample_ActionForm extends Ethna_ActionForm
    {
        protected $form_template = array(
            'mailaddress' => array(
                'name'      => 'メールアドレス',
                'required'  => true,
                'max'       => 255,
                'filter'    => FILTER_HW,
                'custom'    => 'checkMailaddress',
                'form_type' => FORM_TYPE_TEXT,
                'type'      => VAR_TYPE_STRING,
            ),
        );
    }


フォームテンプレートの利用
---------------------------

このテンプレートを、 Index で使う場合、次のように、フォーム定義にフォーム名 (\ ``'mailaddress'``\ ) のみ記述すれば、フォームテンプレートに定義したフォームの定義が適用されます。 ::

    class Sample_Form_Index extends Sample_ActionForm
    {
        protected $form = array(
            'mailaddress' => array(),

            // その他の定義 ...
            'other_form_def' => array(
                ...
        );
    }



省略記法 (\ `2.5.0`\ 以降)
---------------------------

`Ethna 2.5.0` 以降では、次のように、フォーム名のみを指定すればよくなりました。 ::

    class Sample_Form_Index extends Sample_ActionForm
    {
        protected $form = array(
            'mailaddress',

            // その他の定義 ...
            'other_form_def' => array(
                ...
        );
    }



定義の上書き
-----------------------

定義の一部のみを上書きする場合、上書きした項目のみ定義します。以下の例では、 ``'required'`` の定義のみ変更し、その他はフォームテンプレートに定義されたものを使う例です。 ::

    class Sample_Form_Index extends Sample_ActionForm
    {
        protected $form = array(
            'mailaddress' => array(
                'required' => false,
            ),

            // その他の定義 ...
            'other_form_def' => array(
                ...
        );
    }


使い方のコツ
-----------------------

アプリケーション全体のフォーム定義をすべてひとつの親クラスに定義してしまうと、フォームテンプレート自体が巨大になってしまいます。

このような状態を回避するには、共通のカテゴリ毎に、 `ActionForm` クラスを分割し、子クラスに継承させるのもひとつの手です。


**app/Sample_ActionForm.php (Sample_ActionForm クラス)**
    親クラス

**app/Sample_ActionForm_Blog.php (Sample_ActionForm_Blog クラス)**
    `Sample_ActionForm` クラスを継承したクラス。
    Blog 関連のフォームテンプレートを定義しておき、 Blog関連の `ActionForm` では、これを継承する。

    ex. ::

        class Sample_Form_Blog_View extends Sample_ActionForm_Blog

**app/Sample_ActionForm_Admin.php (Sample_ActionForm_Admin クラス)**
    `Sample_ActionForm` クラスを継承したクラス。
    Admin 関連のフォームテンプレートを定義しておき、Admin 関連の `ActionForm` では、これを継承する。

    ex. ::

        class Sample_Form_Admin_Comment_Delete extends Sample_ActionForm_Admin
