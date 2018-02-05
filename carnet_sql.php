<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
  <?php
  $conex = "host=192.168.12.188 port=5432 dbname=bs_saman user=postgres password='123456'";
  $cnx = pg_connect($conex) or die ("<h1>Error de conexion.</h1> ". pg_last_error());

  $sql121 = "SELECT personas.codnip, personas.nombrecompleto, pension.componentecod,
             (CASE
                 when gradocod='MTM'or gradocod='MM' OR gradocod='MTS' then 'CNEL'
                 when gradocod='MT1' then 'CNEL'
                 when gradocod='MT2' then 'TCNEL'
                 when gradocod='MT3' then 'MAY'
                 when gradocod='ST1' then 'CAP'
                 when gradocod='ST2' then '1TTE'
                 when gradocod='ST3' then 'TTE'
                 when gradocod='SAY' and componentecod = 'GN' then 'SS'
                 when gradocod='S1' and componentecod = 'GN' then 'SAY'
                 when gradocod='S2' and componentecod = 'GN' then 'SM1'
                 when gradocod='C1' and componentecod = 'GN' then 'SM2'
                 when gradocod='C2' and componentecod = 'GN' then 'SM3'
                 when gradocod='DTGDO' and componentecod = 'GN' then 'S1'
                 when gradocod='GN' and componentecod = 'GN' then 'S2'
                 when gradocod='MP' and componentecod = 'GN' then 'SS'
                 when gradocod='MA' and componentecod = 'GN' then 'SS'
                 when gradocod='MT' and componentecod = 'GN' then 'SS'
                 when gradocod='M1' and componentecod = 'GN' then 'SS'
                 when gradocod='M2' and componentecod = 'GN' then 'SS'
                 when gradocod='M3' and componentecod = 'GN' then 'SS'
                 ELSE gradocod
             END) AS gradocod
 FROM pension
 INNER JOIN  personas
 ON personas.ciaopr= pension.ciaopr
 AND personas.nropersona= pension.nropersona
 WHERE personas.codnip ILIKE '%$cedula%'
  AND pension.perssituaccod IN ('RCP','I')" ;

 $registros = pg_query($sql121);

  ?>

</body>
</html>
