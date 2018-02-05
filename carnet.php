<?php 
$conex = "host=192.168.12.188 port=5432 dbname=bs_saman user=postgres password='123456'";
$cnx = pg_connect($conex) or die ("<h1>Error de conexion.</h1> ". pg_last_error());

$cedula = $_REQUEST['txtcedula'];
$cedulaf = $_REQUEST['txtcedulaf'];

$sql23 = "SELECT  
      per.codnip AS codnip,
      per.nombreprimero,
      per.nombresegundo,
      per.apellidoprimero,
      per.apellidosegundo,
      (CASE   
        WHEN per.edocivilcod = 'S' THEN 'SOLTERO (A)'
        WHEN per.edocivilcod = 'C' THEN 'CASADO (A)'
        WHEN per.edocivilcod = 'D' THEN 'DIVORCIADO (A)'
        WHEN per.edocivilcod = 'V' THEN 'VIUD0 (A)'
        ELSE ' - ' 
      END) AS edociv,
      (CASE   
        WHEN dat.perscategcod = 'ASI' THEN 'ASIMILADO' 
        WHEN dat.perscategcod = 'EFE' THEN 'EFECTIVO'
        WHEN dat.perscategcod = 'INV' THEN 'INVALIDEZ'
        WHEN dat.perscategcod = 'RES' THEN 'RESERVA'
        WHEN dat.perscategcod = 'TRP' THEN 'TROPA'
        ELSE '' 
      END) AS categoria,
      (CASE   
        WHEN gra.componentecod = 'EJ' THEN 'EJÉRCITO BOLIVARIANO'
        WHEN gra.componentecod = 'AR' THEN 'ARMADA BOLIVARIANA'
        WHEN gra.componentecod = 'AV' THEN 'AVIACIÓN BOLIVARIANA'
        WHEN gra.componentecod = 'GN' THEN 'GUARDIA NACIONAL BOLIVARIANA' 
        ELSE '' 
      END) as componente,
      (CASE 
        when gra.gradocod='MTM'or gra.gradocod='MM' OR gra.gradocod='MTS' then 'CNEL'
        when gra.gradocod='MT1' then 'CNEL'
        when gra.gradocod='MT2' then 'TCNEL'
        when gra.gradocod='MT3' then 'MAY'
        when gra.gradocod='ST1' then 'CAP'
        when gra.gradocod='ST2' then '1TTE'
        when gra.gradocod='ST3' then 'TTE'
        when gra.gradocod='SAY' and gra.componentecod = 'GN' then 'SS'
        when gra.gradocod='S1' and gra.componentecod = 'GN' then 'SAY'
        when gra.gradocod='S2' and gra.componentecod = 'GN' then 'SM1'
        when gra.gradocod='C1' and gra.componentecod = 'GN' then 'SM2'
        when gra.gradocod='C2' and gra.componentecod = 'GN' then 'SM3'
        when gra.gradocod='DTGDO' and gra.componentecod = 'GN' then 'S1'
        when gra.gradocod='GN' and gra.componentecod = 'GN' then 'S2'
        when gra.gradocod='MP' and gra.componentecod = 'GN' then 'SS'
        when gra.gradocod='MA' and gra.componentecod = 'GN' then 'SS'
        when gra.gradocod='MT' and gra.componentecod = 'GN' then 'SS' 
        when gra.gradocod='M1' and gra.componentecod = 'GN' then 'SS'
        when gra.gradocod='M2' and gra.componentecod = 'GN' then 'SS'
        when gra.gradocod='M3' and gra.componentecod = 'GN' then 'SS' 
        ELSE gra.gradocod 
      END) AS gradocod,
      gra.gradonombrelargo AS grado,
      (CASE   
        WHEN dat.perssituaccod = 'RCP' THEN 'RETIRADO CON PENSION'
        WHEN dat.perssituaccod = 'I' THEN 'PENSION POR INVALIDEZ'
        WHEN dat.perssituaccod = 'ACT' THEN 'ACTIVO'
         WHEN dat.perssituaccod = 'FCP' THEN 'FALLECIDO CON PENSIÓN'


        ELSE dat.perssituaccod
      END)AS situacion,

     

      (CASE   
        WHEN dir.localidadtexto <> '' THEN UPPER(dir.direccion1)||' '||UPPER(dir.direccion2)||' '|| UPPER(dir.direccion3)||' '|| UPPER(dir.direccion4)||' '||UPPER(dir.localidadtexto)
        ELSE UPPER(dir.direccion1)||' '||UPPER(dir.direccion2)||' '|| UPPER(dir.direccion3)||' '|| UPPER(dir.direccion4) 
      END) as direccion,
      per.email1,
      per.email2,
      tel.telefonocodigoarea,
      tel.telefononumero,

       (CASE   
          WHEN  per.sexocod = 'M' THEN 'MASCULINO'
          WHEN  per.sexocod = 'F' THEN 'FEMENINO'
        ELSE '' 
        END)AS sexo
      
      FROM  personas AS per
                    
      INNER JOIN pers_dat_militares AS dat
        ON per.ciaopr = dat.ciaopr
        AND per.nropersona = dat.nropersona

                                    
      INNER JOIN ipsfa_grados AS gra
        ON dat.ciaopr = gra.ciaopr
        AND dat.componentecod = gra.componentecod
        AND dat.gradocod = gra.gradocod
                                                                        
      LEFT JOIN direcciones AS dir
        ON per.ciaopr = dir.ciaopr
        AND per.nropersona = dir.nropersona
              
      LEFT JOIN localidad AS loc
        ON dir.ciaopr = loc.ciaopr
        AND dir.localidadcod = loc.localidadcod
        
      LEFT JOIN telefono_correo AS tel
        ON per.ciaopr = tel.ciaopr
        AND per.nropersona = tel.nropersona
            
      WHERE per.ciaopr = '1'
      AND per.codnip= '$cedula'"; 
  

      $registros = pg_query($sql23); 

              while ($row =pg_fetch_array($registros))
           
      {
            $nombreprimero=$row[1];
            $nombresegundo=$row[2];
            $apellidoprimero=$row[3];
            $apellidosegundo=$row[4];
            $edociv=$row[5];
            $categoria=$row[6];
            $componente=$row[7];
            $gradocod=$row[8];
            $grado=$row[9];
            $situacion=$row[10];
            $sexo=$row[16];
       
            }
            
              $nombrecompleto = $nombreprimero.' '.$nombresegundo.' '.$apellidoprimero.' '.$apellidosegundo;

