<?php
session_start();
if(sizeof($_SESSION)==0){

  session_unset();
  session_destroy();
}
require('./utils/MySQLDriver/index.php');
  require('./utils/DataHandler/index.php');
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
	<link rel="stylesheet" href="./css/main.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#343791">
  <a class="navbar-brand" href="/index.php"><img src="./img/logo1.png" width="30" height="30" alt="logo" loading="lazy"></img></a>
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
        <a class="nav-link" href="/previsioni/index.php">Previsioni</a>
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
<?php
if(sizeof($_SESSION)==0){
  echo'
  <div class="jumbotron jumbotron-fluid" style="background-color:#ededed" >
  <div class="container-fluid">
    <div class="row ">
      <div class="col-4">
        <img src="./img/prev1.png" alt="..." width="300" class="img-fluid rounded display-4 mx-auto d-block"> 
      </div>
      <div class="col-4">
        <h1 class="text-center">REGISTRATI ORA!!</h1>
        <p class="lead text-center">Solo per te ci sono delle previsioni appena uscite!</p>
      </div>
      <div class="col-4">
        <img src="./img/prev1.png" alt="..." width="300" class="img-fluid rounded display-4 mx-auto d-block"> 
      </div>
    </div>
  </div>
</div>
';
}
?>
<!-- CHARTS -->
<?php 
  $query = "select * from DatiNazionali";
  $result = $mysql->query($query);
  $datiNazionali = $result->fetch_all(MYSQLI_ASSOC);
  $dataHandler = new DataHandler();
?>
<!-- Grafici Nazionali -->
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-3 m-3 p-3 shadow">
      <h5>Andamento nazionale</h5>
      <canvas id="andamentoNazionale" width="400" height="400"></canvas>
    </div>
    <div class="col-3 m-3 p-3 shadow">
      <h5>nuovi e variazione totale dei positivi</h5>
      <canvas id="variazionen" width="400" height="400"></canvas>
    </div>
  </div>
  
  <!-- Grafici Regionali -->
  <form action="/index.php" method="post">
  <div class="row justify-content-center">
<div class="col-5">
<?php
if(array_key_exists("regione", $_POST)){
  echo "<input placeholder='{$_POST['regione']}' type='text' name='regione' value='{$_POST['regione']}' class='form-control input-lg'>";
  $query="SELECT  * FROM  DatiRegionali WHERE  denominazione_regione='{$_POST['regione']}'";
}
else {
  $query="SELECT  * FROM  DatiRegionali WHERE  denominazione_regione='Lombardia'";
  echo "<input placeholder='Lombardia' type='text' name='regione' value='Lombardia' class='form-control input-lg'>";

}
$result = $mysql->query($query);
$datiRegionali = $result->fetch_all(MYSQLI_ASSOC);

?>
</div>
<div class="col-1">
 <button type="submit" class="btn btn-outline-success" >Search</button>
</div>
</div>
</form>
  <div class="row justify-content-center">
    <div class="col-3 m-3 p-3 shadow">
      <h5>Andamento Regionale</h5>
      <canvas id="andamentoRegionale" width="400" height="400"></canvas>
    </div>
    <div class="col-3 m-3 p-3 shadow">
      <h5>nuovi e variazione totale dei positivi</h5>
      <canvas id="variazioner" width="400" height="400"></canvas>
    </div>
  </div>
  <!-- Grafici Provinciali -->
  <form action="/index.php" method="post">
  <div class="row justify-content-center">
<div class="col-5">
<?php
if(array_key_exists("provincia", $_POST)){
  echo "<input placeholder='{$_POST['provincia']}' type='text' name='provincia' value='{$_POST['provincia']}' class='form-control input-lg'>";
  $query="SELECT  * FROM  DatiProvinciali WHERE  denominazione_provincia='{$_POST['provincia']}'";
}
else {
  $query="SELECT  * FROM  DatiProvinciali WHERE  denominazione_provincia='Bergamo'";
  echo "<input placeholder='Bergamo' type='text' name='provincia' value='Bergamo' class='form-control input-lg'>";

}
$result = $mysql->query($query);
$datiProvinciali = $result->fetch_all(MYSQLI_ASSOC);

