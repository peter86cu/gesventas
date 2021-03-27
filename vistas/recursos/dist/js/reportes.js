
function generarReporte(idReporte){

alert(idReporte)
var datos = new FormData(); 
    
    datos.append("idReporte",idReporte);
    

    $.ajax({
     url: "ajax/reportes.php",
     method : "POST",
     data: datos,
     chache: false,
     contentType: false,
     processData:false,
     dataType: "json",
     success: function(respuesta){
        if(respuesta){
  


    }  
  }
});

}


function reporte(idReporte){

alert(idReporte)
var datos = new FormData(); 
var accion="parametro_reporte";
    
    datos.append("idReporte",idReporte);
    datos.append("accion",accion);
    
      $('#ModalReporteStock').modal('hide');

    $.ajax({
     url: "ajax/procesoReporte.php",
     method : "POST",
     data: datos,
     chache: false,
     contentType: false,
     processData:false,
     dataType: "json",
     success: function(respuesta){

        if(respuesta){
          //document.querySelector('#nombreReporte').innerText = respuesta;
            window.location.href = 'reporte-stock'; 
        }

      
  }
});
  


}


function abirirReporte(){
var id= $("#idReporte").val() 
if (id==1) {
reporte(id);
  //window.location.href = 'reporte-stock';
}

}

$(function(){
  $("#datepickerI1").datepicker({
    dateFormat: "yy-mm-dd"
  });
});

$(function(){
  $("#datepickerF1").datepicker({
    dateFormat: "yy-mm-dd"
  });
});


function filtro_reporte(){

  $('#ModalReporteStock').modal('show');
}
/*
 <tr>
                      <td>1.</td>
                      <td>Update software</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-danger">55%</span></td>
                    </tr>


                    */



/*$("#txtProductoV").keypress(function() {
    if($(this).val().length > 1) {
         alert($("#txtProductoV").val());

    } else {
         // Disable submit button
    }
  });*/






