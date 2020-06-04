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
      <li class="nav-item">
        <a class="nav-link" href="/articoli/index.php">News</a>
      </li>
    <?php
    if(isset($_SESSION) && sizeof($_SESSION)>0){
      echo '
      <li class="nav-item">
        <a class="nav-link" href="#">Previsioni</a>
      </li>
      ';
      $result=$mysql->query("SELECT isAdmin FROM utenti WHERE username='{$_SESSION['username']}'");
      $user=$result->fetch_all(MYSQLI_ASSOC);
      if($user[0]['isAdmin']){
        echo '
        <li class="nav-item active">
          <a class="nav-link" href="/admin/index.php">Admin</a>
        </li>
        ';
      }
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
<form enctype="multipart/form-data" action="create.php" method="post">
  <input type="text" class="" name="titolo" >
  <input type="text" class="" name="testo">
  <input type="text" class="" name="categoria">
  <input type="text" class="" name="luogo">
  <input multiple type="file" name="immagini[]"   accept="image/png, image/jpeg">
  <button type="submit" >crea</button>
  </form>
</main>
</body>
</html>