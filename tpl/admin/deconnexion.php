<?php
@session_start();
unset($_SESSION);
setcookie('password', false , time()-3600, '/');
session_destroy();
header('location:/');
?>