Misc References
===============

Preventing Double POST
----------------------


A neat little trick for preventing duplicate POST on form submission using Ethna's
Util class static method ``isDuplicatePost()``.

.. code-block:: php

   <?php
   function perform()
	{
           if (Ethna_Util::isDuplicatePost()) {
              //If it is a duplicate post
              return 'regist_done';
           }
	}




