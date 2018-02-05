<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php

@session_start();
include("funciones.php");

//Obtener datos
$user=($_POST["user"]);
$paswd=($_POST["paswd"]);
$bd=new BasedeDatos();
$bd->sentencia="SELECT usuariocodigo, usuarioclave FROM seg_usuarios WHERE usuariocodigo='$user' and usuarioclave='$paswd'";
$rs=$bd->Consultar();

if ($bd->NumeroFilas($rs)>0){

		$fila=$bd->AvanzarFila($rs);
		$_SESSION["user"]=$fila["usuariocodigo"];
		$_SESSION["paswd"]=$fila["usuarioclave"];

		echo "<script type='text/javascript'>
				location.href='carnet.php';
			</script>";

$bd->Cerrar();
}else{
	echo "<script type='text/javascript'>
				location.href='logout.php';
			</script>";
exit;
}
?>

</body>
</html>
