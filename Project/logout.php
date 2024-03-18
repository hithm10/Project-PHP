<?php
    require_once "dbClass.php";
    $db = dbClass::GetInstance();
    $db->setUserOnline($_COOKIE['user'], false);
    unset($_COOKIE['user']);
    setcookie("user", "", time() -3600);
    header("Location: index.php");
?>