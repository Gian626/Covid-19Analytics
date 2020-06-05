<?php
error_reporting(E_ERROR | E_PARSE);
require("../utils/MySQLDriver/index.php");
$mysql = new MySQLDriver();
 $mysql->query("INSERT INTO  articoli(titolo,testo,categoria,luogo,created_at) VALUES('{$_POST['titolo']}','{$_POST['testo']}','{$_POST['categoria']}','{$_POST['luogo']}',CURRENT_TIMESTAMP)");
 $artid=$mysql-> getLastInsertedId();
for($i=0;$i<sizeof($_FILES['immagini']['name']);$i++){
    $uploaddir = '/public/articles/';
    $ext = explode('.',$_FILES['immagini']['name'][$i]);
    $imgid = uniqid();
    $uploadfile = "..".$uploaddir . $imgid . ".". end($ext);
    $url = $uploaddir . $imgid . ".". end(explode('.',$_FILES['immagini']['name'][$i]));
    if (move_uploaded_file($_FILES['immagini']['tmp_name'][$i], $uploadfile)) {
        $mysql->query("INSERT INTO imagginiarticolo(url,ID_Art_fk)   VALUES('$url','$artid')"); 
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Upload failed";
    }
}
require("../utils/sendgrid-php/sendgrid-php.php");
$sendgrid = new \SendGrid("");
$result=$mysql->query("SELECT * FROM articoli WHERE ID_Art='$artid'");
$articolo=$result->fetch_all(MYSQLI_ASSOC);
$template=file_get_contents("./email-template.html");
$template=str_replace("{{TITOLO}}",$_POST["titolo"],$template);
$template=str_replace("{{TESTO}}",$_POST["testo"],$template);
$template=str_replace("{{ID}}",$artid,$template);
$result=$mysql->query("SELECT * FROM utenti WHERE isSubscribed = true");
$utenti=$result->fetch_all(MYSQLI_ASSOC);
foreach($utenti as $utente){
    $template=str_replace("{{USER_NAME}}",$utente["username"],$template);
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("messinagianluca66@gmail.com", "covid-19Analytics newsletter");
    $email->setSubject($_POST["titolo"]);
    $email->addTo($utente["email"], $utente["username"]);
    $email->addContent(
        "text/html", $template 
    );
    try {
        $response = $sendgrid->send($email);
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }
}
?>