.. _reference_command:

コマンド
===================

``ethna`` コマンドについて。


.. _reference_command-add-action:

add-action
----------------------

``add-action`` コマンドは、 `ActionClass` と `ActionForm` を生成するコマンドです。 ::

    $ ethna add-action action_name ACTION

Usage::

    ethna add-action
        [-b|--basedir=dir]
        [-s|--skelfile=file]
        [-g|--gateway=www|cli|xmlrpc]
        [-w|--with-unittest]
        [-u|--unittestskel=file]
        ACTION
