<?php 
$conex = "host=192.168.12.188 port=5432 dbname=bs_saman user=postgres password='123456'";
$cnx = pg_connect($conex) or die ("<h1>Error de conexion.</h1> ". pg_last_error());

$cedula = $_REQUEST['txtcedula'];
$cedulaf = $_REQUEST['txtcedulaf'];

$sql23 =   "SELECT  
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
	        per2.codnip as cedula_sobreviviente,
	        per2.nombrecompleto as nombre_completo,
	        (CASE   
	        	WHEN  per2.sexocod = 'M' THEN 'MASCULINO'
	        	WHEN  per2.sexocod = 'F' THEN 'FEMENINO'
	        	ELSE '' 
	        END)AS sexo,
	        per2.edocivilcod,
	        per2.fechanacimiento,
	        per2.fechadefuncion,
	        (CASE 
			    WHEN per2.sexocod='F' AND rel.persrelstipcod='PD' THEN 'MADRE'
			    WHEN per2.sexocod='M' AND rel.persrelstipcod='PD' THEN 'PADRE' 
			    WHEN per2.sexocod='F' AND rel.persrelstipcod='HJ' THEN 'HIJA'
			    WHEN per2.sexocod='M' AND rel.persrelstipcod='HJ' THEN 'HIJO' 
			    WHEN per2.sexocod='F' AND rel.persrelstipcod='EA' THEN 'ESPOSA'
			    WHEN per2.sexocod='M' AND rel.persrelstipcod='EA' THEN 'ESPOSO'
			    WHEN per2.sexocod='F' AND rel.persrelstipcod='VI' THEN 'VIUDA'
			    WHEN per2.sexocod='M' AND rel.persrelstipcod='VI' THEN 'VIUDO'  
			    else rel.persrelstipcod
		  	END) AS relacion            
		FROM pers_dat_benef pdb
            INNER JOIN  personas per
            	ON per.ciaopr = pdb.ciaopr
                AND per.nropersona = pdb.nropersonatitular
        	INNER JOIN personas per2
                ON per2.ciaopr = pdb.ciaopr
                AND per2.nropersona = pdb.nropersona
        	INNER JOIN pers_relaciones rel
    			ON per.ciaopr = rel.ciaopr
                AND per.nropersona = rel.nropersona
       		INNER JOIN pension pen
                ON pdb.ciaopr = pen.ciaopr
                AND pdb.nropersonatitular = pen.nropersona
	        INNER JOIN ipsfa_grados ip 
                ON pen.ciaopr = ip.ciaopr
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
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins.ipsfa/_all-skins_1.css">
    <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="css/semantic.min.css">
    <link rel="stylesheet" href="css/dataTables.semanticui.min.css">
    <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="bower_components/fancy/dist/jquery.fancybox.css">
    <link rel="stylesheet" href="css/fonts.googleapis.css">
  <!--===============================================================================================-->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/notify/notify.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="bower_components/barcode/dist/JsBarcode.all.js"></script>
    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="bower_components/fancy/dist/jquery.fancybox.min.js"></script>
 <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="header">
       <img src="imagen/abajo.png"/>
    </div>
     <!--fin header-->
   <div class="container-fluid cuerpo">
 

     <form  method="POST" enctype="multipart/form-data" action="carnet.php" class="form-horizontal">
      <div class="box box-primary box-solid">
       <hr>

        <div class="box-header with-border">
          <h3 class="box-title">Datos del Militar</h3>
        </div>
        <div class="box-body">

		  	<div class="row">
			    <div class="col-sm-2 col-md-2">
			        <label>Cédula:</label>
			            <div class="input-group">
			                <input class="form-control"  id="txtcedula" name="txtcedula"  type="text" maxlength="8" value="<?php echo $cedula; ?>">
			               	<span class="input-group-btn">
	                        <button type="submit" class="btn btn-success btn-flat btn-md" id="btnhistoria" onclick ="window.location= 'carnet.php'">
	                        <i class="fa fa-search"></i></button>

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


    <div class="box-body">

    	<div class="box-body col-md-12">
      <div class="row" style="padding:10px;">
     <div class="nav-tabs-custom">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" >
          <li class="active"><a href="#mdmilitar" aria-controls="home" role="tab" data-toggle="tab">Datos Militares</a></li>
          <li role="presentation"><a href="#mfinanciero" aria-controls="home" role="tab" data-toggle="tab">Cta. Bancaria</a></li>
          <li role="presentation"><a href="#mdireccion" aria-controls="home" role="tab" data-toggle="tab">Dirección</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
           <div role="tabpanel" class="tab-pane active" id="mdmilitar" style="padding:15px">

               <div class="form-group">
               <div class="col-md-4 col-sm-12">
                   <label >Fecha Ingreso FANB:</label>
                   <div class="input-group date">
                     <div class="input-group-addon">
                       <i class="fa fa-calendar"></i>
                     </div>

                     <input type="text" class="form-control"  id="txtfechagraduacion" disabled="disabled" tabindex="4" required>

                   </div>




                </div>
                 <div class="col-md-4 col-sm-12">
                   <label>Componente:</label>
                   <select class="js-states form-control" style="width: 100%"  aria-hidden="true" id="cmbcomponente" required disabled="disabled" onChange="cambiarGrado()">
                     <option selected="selected" value="S"></option>
                     <option value="EJ">EJERCITO BOLIVARIANO</option>
                     <option value="AR">ARMADA BOLIVARIANA</option>
                     <option value="AV">AVIACION MILITAR BOLIVARIANA</option>
                     <option value="GN">GUARDIA NACIONAL BOLIVARIANA</option>
                     <option value="MI" disabled="disabled">MILICIA BOLIVARIANA</option>
                   </select>
                 </div>
                 <div class="col-md-4 col-sm-12">
                   <label>Categoria:</label>
                   <select class="js-states form-control" style="width: 100%"  aria-hidden="true" id="cmbcategoria" required disabled="disabled">
                     <option selected="selected" value="S"></option>
                     <option value="EFE">EFECTIVO</option>
                     <option value="ASI">ASIMILADO</option>
                     <option value="RES">RESERVA</option>
                     <option value="HNO" disabled="disabled">HONORARIOS</option>
                     <option value="MIL" disabled="disabled">MILICIA</option>

                   </select>
                 </div>

             </div><!-- Grupo Grado-->

               <div class="form-group">

                 <div class="col-md-4 col-sm-12">
                   <label>Clasificación:</label>
                   <select class="js-states form-control" style="width: 100%"  aria-hidden="true" required id="cmbclase" disabled="disabled">
                     <option selected="selected" value="S"></option>
                     <option value="OFI">OFICIAL DE COMANDO</option>
                     <option value="OFIT">OFICIAL TECNICO</option>
                     <option value="OFITR">OFICIAL DE TROPA</option>
                     <option value="TPROF">TROPA PROFESIONAL</option>
                     <option value="TPROA">TROPA ALISTADA</option>
                     <option value="ASI">ASIMILADO</option>
                     <option value="ASIT">ASIMILADO TECNICO</option>

                     <option value="HNO" disabled="disabled">HONORARIOS</option>
                     <option value="MIL" disabled="disabled">MILICIA</option>



                   </select>
                 </div>
                 <div class="col-md-4 col-sm-12">
                   <label >Grado:</label>
                   <select class="js-states form-control" style="width: 100%"  aria-hidden="true" id="cmbgrado" required disabled="disabled">
                     <option selected="selected" value="S"></option>
                    </select>
                </div>
                 <div class="col-md-4 col-sm-12">
                   <label>Situación:</label>
                   <select class="js-states form-control" style="width: 100%" onChange="ActivarPension()" aria-hidden="true" required id="cmbsituacion" disabled="disabled">
                     <option selected="selected" value="S"></option>
                     <option value="ACT">ACTIVO</option>
                     <option value="RCP" disabled="disabled">RESERVA ACTIVA CON GOCE PENSION</option> <!-- RETIRADO CON PENSION-->
                     <option value="RSP" disabled="disabled">RESERVA ACTIVA SIN GOCE PENSION</option>
                     <option value="FCP" disabled="disabled">FALLECIDO CON PENSION</option>
                     <option value="FSP" disabled="disabled">FALLECIDO SIN PENSION</option>
                     <option value="I" disabled="disabled">INVALIDEZ</option>
                     <option value="D" disabled="disabled">DISPONIBLE</option>
                   </select>
                 </div>


             </div> <!-- Grupo nombres-->

             <div class="form-group" id="_divpension">


               <div class="col-md-8 col-sm-12" >
                 <label >Tipo de Pensión:</label>
                 <select class="js-states form-control" style="width: 100%"  aria-hidden="true" id="cmbtipopension" disabled="disabled">
                   <option selected="selected" value="S"></option>
                   <option value="1">PENSION DE RESERVA ACTIVA</option>
                   <option value="2">PENSION DE SOBREVIVIENTE</option>
                   <option value="3">PENSION POR INVALIDEZ</option>
                   <option value="4">PENSION POR INVALIDEZ PARCIAL Y PERMANENTE</option>
                   <option value="5">PENSION POR INVALIDEZ TOTAL Y PERMANENTE</option>
                   <option value="99">OTRAS PENSIONES POR INVALIDEZ </option>
                  </select>
              </div>
               <div class="col-md-4 col-sm-12">
                 <label>Porcentaje de Pensión:</label>
                 <div class="input-group">
                   <input id="txtporcentaje" class="form-control" disabled="disabled"  type="text" maxlength="3" onblur="ValidarPorcentaje()">
                   <span class="input-group-addon"><label><b>%</b></label></span>
                 </div>
               </div>


           </div> <!-- DIV DE PESIONES -->

             <div class="form-group">
              <div class="col-md-3">
                <label >Número de Resolución:</label>
                <input id="txtnresuelto" class="form-control" disabled="disabled"  type="text" maxlength="8" required>
              </div>
              <div class="col-md-3">
                <label id="lblFechaResolucion">Fecha de Resolución:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input id="txtmfecharesuelto" class="form-control" disabled="disabled"  type="text" required>
                </div>

              </div>
              <div class="col-md-3">
                <label >Último Ascenso:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input id="txtmfechaultimoascenso" class="form-control" disabled="disabled"  type="text" required>
                </div>

              </div>
              <div class="col-md-3">
                <label>Orden de Merito:</label>
                <input id="txtposicion" class="form-control" disabled="disabled"  type="text" maxlength="6" required>
              </div>
            </div> <!-- Grupo nombres-->



           </div><!-- Tab panes Datos Militares-->

           <!-- Tab Datos Financieros-->

            <div role="tabpanel" class="tab-pane" id="mfinanciero"  style="padding:15px">

              <div class="form-group">
                <div class="col-md-12 col-sm-12" id="_cmbminstfinanciera">
                  <label>Institución Financiera</label>
                     <select class="js-states form-control" style="width: 100%" aria-hidden="true" disabled="disabled" required id="cmbminstfinanciera" onchange="SeleccionarCuenta()">
                       <option selected="selected" value="S"></option>
                       <option value="0156">100%BANCO</option>
                       <option value="0196">ABN AMRO BANK</option>
                       <option value="0172">BANCAMIGA BANCO MICROFINANCIERO, C.A.</option>
                       <option value="0171">BANCO ACTIVO BANCO COMERCIAL, C.A.</option>
                       <option value="0166">BANCO AGRICOLA</option>
                       <option value="0175">BANCO BICENTENARIO</option>
                       <option value="0128">BANCO CARONI, C.A. BANCO UNIVERSAL</option>
                       <option value="0164">BANCO DE DESARROLLO DEL MICROEMPRESARIO</option>
                       <option value="0102">BANCO DE VENEZUELA S.A.I.C.A.</option>
                       <option value="0114">BANCO DEL CARIBE C.A.</option>
                       <option value="0149">BANCO DEL PUEBLO SOBERANO C.A.</option>
                       <option value="0163">BANCO DEL TESORO</option>
                       <option value="0176">BANCO ESPIRITO SANTO, S.A.</option>
                       <option value="0115">BANCO EXTERIOR C.A.</option>
                       <option value="0003">BANCO INDUSTRIAL DE VENEZUELA.</option>
                       <option value="0173">BANCO INTERNACIONAL DE DESARROLLO, C.A.</option>
                       <option value="0105">BANCO MERCANTIL C.A.</option>
                       <option value="0191">BANCO NACIONAL DE CREDITO</option>
                       <option value="0116">BANCO OCCIDENTAL DE DESCUENTO.</option>
                       <option value="0138">BANCO PLAZA</option>
                       <option value="0108">BANCO PROVINCIAL BBVA</option>
                       <option value="0104">BANCO VENEZOLANO DE CREDITO S.A.</option>
                       <option value="0168">BANCRECER S.A. BANCO DE DESARROLLO</option>
                       <option value="0134">BANESCO BANCO UNIVERSAL</option>
                       <option value="0177">BANFANB</option>
                       <option value="0146">BANGENTE</option>
                       <option value="0174">BANPLUS BANCO COMERCIAL C.A</option>
                       <option value="0190">CITIBANK.</option>
                       <option value="0121">CORP BANCA.</option>
                       <option value="0157">DELSUR BANCO UNIVERSAL</option>
                       <option value="0151">FONDO COMUN</option>
                       <option value="0601">INSTITUTO MUNICIPAL DE CR&#201;DITO POPULAR</option>
                       <option value="0169">MIBANCO BANCO DE DESARROLLO, C.A.</option>
                       <option value="0137">SOFITASA</option>
                     </select>
                 </div>
               </div>
               <div class="form-group">
                 <div class="col-md-6 col-sm-12" id="_cmbmtipofinanciera">
                   <label >Tipo de Cuenta:</label>
                   <select class="js-states form-control" style="width: 100%" disabled="disabled" required aria-hidden="true" id="cmbmtipofinanciera" >
                     <option selected="selected" value="S"></option>
                    <option value="CA" selected="selected">AHORRO</option>
                    <option value="CC">CORRIENTE</option>
                   </select>
                 </div>
                 <div class="col-md-6 col-sm-12" id="_txtmnrocuenta">
                   <label>Nro. de Cuenta:</label>
                   <input  id="txtmnrocuenta" class="form-control" disabled="disabled"  type="text" maxlength="23" data-inputmask='"mask": "9999-9999-99-9999999999"' data-mask>
                 </div>
               </div><!-- .Form-Group -->

               <div class="form-group">
                 <div class="col-md-12 col-sd-12" id="_tblBancos">

                 </div>
               </div>



          </div><!-- Tab Datos Financieros-->
          <div role="tabpanel" class="tab-pane" id="mdireccion" style="padding:15px">
              <div class="form-group">
               <div class="col-md-4">
                 <label>Estado:</label>
                 <select class="js-states form-control" style="width: 100%" disabled="disabled"  id="cmbmestado" required onchange="CiudadMunicipio()">
                   <option value="S" selected="selected"></option>
                 </select>
               </div>
               <div class="col-md-4">
                 <label>Ciudad:</label>
                 <select class="js-states form-control" style="width: 100%" disabled="disabled"  id="cmbmciudad" required>
                   <option value="S" selected="selected"></option>
                 </select>
               </div>
               <div class="col-md-4">
                 <label>Municipio:</label>
                 <select class="js-states form-control" style="width: 100%" disabled="disabled" id="cmbmmunicipio" required onchange="SeleccionarParroquia()">
                   <option value="S" selected="selected"></option>
                 </select>
               </div>
             </div> <!-- Grupo nombres-->
              <div class="form-group">
               <div class="col-md-4">
                 <label >Parroquia:</label>
                  <select class="js-states form-control" style="width: 100%" disabled="disabled" id="cmbmparroquia" required>
                   <option value="S" selected="selected"></option>
                 </select>
               </div>
               <div class="col-md-4">
                 <label>Avenida / Edificio / Calle:</label>
                 <input id="txtmcalle" class="form-control" disabled="disabled"  type="text" required>
               </div>
               <div class="col-md-2">
                 <label># Casa:</label>
                 <input id="txtmcasa" class="form-control" disabled="disabled"  type="text">
               </div>
               <div class="col-md-2">
                 <label># Apto:</label>
                 <input id="txtmapto" class="form-control" disabled="disabled"  type="text">
               </div>
             </div> <!-- Grupo nombres-->
              <div class="form-group">
                <div class="col-md-4">
                  <label >Teléfono:</label>
                  <div class="input-group">
                   <div class="input-group-addon">
                     <i class="fa fa-phone"></i>
                   </div>
                  <input id="txtmtelefono" class="form-control" disabled="disabled" type="text" data-inputmask='"mask": "(9999) 999-99-99"' data-mask  required>
                </div>
               </div>
                <div class="col-md-4">
                  <label>Celular:</label>
                   <div class="input-group">
                   <div class="input-group-addon">
                     <i class="fa fa-phone"></i>
                   </div>
                  <input id="txtmcelular" class="form-control" disabled="disabled" type="text" data-inputmask='"mask": "(9999) 999-99-99"' data-mask  required>
                </div>
                </div>
               <div class="col-md-4 col-sm-12">
                   <label class="control-label">Correo Electronico:</label>
                   <div class="input-group date">
                     <div class="input-group-addon">
                       <i class="fa fa-envelope"></i>
                     </div>
                     <input type="email" class="form-control"  id="txtmcorreo" disabled="disabled" required onblur="ValidarCorreo()">
                   </div>
                </div>
              </div><!-- Grupo nombres-->

              <div class="form-group">
              <div class="col-md-4">
                   <label class="control-label">Twitter:</label>
                   <div class="input-group date">
                     <div class="input-group-addon">
                       <i class="fa fa-twitter"></i>
                     </div>
                     <input type="text" class="form-control"  id="txtmtwitter" disabled="disabled">
                   </div>
               </div>
              <div class="col-md-4">
                   <label class="control-label">FaceBook:</label>
                   <div class="input-group date">
                     <div class="input-group-addon">
                       <i class="fa fa-facebook"></i>
                     </div>
                     <input type="text" class="form-control"  id="txtmfacebook" disabled="disabled">
                   </div>
                </div>
              <div class="col-md-4">
                   <label class="control-label">Instagram:</label>
                   <div class="input-group date">
                     <div class="input-group-addon">
                       <i class="fa fa-instagram"></i>
                     </div>
                     <input type="text" class="form-control"  id="txtminstagran" disabled="disabled">
                   </div>
                </div>
             </div>
          </div><!-- Tab panes  Direccion-->

        </div>

     </div> <!-- Fila para el Tabs Militar -->

    	</div>
    	</div>

      	</div>

  	</div>

   <hr>
</form>


   <hr>
    <!--footer-->
   <div class="modal-footer ">
    <img src="imagen/arriba.png"/>
   </div>
     <!--fin footer-->
 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script-->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
