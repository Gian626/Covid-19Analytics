<?php
session_start();
if(sizeof($_SESSION)==0){

  session_unset();
  session_destroy();
}
require("../utils/MySQLDriver/index.php");
$mysql = new MySQLDriver();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Covid-19Analytics</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<!-- ESEMPIO DELL'HEADER COME VA FATTO -->
	<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#343791">
  <a class="navbar-brand" href="/index.php"><img src="../img/logo1.png" width="30" height="30" alt="logo" loading="lazy"></img></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!-- collapse riduce ad un bottone se la dimensione scende sotto una soglia -->
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/articoli/index.php">News</a>
      </li>
    <?php
    if(isset($_SESSION) && sizeof($_SESSION)>0){
      echo '
      <li class="nav-item">
        <a class="nav-link" href="#">Previsioni</a>
      </li>
      ';
    }
    ?>
    </ul>
		<form class="form-inline my-2 my-lg-0">
    <ul class="navbar-nav mr-auto">
    <?php
    if(sizeof($_SESSION)==0){
      echo '
      <li class="nav-item">
        <a class="nav-link" href="/login/index.html">Login</a>
      </li>
	  <li class="nav-item">
		 <a class="nav-link" href="/signup/index.html">Sign up</a>
	  </li>
      ';
    }
    else{
       echo '
       <li class="nav-item">
       <a class="nav-link" href="/logout/index.php">Logout</a>
     </li>
       ';
    }
    ?>
		
      
	   <li class="nav-item">
		 <a class="nav-link" href="#">Contact</a>
	  </li>
    </ul>
    </form>
  </div>
</nav>
<main role="main" class="container">

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Articoli</h6>
    <?php
    $query= "SELECT * FROM `articoli`";
    $result = $mysql->query($query);
    $articles=$result->fetch_all(MYSQLI_ASSOC);
    foreach($articles as $article){
    $result = $mysql-> query("SELECT * FROM imagginiarticolo WHERE ID_Art_fk='{$article['ID_Art']}'");
    $imgs = $result-> fetch_all(MYSQLI_ASSOC);
    echo"
    <div class='media text-muted pt-3'>
    <img class='bd-placeholder-img mr-2 rounded' src='{$imgs[0]['url']}' width='32' height='32'></img>
     <p class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray text'>
       <a href='/articoli/detail/index.php?id={$article['ID_Art']}'>
       <strong class='d-block text-gray-dark'>{$article['titolo']}</strong>
       </a>
       {$article['testo']}
     </p>
   </div>
    ";
    }
    ?>
  </div>
</main>
</body>
</html>