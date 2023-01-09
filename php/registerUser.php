<?php
require_once ('db/db.php');
//require_once('../insertuser.php');
if (isset($_POST['register'])) {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $isnameValid = filter_var(
        $name,
        FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^[a-z\d_]{3,20}$/i"
            ]
        ]
    );
    $pwdLenght = mb_strlen($password);
    
    if (empty($name) || empty($password)) {
        $msg = 'Compila tutti i campi %s';
    } elseif (false === $isnameValid) {
        $msg = 'Lo name non è valido. Sono ammessi solamente caratteri 
                alfanumerici e l\'underscore. Lunghezza minima 3 caratteri.
                Lunghezza massima 20 caratteri';
    } elseif ($pwdLenght < 8 || $pwdLenght > 20) {
        $msg = 'Lunghezza minima password 8 caratteri.
                Lunghezza massima 20 caratteri';
    } else {

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        
        $conn = openCon();
        $msg = insertUser($conn, $name, $password_hash);
        closeCon($conn);
    }
    
    printf($msg, '<a href="../register.html">torna indietro</a>');
}

?>