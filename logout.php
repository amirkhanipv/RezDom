<?php
session_start();
if (isset($_SESSION['login']['status'])) {

    session_destroy();
    setcookie('remembr','',time()-(60*5));
    
}
header('Location:login.php');