$sql2 = "SELECT DISTINCT per.codnip as cedula_mil,
       --per.nombrecompleto,
        --per.fechadefuncion,
        --pen.nrohijos,
        per2.codnip as cedula_sobreviviente,
        per2.nombrecompleto as nombre_completo ,
               (CASE   
          WHEN  per2.sexocod = 'M' THEN 'MASCULINO'
          WHEN  per2.sexocod = 'F' THEN 'FEMENINO'
        ELSE '' 
        END)AS sexo,
        per2.edocivilcod,
        per2.fechanacimiento,
        per2.fechadefuncion,
        CASE 
    WHEN per2.sexocod='F' AND rel.persrelstipcod='PD' THEN 'MADRE'
    WHEN per2.sexocod='M' AND rel.persrelstipcod='PD' THEN 'PADRE' 
    WHEN per2.sexocod='F' AND rel.persrelstipcod='HJ' THEN 'HIJA'
    WHEN per2.sexocod='M' AND rel.persrelstipcod='HJ' THEN 'HIJO' 
    WHEN per2.sexocod='F' AND rel.persrelstipcod='EA' THEN 'ESPOSA'
    WHEN per2.sexocod='M' AND rel.persrelstipcod='EA' THEN 'ESPOSO'
    WHEN per2.sexocod='F' AND rel.persrelstipcod='VI' THEN 'VIUDA'
    WHEN per2.sexocod='M' AND rel.persrelstipcod='VI' THEN 'VIUDO'  
      else 
  rel.persrelstipcod
  END AS relacion,

        rel.persrelstipcod
            

