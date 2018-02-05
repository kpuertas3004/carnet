<?php
require_once 'registro.php';
$nom=$_REQUEST["txtnombre"];
$subs_foto=$_FILES["foto"]["name"];
$ruta=$_FILES["foto"]["tmp_name"];
$destino="fotos/".$foto;
copy($ruta,$destino);
mysql_query("insert into foto (nombre,foto) values('$nom','$destino')");
header("Location: index.html");
?>




