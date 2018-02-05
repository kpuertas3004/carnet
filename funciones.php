<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<?php
class BasedeDatos{
  var $conexion;
  var $sentencia;
  function BasedeDatos(){
    @$this->conexion=pg_connect("host=192.168.12.188 port=5432 dbname=bs_saman user=postgres password=123456");
    if (!$this->conexion){
    echo "Error conectando con el servidor de bases de datos.";
    exit;
    }
  }

function Consultar(){
  @$resultado=pg_query($this->conexion, $this->sentencia);
    if ($resultado)
      return $resultado;
    else{
      echo "<b>Error en consulta:</b> ".pg_last_error($this->conexion);
    exit;
  }
}

function NumeroFilas($resultado){
  return pg_num_rows($resultado);
}

function AvanzarFila($resultado){
  return pg_fetch_array($resultado);
}

function LiberarResultado($resultado){
  return pg_free_result($resultado);
}

function Cerrar(){
  pg_close($this->conexion);
}
}
?>

</body>
</html>
