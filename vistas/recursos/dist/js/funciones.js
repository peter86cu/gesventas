$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

    });

});



function notificacion(tipo, descripcion){

console.log(descripcion);
var accion = "noti";
var datos = new FormData();
datos.append("tipoNotif",tipo);
datos.append("descripcion",descripcion);
datos.append("accion",accion);


$.ajax({
  url: "ajax/ajaxGeneral.php",
  method : "POST",
  data: datos,
  chache: false,
  contentType: false,
  processData:false,
  dataType: "json",
  success: function(respuesta){

   
    }
});

}


/*$(document).ready(function() {
  // intervalo
  setInterval(function() {
    // petición ajax
    $.ajax({
      url: 'claseYoQueSe.php',
      success: function(data) {
        // reemplazo el texto que va dentro de #Ejemplo
        $('#Ejemplo').text(data);
      }
    });
  }, 10000); // cada 10 segundos, el valor es en milisegundos
});*/


function notificacion_update(id){

var accion = "update";
var datos = new FormData();
datos.append("id",id);
datos.append("accion",accion);

 
$.ajax({
  url: "ajax/ajaxGeneral.php",
  method : "POST",
  data: datos,
  chache: false,
  contentType: false,
  processData:false,
  dataType: "json",
  success: function(respuesta){

   
    }
});

}


function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
}



