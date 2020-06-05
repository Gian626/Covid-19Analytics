<?php
require("../utils/MySQLDriver/index.php");
$username=$_POST['username'];
$password=$_POST['password'];
$email=$_POST['email'];
$subscribe=$_POST['subscribe'];
if($username==""){
    die("perfavore  inserisci l'username");
}
if($password==""){
    die("perfavore  inserisci la password");
}
if($email==""){
    die("perfavore  inserisci l'email");
}
$mysql= new MySQLDriver();
$query= "SELECT * FROM Utenti WHERE username='$username' OR email='$email'";
$result=$mysql->query($query);
 if($result->num_rows>0){
     die("username o email già esistente");
 }
 $query= "INSERT INTO Utenti (username, password , email , isAdmin , isSubscribed) 
 VALUES ('$username', '$password' , '$email' , false , $subscribe);"; 
 echo $query;
 $result=$mysql->query($query);
if($result){
    echo "registrato correttamente! clicca qui per fare il login";
    echo "<a href='/login/index.html'>login</a>";
}
else{
    echo "qualcosa è andato storto, riprova più tardi";
    echo "<a href='/signup/index.html'>signup</a>";
}
?>