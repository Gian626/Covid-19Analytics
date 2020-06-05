<?php
session_start();
if(sizeof($_SESSION)==0){

  session_unset();
  session_destroy();
}
require("../../utils/MySQLDriver/index.php");
$mysql = new MySQLDriver();

?>
<!doctype html>
<html lang="en">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>NEWS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../css/main.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#343791">
  <a class="navbar-brand" href="/index.php"><img src="../../img/logo1.png" width="30" height="30" alt="logo" loading="lazy"></img></a>
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
      $result=$mysql->query("SELECT isAdmin FROM utenti WHERE username='{$_SESSION['username']}'");
      $user=$result->fetch_all(MYSQLI_ASSOC);
      if($user[0]['isAdmin']){
        echo '
        <li class="nav-item">
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
<div class="container">
  <div class="row mb-2 justify-content-center">
    <div class="col">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <?php
        $result=$mysql->query("SELECT * FROM articoli, imagginiarticolo WHERE articoli.ID_Art='{$_GET['id']}' and  imagginiarticolo.ID_Art_fk=articoli.ID_Art");
        $articoli=$result->fetch_all(MYSQLI_ASSOC);
        $articolo=$articoli[0];
        if(sizeof($articoli)==0){
          header("Location: /articoli/index.php");
        }
        for($i=0;$i<sizeof($articoli); $i++){
          if($i==0){
            echo "
            <div class='carousel-item active'>
              <img src='{$articoli[$i]['url']}' class='d-block w-100  img-fluid'>
            </div>
            ";
          }
          else{
            echo "
            <div class='carousel-item'>
              <img src='{$articoli[$i]['url']}' class='d-block w-100  img-fluid'>
            </div>
            ";
          }
        }
        ?>
        
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
  </div>
</div>

<main role="main" class="container">
  <div class="row">
    <div class="col blog-main">
      <div class="blog-post">
        <h2 class="blog-post-title"><?php echo $articolo['titolo']?></h2>
        <p class="blog-post-meta"><?php echo date($articolo['created_at'])?></p>
        <p class="text-justify"><?php echo $articolo['testo']?></p>
      </div><!-- /.blog-post -->
  
    </div><!-- /.blog-main -->
  </div><!-- /.row -->
</main><!-- /.container -->
<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="KY2HSH2H98KYY" />
<input type="image" src="/img/paypal.png" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_IT/i/scr/pixel.gif" width="1" height="1" />
</form>
    </p>
    <p>Dona pure per la causa al corona e tieniti aggiornato!!</p>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
