$(function () {

    $("#btnvolverlista").click(function(){
        $("#tblcarta").slideDown();
        $("#lstDetalle").slideUp();
    });

    $("#concepto").select2();

    $(".mdl-requisitos").on("change",function () {
        verificaCheckModal("requisitos","btnAgconcepto");
    });

    $(".mdl-requisitos").on("change",function () {
        verificaCheckModal("requisitosprotesis","btnAgconcepto");
    });

    $(".mdl-requisitos").on("change",function () {
        verificaCheckModal("requisitosmastologia","btnAgconcepto");
    });

    llenarCarta();
    $(".btnvolverentradac").click(function () {
        $("#mdldesea").modal("show");

        $("#btnsalir").click(function () {
            $("#opciones").hide();
            $("#panelentrada").show();
            $("#panellista").hide();
            $("#panelregistro").hide();
            $('#mdldesea').modal('hide');
            limpiarCarta();
        })
    });
});



/*function ocultarfamiliar(){
  var oculfami = document.getElementById("txtsituacion").value;

  switch (oculfami){
        case "FALLECIDO CON PENSIÓN":
          // document.getElementById("datosfamiliar").innerHTML;

        oculfami.style.display = (oculfami.style.display=='none') ? 'block' : 'none';
        break;


        
    }
}
*/

function mostrar(){
 
var situacion1 = document.getElementById("situacion").value;
alert (situacion1);
 
 if (situacion1 = "FALLECIDO CON PENSIÓN")
        {
     document.getElementById('datosfamiliar').style.display = 'none';
    }
    else {

      document.getElementById('datosfamiliar').style.display = 'block';
    }

  }