<?php
session_start();
session_destroy();

$nourl = "LogIn.php";
header('Location: '.$nourl);

?>