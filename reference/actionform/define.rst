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


タイプ (type)
---------------

* **VAR_TYPE_INT**
* **VAR_TYPE_FLOAT**
* **VAR_TYPE_STRING**
* **VAR_TYPE_DATETIME**
* **VAR_TYPE_BOOLEAN**
* **VAR_TYPE_FILE**

フォームタイプ (form_type)
--------------------------
