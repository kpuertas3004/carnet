<?php
$db_host="localhost";
$db_user="root";
$db_password="";
$db_name="subir_foto";
$db_table_name="foto";
   $db_connection = mysql_connect($db_host, $db_user, $db_password);

if (!$db_connection) {
	die('No se ha podido conectar a la base de datos');
}
$subs_name = utf8_decode($_POST['nombre']);
$subs_grado = utf8_decode($_POST['grado']);
$subs_componente = utf8_decode($_POST['componente']);
$subs_sexo = utf8_decode($_POST['sexo']);
$subs_situacion = utf8_decode($_POST['situacion']);
$subs_cedula = utf8_decode($_POST['cedula']);
$subs_estado_civil = utf8_decode($_POST['estado_civil']);
$subs_discapacidad = utf8_decode($_POST['discapacidad']);
$subs_r_diagnostico = utf8_decode($_POST['r_diagnostico']);
$subs_gravidez = utf8_decode($_POST['gravidez']);
$subs_nombre_fallecido = utf8_decode($_POST['nombre_fallecido']);
$subs_cedula_fallecido = utf8_decode($_POST['cedula_fallecido']);
$subs_afiliado_con_derecho = utf8_decode($_POST['afiliado_con_derecho']);
$subs_grupo_con_carnet = utf8_decode($_POST['grupo_con_carnet']);
$subs_vive_padre = utf8_decode($_POST['vive_padre']);
$subs_vive_madre = utf8_decode($_POST['vive_madre']);
$subs_vive_esposo = utf8_decode($_POST['vive_esposo']);
$subs_numero_hijos = utf8_decode($_POST['numero_hijos']);
$subs_hijos_masculinos = utf8_decode($_POST['hijos_masculinos']);
$subs_hijos_mayores_26 = utf8_decode($_POST['hijos_mayores_26']);
$subs_hijas_femeninas = utf8_decode($_POST['hijas_femeninas']);
$subs_hijos_mayores_16 = utf8_decode($_POST['hijos_mayores_16']);
$subs_hijos_menores_16 = utf8_decode($_POST['hijos_menores_16']);
$subs_hijos_enfermedad = utf8_decode($_POST['hijos_enfermedad']);
$subs_hijos_diagnostico = utf8_decode($_POST['hijos_diagnostico']);
$subs_hijos_discapacidad = utf8_decode($_POST['hijos_discapacidad']);
$subs_hijos_dis_diagostico = utf8_decode($_POST['hijos_dis_diagostico']);
$subs_telefono = utf8_decode($_POST['telefono']);
$subs_email = utf8_decode($_POST['email']);
$subs_foto = utf8_decode($_POST['foto']);

$resultado=mysql_query("SELECT * FROM ".$db_table_name." WHERE Email = '".$subs_email."'", $db_connection);

if (mysql_num_rows($resultado)>0)
{

header('Location: Fail.html');

} else {
	
	$insert_value = 'INSERT INTO `' . $db_name . '`.`'.$db_table_name.'` (`nombre` ,`grado`, `componente` ,`sexo` ,`situacion` ,`cedula`,`estado_civil` ,`discapacidad` ,`r_diagnostico` , `gravidez` , `nombre_fallecido` ,`cedula_fallecido` ,  `afiliado_con_derecho`, `grupo_con_carnet`,`vive_padre` ,`vive_madre` ,`vive_esposo` ,`numero_hijos` ,`hijos_masculinos` ,`hijos_mayores_26` ,`hijas_femeninas` ,`hijos_mayores_16` ,`hijos_menores_16`,`hijos_enfermedad`,`hijos_diagnostico`,`hijos_discapacidad`,`hijos_dis_diagostico`,`telefono`,`email` , `foto`) VALUES ("' . $subs_name . '", "' . $subs_grado . '","' . $subs_componente . '","' . $subs_sexo . '","' . $subs_situacion . '", "' . $subs_cedula . '","' . $subs_estado_civil . '","' . $subs_discapacidad . '", "' . $subs_r_diagnostico . '", "' . $subs_gravidez . '","' . $subs_nombre_fallecido . '","' . $subs_cedula_fallecido . '","' . $subs_afiliado_con_derecho . '", "' . $subs_grupo_con_carnet . '","' . $subs_vive_padre . '","' . $subs_vive_madre . '","' . $subs_vive_esposo . '","' . $subs_numero_hijos . '","' . $subs_hijos_masculinos . '","' . $subs_hijos_mayores_26 . '", "' . $subs_hijas_femeninas . '", "' . $subs_hijos_mayores_16 . '","' . $subs_hijos_menores_16 . '","' . $subs_hijos_enfermedad . '","' . $subs_hijos_diagnostico . '","' . $subs_hijos_discapacidad . '","' . $subs_hijos_dis_diagostico . '","' . $subs_telefono . '","' . $subs_email . '","' . $subs_foto . '")';

mysql_select_db($db_name, $db_connection);
$retry_value = mysql_query($insert_value, $db_connection);

if (!$retry_value) {
   die('Error: ' . mysql_error());
}
	
header('Location: Success.html');

}

mysql_close($db_connection);
	

?>