Login viewer

insert this code in the wp-login.php
before redirection..

 if (function_exists('postUserLogged')) {
                    postUserLogged($user);
                }