FROM pers_dat_benef pdb

            INNER JOIN  personas per
                on per.ciaopr = pdb.ciaopr
                AND per.nropersona = pdb.nropersonatitular
        --AND bm.nropersonatitular = pdb.nropersonatitular
        INNER JOIN personas per2
                on per2.ciaopr = pdb.ciaopr
                AND per2.nropersona = pdb.nropersona
        INNER JOIN pers_relaciones rel
    on per.ciaopr = rel.ciaopr
                AND per.nropersona = rel.nropersona
       INNER JOIN pension pen
                on pdb.ciaopr = pen.ciaopr
                AND pdb.nropersonatitular = pen.nropersona

        INNER JOIN ipsfa_grados ip 
                         on pen.ciaopr = ip.ciaopr
                         AND pen.componentecod = ip.componentecod
                         AND pen.gradocod = ip.gradocod  
                         AND per.codnip='$cedula'
                        AND per2.codnip='$cedulaf'";

$registrosf = pg_query($sql2); 

while ($rowf =pg_fetch_array($registrosf))
           
      {
            $nombrecompletof=$rowf[2];
            $sexof=$rowf[3];
            $fechanacimientof=$rowf[5];
            $relacionf=$rowf[7];
            
            }  

$fecha1 = explode("/","$fechanacimientof"); // fecha nacimiento
$fecha2 = explode("-",date("Y-m-d")); // fecha actual

$edad = $fecha2[0]-$fecha1[0];
echo $situacion;
if(
  $fecha2[1]<=$fecha1[1] and $fecha2[2]<=$fecha1[2])
{
    $edad = $edad - 1;
} 

?>
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
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <!--===============================================================================================-->
  	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--===============================================================================================-->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="md5.js"></script>
    <!-- Custom styles for this template -->
 <link href="estilos.css" rel="stylesheet" type="text/css">
     <script src="ficha_carnet.js"></script>
</head>
<body>
    <div class="header">
       <img src="http://localhost/carnet/imagen/abajo.png"/>
    </div>
     <!--fin header-->
   <div class="container-fluid cuerpo">
 


   <form  method="POST" enctype="multipart/form-data" action="carnet.php">
              <hr>

   <div class="container">
    <h3>Datos del Militar</h3>
  <div class="row">

     <div class="col-sm-2 col-md-2">
            <label>Cédula:</label>
             <div class="input-group">
               <input class="form-control" id="txtcedula" name="txtcedula"  type="text" maxlength="8" value="<?php echo $cedula; ?>">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-success btn-flat fa fa-search"
                 id="btncopiacedula" onclick ="window.location= 'carnet.php'">

                 </button>

               </span>
             </div>
       </div>

       </div>
        <div class="row">

       <div class="col-sm-2 col-md-4">
        <label for="nombre">Nombre y Apellidos </label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $nombrecompleto; ?>" disabled="disabled" />
        </div>

         <div class="col-sm-2 col-md-4">
        <label for="sexo">Sexo</label>
            <input type="text" name="txtsexo" class="form-control" value="<?php echo $sexo; ?>" disabled="disabled"/>
          </div>

       <div class="col-sm-2 col-md-4">
        <label for="txtedocivil">Edo. Civil</label>
            <input type="text" name="txtedocivil" class="form-control" value="<?php echo $edociv; ?>" disabled="disabled"/>
          </div>

      </div>


 <div class="row">
        <div class="col-sm-2 col-md-4" >
			  <label for="nombre">Grado</label>
            <input type="text" name="txtgrado" class="form-control" value="<?php echo $grado; ?>" disabled="disabled"/>
         </div>
	      <hr>
         <div class="col-sm-2 col-md-4">
			  <label for="nombre">Componente</label>
            <input type="text" name="txtcomponente" class="form-control" value="<?php echo $componente; ?>" disabled="disabled" />
         </div>
	      <hr>
          
          <div class="col-sm-2 col-md-4">
        <label for="nombre">Situación</label>
            <input type="text" name="txtsituacion" class="form-control" value="<?php echo $situacion; ?>" disabled id="txtsituacion"/>
         </div>
	        
	</div>

   <div class="row">
        <div class="col-sm-2 col-md-4" >
        <label for="telefono">Telefono</label>
            <input type="text" name="txttelefono" class="form-control"/>
         </div>
        <hr>
         <div class="col-sm-2 col-md-4">
        <label for="txtcorreo">Correo Electrónico</label>
            <input type="text" name="txtcorreo" class="form-control"/>
         </div>
        <hr>
                            
  </div>
 
	        <hr>


