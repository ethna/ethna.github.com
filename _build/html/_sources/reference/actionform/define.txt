.. _reference_actionform_define:

フォームの定義
=======================

`ActionClass` から `ActionForm` オブジェクトを利用してフォーム値にアクセスするには、 `ActionForm` にどのようなフォーム値を受け取るかを定義する必要があります。

具体的には、 `ActionForm` のメンバ変数 ``$form`` に ::

    'フォーム名' => array(...(属性定義)...),

という形で利用するフォーム値を列挙していきます。例えば ``'id'`` と ``'name'`` というフォーム値を利用する場合は以下のようになります。 ::

    class Sample_Form_Index extends Ethna_ActionForm
    {
        protected $form = array(
            'id' => array(
                'type' => VAR_TYPE_INT,
            ),
    
            'name' => array(
                'type' => VAR_TYPE_STRING,
            ),
        );
    }


フォーム名をキーとして、値にはフォーム値の属性を定義した配列を記述します。フォーム値の属性として最大値、使用可能文字を記述しておくことで入力された値をバリデーションしたり、テンプレートのフォームヘルパによって適切なフォームの型を出力することが可能となります。
上記の例では、最低限の属性としてフォーム値の型を指定しています。


タイプ (type)
---------------

フォームの値の型には以下の種類があります。

===================== ===========================
定数                  説明
===================== ===========================
**VAR_TYPE_INT**      整数型
**VAR_TYPE_FLOAT**    浮動小数点数型
**VAR_TYPE_STRING**   文字列型
**VAR_TYPE_DATETIME** 日付(YYYY/MM/DD HH:MM:SS等)
**VAR_TYPE_BOOLEAN**  真偽値(1/0)
**VAR_TYPE_FILE**     ファイル
===================== ===========================


フォームタイプ (form_type)
--------------------------

テンプレート内で ``{form_input}`` タグを利用してフォームのHTMLを出力する際、 ``form_type`` を設定しておくことで、適切なフォームのタイプでHTMLを出力することができます。

====================== =================
定数                   説明
====================== =================
**FORM_TYPE_TEXT**     テキストボックス
**FORM_TYPE_PASSWORD** パスワード
**FORM_TYPE_TEXTAREA** テキストエリア
**FORM_TYPE_SELECT**   セレクトボックス
**FORM_TYPE_RADIO**    ラジオボタン
**FORM_TYPE_CHECKBOX** チェックボックス
**FORM_TYPE_BUTTON**   ボタン
**FORM_TYPE_FILE**     ファイル
**FORM_TYPE_HIDDEN**   隠れコントロール
====================== =================

