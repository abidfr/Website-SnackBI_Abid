<?php 
session_start();
session_unset();
session_destroy();
setcookie('username', '', 0, '/');
setcookie('nama', '', 0, '/');
return header('location:index.php');
?>