<?php

require '../include/node/function.php';

 if (isset($_SESSION['auth'])) {
    logouSession();
    redirect('../signin.php', 'Log Out Successfuly');
 }
?>