
<?php
//routing!
$request = $_SERVER['REQUEST_URI'];


// For taking parameters with the routing
if(strpos($request, "/?") !== false or strpos($request, "?") !== false){
    if(strpos($request, "/?") !== false){
        $str = explode('/?', $request);
        $beforepara = $str[0];


    }
    if(strpos($request, "?") !== false){
        $str = explode('?', $request);
        $beforepara = $str[0];
}
} 

else{
   $beforepara = $request;
}

//real routing
switch ($beforepara) {
    case '/' :
        require __DIR__ . '/views/index.php';
        break;
    case '' :
        require __DIR__ . '/views/index.php';
        break;
    case '/register' :
        require __DIR__ . '/views/register.html';
        break;
    case '/login' :
      require __DIR__ . '/views/login.html';
      break;
    case '/logout' :
      require __DIR__ . '/php/logout.php';
      break;
    default:
        require __DIR__ . '/views/404.php';
        break;
}
?>
