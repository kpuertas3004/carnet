<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <title>Censo Carnet de la Patria</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
 <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
      <!--header-->
    <div class="header">
       <img src="http://localhost/carnet/imagen/abajo.png"/>
    </div>  	
     <!--fin header-->
     <div class="container-fluid cuerpo">
     	<div class="row">
   	<div class="col-sm-2 col-md-2" >    
   	<table class="table"> 
   		<thead class="thead-dark">
    <tr>
      <th scope="col">Sucursal</th>
      <th scope="col">Total</th>      
    </tr>
  </thead>

  		<?php
      include "conexion.php";
      $sentencia="SELECT * FROM FOTO";
      $resultado=mysql_query($sentencia);
      while($filas=mysql_fetch_assoc($resultado))
   
$numero = mysql_num_rows($resultado);

echo "<th>"; echo"Caracas:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"Apure:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"Barinas:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";   
echo "<th>"; echo"Barquisimeto:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"Carupano:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"Ciudad Bolivar:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"MAracaibo:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>"; 
echo "<tr>";   
echo "<th>"; echo"Maracay:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"Margarita:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"Maturin:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"Pto. Ayacucho:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";  
echo "<th>"; echo"Pto. Fijo:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"San Cristobal:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"San Juan de los Morros:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>";
echo "<tr>";
echo "<th>"; echo"Tucupita:"; echo "</th>";
echo "<th>"; echo"$numero";echo "</th>"; 
?>
</table>
</div>
	<div class="col-sm-10 col-md-10" >
		
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Discapacidad</th>
      <th scope="col">mayores de 26</th>
      <th scope="col">Menores de 16</th>
      <th scope="col">Gravidez</th>
    </tr>
  </thead>
  <?php 
	$conexion=mysqli_connect('localhost','root','','subir_foto'); 	
	$query=mysql_query("select * from foto");
	$suma=0;
	while($sumar=mysql_fetch_array($query))
	{$suma=$suma+$sumar["hijas_femeninas"];}
	
/*imprimir en tabla*/	
	echo "<th>"; echo"$suma";echo "</th>"; 
	
	$query=mysql_query("select * from foto");
	$suma=0;
	while($sumar=mysql_fetch_array($query))
	{$suma=$suma+$sumar["hijos_mayores_26"];}
	
/*imprimir en tabla*/	
	echo "<th>"; echo"$suma";echo "</th>"; 
	
	?>	


</table>

</div>	
</div>
</div>
	



    

     


    <!--footer-->   
   <div class="modal-footer ">
    <img src="http://localhost/carnet/imagen/arriba.png"/>   
   </div>
     <!--fin footer-->
 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
<!---------------------------------------------------------------------->
    

</body>

</html>