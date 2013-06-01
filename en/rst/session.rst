Session
=======

Methods are defined in Ethna's ActionClass.
We will go through them one by one.

Authenticate
------------

.. code-block:: php

   function authenticate()
   {
      if ( !$this->session->isStart() ) {
         return 'login';
      }
   }    

If the session has not started yet the user will be drawn to the ``login`` page

Starting Session
----------------

Lets say you have a login page and the user enters the password using the web form
In that case, we can start a session as:

.. code-block:: php

   function perform()
   {
       $password = $this->config->get('password');

       if ( $password == $this->af->get('password')) {
            $this->session->start();
       }
   }

.. Tip::

   - Session can be destroyed using ``$this->session->destroy()``
   - Regenerate Id ``$this->session->regenerateId()``
   