?>
</div>
<div class="col-1">
 <button type="submit" class="btn btn-outline-success" >Search</button>
</div>
</div>
</form>

  <div class="row justify-content-center">
    <div class="col-3 m-3 p-3 shadow">
      <h5>Andamento Provinciale</h5>
      <canvas id="andamentoProvinciale" width="400" height="400"></canvas>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
  <script>
    //grafici nazionali
    var andamentoNazionaleCanvas = document.getElementById('andamentoNazionale').getContext('2d');
    var variaNazionaleCanvas = document.getElementById('variazionen').getContext('2d');
    var andamentoNazionaleCanvasCfg = <?php echo $dataHandler->getConfig(
      $datiNazionali, 
      array(
        "Totale Positivi" => array(
          "key" => "totale_positivi", 
          "borderColor" => "rgba(255, 99, 132, 1)"
        ),
        "Totale Deceduti" => array(
          "key" => "deceduti",
          "borderColor" => "rgba(182, 189, 191, 1)"
        ),
        "Totale Guariti" => array(
          "key" => "dimessi_guariti",
          "borderColor" => "rgba(66, 235, 63, 1)"
        )
      )
    );
    ?>
    var variaNazionaleCanvasCfg = <?php echo $dataHandler->getConfig(
      $datiNazionali, 
      array(
        "Nuovi Positivi" => array(
          "key" => "nuovi_positivi", 
          "borderColor" => "rgba(255, 99, 132, 1)"
        ),
        "Variazione Totale Positivi" => array(
          "key" => "variazione_totale_positivi",
          "borderColor" => "rgba(182, 189, 191, 1)"
        )
      )
    );
    ?>
    var chart1 = new Chart(andamentoNazionaleCanvas, andamentoNazionaleCanvasCfg);
    var chart2 = new Chart(variaNazionaleCanvas, variaNazionaleCanvasCfg);
    //grafici regionali
    var andamentoRegionaleCanvas = document.getElementById('andamentoRegionale').getContext('2d');
    var variaRegionaleCanvas = document.getElementById('variazioner').getContext('2d');
    var andamentoRegionaleCanvasCfg = <?php echo $dataHandler->getConfig(
      $datiRegionali,
      array(
        "Totale Positivi" => array(
          "key" => "totale_positivi", 
          "borderColor" => "rgba(255, 99, 132, 1)"
        ),
        "Totale Deceduti" => array(
          "key" => "deceduti",
          "borderColor" => "rgba(182, 189, 191, 1)"
        ),
        "Totale Guariti" => array(
          "key" => "dimessi_guariti",
          "borderColor" => "rgba(66, 235, 63, 1)"
        )
      )
     );
     ?>
     var variaRegionaleCanvasCfg = <?php echo $dataHandler->getConfig(
      $datiRegionali, 
      array(
        "Nuovi Positivi" => array(
          "key" => "nuovi_positivi", 
          "borderColor" => "rgba(255, 99, 132, 1)"
        ),
        "Variazione Totale Positivi" => array(
          "key" => "variazione_totale_positivi",
          "borderColor" => "rgba(182, 189, 191, 1)"
        )
      )
    );
    ?>
    var chart3 = new Chart(andamentoRegionaleCanvas, andamentoRegionaleCanvasCfg);
    var chart4 = new Chart(variaRegionaleCanvas, variaRegionaleCanvasCfg);
    //grafici provinciali
    var andamentoProvincialeCanvas = document.getElementById('andamentoProvinciale').getContext('2d');
    var andamentoProvincialeCanvasCfg = <?php echo $dataHandler->getConfig(
      $datiProvinciali,
      array(
        "Totale Positivi" => array(
          "key" => "totale_casi", 
          "borderColor" => "rgba(255, 99, 132, 1)"
        )
      )
     );
     ?>
    var chart5 = new Chart(andamentoProvincialeCanvas, andamentoProvincialeCanvasCfg);
  </script>
</div>

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