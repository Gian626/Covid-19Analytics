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

?>