<?php if ($situacion == "FALLECIDO CON PENSIÓN"){?>
<div id="datosfamiliar" >
<h3>Datos del Familiar </h3>
  <div class="row" >

     <div class="col-sm-2 col-md-2">
            <label>Cédula:</label>
             <div class="input-group">
               <input class="form-control" id="txtcedulaf" name="txtcedulaf"  type="text" maxlength="8" value="<?php echo $cedulaf; ?>">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-success btn-flat fa fa-search"
                 id="btncopiacedulaf" onclick ="window.location= 'carnet.php?cedula=$cedula'">

                 </button>

               </span>
             </div>
       </div>

       </div>
    

    <div class="row">

       <div class="col-sm-2 col-md-4">
        <label for="nombref">Nombre y Apellidos </label>
            <input type="text" name="nombref" class="form-control" value="<?php echo $nombrecompletof; ?>" disabled="disabled" />
        </div>

         <div class="col-sm-2 col-md-4">
        <label for="sexof">Sexo</label>
            <input type="text" name="txtsexo" class="form-control" value="<?php echo $sexof; ?>" disabled="disabled"/>
          </div>

       <div class="col-sm-2 col-md-4">
        <label for="txtedadf">Edad</label>
            <input type="text" name="txtedadf" class="form-control" value="<?php echo $edad; ?>"  disabled="disabled"/>
          </div>

      </div>

       

         <div class="row">
         <div class="col-sm-2 col-md-4">
        <label for="txtrelacionf">Relación</label>
            <input type="text" name="txtrelacionf" class="form-control" value="<?php echo $relacionf; ?>" disabled="disabled"/>
          </div>

        <div class="col-sm-2 col-md-4" >
        <label for="telefonof">Telefono</label>
            <input type="text" name="txttelefonof" class="form-control"/>
         </div>
        <hr>
         <div class="col-sm-2 col-md-4">
        <label for="txtcorreof">Correo Electrónico</label>
            <input type="text" name="txtcorreof" class="form-control" />
         </div>
        <hr>
                            
  </div>

</div>
<?php }?>

