<!doctype html>

<?php
session_start(); ?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Homepage</title>
  </head>
  <?php 

  //check first if there are the two sessions
  if(isset($_SESSION["Isactive"]) && isset($_SESSION["activeSince"])){
    //if yes, then verify if is active!
    if($_SESSION["Isactive"]){
       if(strtotime("now") - $_SESSION["activeSince"] >= 60*60*24){
          $_SESSION["Isactive"] = false;
    }
  }    
}
  ?>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Carta Identità</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

      <li class="nav-item active">

      </li>
      <?php if ($_SESSION["Isactive"]): ?>
        <li class="nav-item">
        <a class="nav-link" href="/logout" id="logout">Logout</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="insertUser" href="#insert" >Inserisci utente</a>
      </li>
<?php else: ?>

  
<?php endif; ?>
    </ul>
  </div>

 


  
  <form class="form-inline" id="search-wine">
    <!--Old
      <form class="form-inline" id="search-wine" method="get" action="search.php">
      <input class="form-control mr-sm-2" type="search" placeholder="Inserisci nome vino" onkeyup="showHint(this.value)" aria-label="Search" name="searchWine">
 -->
    <input id="inputSearch" class="form-control mr-sm-2" type="search" placeholder="Inserisci nome utente">
    <button id="myBtn" class="btn btn-outline-success my-2 my-sm-0" type="submit" >Cerca</button>
  </form>

  
</nav>
<form class="invisible" id="form-wine">
  <div class="form-group">
    <label for="formGroupExampleInput">Inserisci il nome del'utente</label>
    <input id="nameUser"type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
  </div>
  <div class="form-group">
    <label for="formGroupExampleInput2">Inserisci il colore degli occhi</label>
    <input id="eyesColor" type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
  </div>
  <div class="form-group">
    <label for="formGroupExampleInput2">Inserisci il colore dei capelli</label>
    <input id="hairsColor" type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
  </div>
  <button type="button" class="btn btn-primary" onclick="sendData()">Invia Dati</button>

</form>






<!--Table -->


<div id="imgContainer"></div>
<div id="txtHint"></div>
<!--<img id="qrofWine"/>
-->

<!--My JS -->
<script>

var insertUser = document.getElementById("insertUser");
if(typeof(insertUser) != 'undefined' && insertUser != null){
  document.getElementById("insertUser").addEventListener('click', function(event){
   event.preventDefault();
   const formWine = document.getElementById("form-wine")
  formWine.classList.remove("invisible");
});
}




function getProduct(){
const queryString = window.location.search;
if(queryString === ""){
return null;
}
else{
const urlParams = new URLSearchParams(queryString);
const product = urlParams.get('product');
document.getElementById("inputSearch").value = product;
launchRequest();
}
}

getProduct();

var input = document.getElementById("inputSearch");
input.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("myBtn").click();
  }
});


document.getElementById("myBtn").addEventListener('click', function(event){
event.preventDefault();
launchRequest();

});

function sendData(){

var objectWine = {
  nameUser: document.getElementById("nameUser").value,
  eyesColor: document.getElementById("eyesColor").value,
  hairsColor: document.getElementById("hairsColor").value
}

    var xmlhttp = new XMLHttpRequest();


    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

        var response = this.responseText;
        //this.responseText è la risposta nel PHP! Da qui posso scansionare, separare e aggiungere nella table con il separateData(this.responseText)
        document.getElementById("txtHint").innerHTML = response;

      }
    }
  xmlhttp.open("POST", "../php/insertUser.php", true);
xmlhttp.setRequestHeader('Content-Type', 'application/json');
xmlhttp.send(JSON.stringify(objectWine));

}


function launchRequest(){
  var valueSearch = document.getElementById("inputSearch").value;
  if (valueSearch.length == 0) {
    document.getElementById("txtHint").innerHTML = "";
    return null;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //this.responseText è la risposta nel PHP! Da qui posso scansionare, separare e aggiungere nella table con il separateData(this.responseText)
        var response = this.responseText;
        document.getElementById("txtHint").innerHTML = response;
     
        var arrayPHP = response.replaceAll(';', '$').replaceAll('-', '$').split('$');

        var valueArray = new Array();


        console.log(arrayPHP);

        for(var i = 0; i < arrayPHP.length; i++){
          if(i%2===0 && i!==0){
            valueArray.push(arrayPHP[i]);
          }
        }

        var imgCont = document.getElementById("imgContainer");
        if(imgCont.hasChildNodes()){
        imgCont.removeChild(imgCont.firstElementChild);
        var qrimg = document.createElement("img");
        qrimg.src = valueArray[valueArray.length-1];
        imgCont.appendChild(qrimg);
        }
        else{
          var qrimg = document.createElement("img");
        qrimg.src = valueArray[valueArray.length-1];
        imgCont.appendChild(qrimg);
        }
        

        //document.getElementById("qrofWine").src = valueArray[valueArray.length-1];
        console.log(valueArray);
      }
    }
    xmlhttp.open("GET", "../php/searchUser.php?searchUser="+valueSearch, true);
    xmlhttp.send();

  }
}

</script>


<!--

-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
  </body>
  
</html>