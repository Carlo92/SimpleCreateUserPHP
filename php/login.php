<?php
session_start();
require_once('db/db.php');

if (isset($_SESSION['session_id'])) {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $msg = 'Inserisci username e password %s';
    } else {
        $conn = openCon();
        loginUser($conn, $username, $password);
        closeCon($conn);

    }
    
    printf($msg, '<a href="../login.html">torna indietro</a>');
}