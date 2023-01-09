<?php

include "myqr.php";
//Start session! Storage so low 
session_start();

function openCon(){
/* Host name of the MySQL server */
$host = 'localhost';
/* MySQL account username */
$user = 'root';
/* MySQL account password */
$passwd = '';
/* The schema you want to use */
$dataschema = 'phpproj';
/* Connection with MySQLi, procedural-style */


$conn = new mysqli($host, $user, $passwd,$dataschema) or die("Connect failed: %s\n". $conn -> error);


// Check connection
if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $conn -> connect_error;
    exit();
  }


return $conn;
}




function closeCon($conn)
 {
 $conn -> close();
 }


function isValidJSON($str) {
  json_decode($str);
  return json_last_error() == JSON_ERROR_NONE;
}

function selectQuery($conn){
// get the q parameter from URL
    $q = $_REQUEST["searchUser"];


    $sql = "select * from UserParameters where nameUser='". $q ."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
     //update the table   
     while($row = $result->fetch_assoc()) {
        echo "-id;" . $row["idproduct"]. "-nameUser;" . $row["nameUser"]."-eyesColor;" . $row["eyesColor"]. "-hairsColor;" . $row["hairsColor"]. "";
      }
    } else {
      echo "0 results";
    }


    

} 
function insertQuery($conn){

  
// Takes  data from the request
  $data = file_get_contents('php://input');


  //decode json data
  header("Content-Type: application/json; charset=UTF-8");
$obj = json_decode($data);
  // Converts it into a PHP object
//$data = json_decode($json);

$sql = "INSERT INTO `UserParameters` (`nameUser`, `eyesColor`, `hairsColor`) VALUES ( '" . $obj->nameUser."', '". $obj->eyesColor."', '". $obj->hairsColor."')";
$result = $conn->query($sql);

$generateWineQR = qrUrl($obj->name);
}


function insertUser($conn, $name, $passhash) {

  $sql = "SELECT id FROM `users` WHERE username = '". $name."' ";
        
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $msg = 'name già in uso %s';
  }

  
  else {
    

    $sql2 = "INSERT INTO `users` (`username`, `password`) VALUES ('". $name."', '". $passhash."') ";
    $result2 = $conn->query($sql2);         
  $msg = "Eseguita query";

 if ($result->num_rows > 0) {
  $msg = 'Alcuni problemi forse';

 
} else {
  $msg = 'Registrazione eseguita con successo';
}

}
return $msg;
}

function loginUser ($conn, $name, $passwordinserita){ 

$sql = "SELECT username, password FROM `users` WHERE username = '". $name."' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {



while($user = $result->fetch_assoc()){
  if (password_verify($passwordinserita, $user['password'])){

    $_SESSION["Isactive"] = true;
    $_SESSION["activeSince"] = strtotime("now");
    header('Location: /');
    
  }
}

//echo "Ho trovato quello giusto ed è<br>";
//echo $name;
}
else{
  echo "Non c'è nulla";
}

}

/*
while ($user = $result->fetch_assoc()){

  if (password_verify($passwordinserita, $user['password'])){
    
  }
  if ($user['password'] != $password){
      die('Invalid Password');
  }
}
}*/

  function insertSomething($conn){

  
  
      // Converts it into a PHP object
    //$data = json_decode($json);
    
    $sql = "INSERT INTO `UserParameters` (`nameUser`, `eyesColor`, `hairsColor`) VALUES ( 'Carlo', 'Marroni', 'Marroni')";
    $result = $conn->query($sql);
    }

  function stupidfunction(){
    echo "Ciao";
  }