<br>
<br>
<h3>Datos del Carnet de la Patria</h3>
<br>
<div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#condicion" data-toggle="tab">CONDICIÓN</a></li>
              <li><a href="#n_carnetizados" data-toggle="tab">N° DE CARNETIZADOS</a></li>
              <li><a href="#familiares" data-toggle="tab">DATOS BÁSICOS DE LOS FAMILIARES</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="condicion">
                <div class="row" >

                     <hr>
                    <div class="col-sm-2 col-md-2 selectpicker">
                        <label>DISCAPACIDAD</label>
                        <select  name="discapacidad" class="js-states form-control" style="width: 100%">
                         <option value="0">No</option>
                         <option value="1">Si</option>
                        </select>
                    </div>
                        <hr>

                        <div class="col-sm-2 col-md-4">
                          <label for="nombre">DESCRIPCION</label>
                              <input type="text" name="txtescripdescap" class="form-control" />
                        </div>
                           
                    </div>

                       <div class="row">
                       <hr>
                            <div class="col-sm-2 col-md-2">
                          <label>GRAVIDEZ</label>
                          <select  name="gravidez">
                           <option value="0">No</option>
                           <option value="1">Si</option>
                          </select>
                            </div>
                          <hr>
                      </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="n_carnetizados">
                    <div class="row">

                       <div class="col-sm-2 col-md-6">
                          <label for="txtntafiliados">N° TOTAL DE AFILIADOS CON DERECHO<br></label>
                              <input type="text" name="txtnafiliados" class="form-control" />
                       </div>

                       <div class="col-sm-2 col-md-6" >
                          <label for="txtncafiliados">N° DE CARNETIZADOS CON CARNET DE LA PATRIA DEL GRUPO</label>
                              <input type="text" name="txtnafiliados" class="form-control" />
                       </div>

                       
                      </div>

                      <div class="row">

                        <div class="col-sm-2 col-md-4">
                          <label for="txtntcafiliados">N° TOTAL DE AFILIADOS CON DERECHO QUE REQUIERE SER CARNETIZADOS</label>
                              <input type="text" name="txtnafiliados" class="form-control" />
                       </div>



                      </div>




              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="familiares">


                     <div class="row">
                

                        <div class="col-sm-2 col-md-5">
                                  <div class="form-check">
                                    <label>
                                      <input type="checkbox" name="check" checked> <span class="label-text">Padre</span>
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <label>
                                      <input type="checkbox" name="check"> <span class="label-text">Madre</span>
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <label>
                                      <input type="checkbox" name="check"> <span class="label-text">Esposo (a)</span>
                                    </label>
                                  </div>
                         </div>

                          <div class="col-sm-2 col-md-5">
                              <label for="txtntafiliados">N° DE HIJOS <br></label>
                                  <input type="text" name="txtnafiliados" class="form-control" />
                           </div>
                    
                 </div>

                 <br>

                      <div class="row">

                        <div class="col-sm-2 col-md-4">
                          <label for="txtenfermedadcast">ENFERMEDAD CATASTROFICA</label>
                              <input type="text" name="txtenfermedadcast" class="form-control" />
                       </div>

                        <div class="col-sm-2 col-md-4">
                          <label for="txtdiagnosticohijo">DIAGNOSTICO</label>
                              <input type="text" name="txtdiagnosticohijo" class="form-control" />
                       </div>
                                               <div class="col-sm-2 col-md-4">
                          <label for="txtdiscapacidadhijo">DISCAPACIDAD</label>
                              <input type="text" name="txtdiagnosticohijo" class="form-control" />
                       </div>
                      </div>
                    
                    <br>
                      <div class="row">

                        <div class="col-sm-2 col-md-10">
                          <label for="txtdescripdiagnosticohijo">DESCRIPCIÓN DEL DIAGNOSTICO</label>
                              <input type="text" name="txtenfermedadcast" class="form-control" />
                       </div>

                      </div>


              </div>
 





              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
<!--------------------botones------------->
    <div class="container">
        <button type="button" class="btn btn-primary" onclick="llenarCarta()">Guardar</button>
       <!--a href="index.html"> <button type="button" class="btn btn-secondary">Cerrar</button>  </a-->
      </div>
      <!-------------------final de botones-------------------------------->


 </div>

</form>

  </div>

   <hr>




    <!--footer-->
   <div class="modal-footer ">
    <img src="http://localhost/carnet/imagen/arriba.png"/>
   </div>
     <!--fin footer-->
 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script-->
    <script src="js/bootstrap.min.js"></script>

<!---------------------------------------------------------------------->


</body>

</html>
