<?php
session_start();   //destroy sessione corrente e ti riporta nella pagina di login.
session_unset();
session_destroy();
$_SESSION = array();
ob_start();
header('Location: \index.php');
ob_end_flush();
exit();
?>