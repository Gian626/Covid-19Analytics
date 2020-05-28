<?php
require("../utils/MySQLDriver/index.php");
$username=$_POST['username'];
$password=$_POST['password'];
if($username==""){
    die("perfavore  inserisci l'username");
}
if($password==""){
    die("perfavore  inserisci la password");
}
$mysql= new MySQLDriver();
$query= "SELECT * FROM Utenti WHERE username='$username'and password='$password'";
$result=$mysql->query($query);
 if($result->num_rows==0){
     die("username o password sbagliata");
 }
 session_start();
 $_SESSION['username']= $username;
 header("Location: /index.php");
 ?>