<?php
session_start();
$_SESSION["Isactive"] = false;
header('Location: /');
?>