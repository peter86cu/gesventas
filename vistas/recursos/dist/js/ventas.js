


$(document).keydown(function (tecla) {
  if (tecla.keyCode == 112) {   


    var datos = new FormData(); 
    var accion = "buscarArqueo";
    datos.append("accion",accion);

    $.ajax({
     url: "ajax/ajaxVentas.php",
     method : "POST",
     data: datos,
     chache: false,
     contentType: false,
     processData:false,
     dataType: "json",
     success: function(respuesta){

      if(respuesta['id_apertura_cajero']!=null)  {
                  
       var datos = new FormData(); 
       var accion = "insert";
       datos.append("accion",accion);
       datos.append("idApertura",respuesta['id_apertura_cajero']);

       $.ajax({
         url: "ajax/ajaxVentas.php",
         method : "POST",
         data: datos,
         chache: false,
         contentType: false,
         processData:false,
         dataType: "json",
         success: function(datos){
         
          if(datos){            
            window.open("ventas", 'Nombre de la ventana', "fullscreen,location=no,menubar=no,status=no,toolbar=no,RESIZABLE=0");
          }

        }

      });


     }else{

      Swal.fire({
       icon: "error",
       title: "Oops...",
       text: "No existe una apertura de caja!"               
     })

    }  
  }
});



  }
});


//ponleFocus();

/*$(document).ready(function()
  {
  $("#txtProductoV").focus(function(){
        $(this).css("background-color", "#FFFFCC");
  });
 
  $("#texto2").focus(function(){
    $(this).hide("slow");
  });
});*/

//para el key
function setQuantity(key){
  $("#txtProductoV").val($("#txtProductoV").val()+key);
}
function keyboardDEL(){
  if($("#items .seleccionado").length>0){
    var selector = $("#items .seleccionado").children("td");
    $.ajax({
      url: "ajax_item",
      data: "producto_cod="+selector.eq(1).html()+'&id_venta='+$("#id_venta").val()+'&cantidad=-'+selector.eq(0).html()+"&del=true",
      type: "POST",
      dataType: "json",
      success: function(data){
        if(data.producto_no_existe=='1'){
          alert('El producto no existe'); 
        }else{
          if(data.no_hay_stock=='1'){
            alert('Ya no hay en Stock');
          }else if(data.producto_no_vendible=='1'){
            alert('El producto no se puede vender!');
          }else{
            if(data.supera_cantidad=='1'){
              alert('Supera el limite del la cantidad en Stock'); 
            }else{
              $('#items tbody').html(data.html);
              $('#total').html('Gs. '+number_format(data.total,0,',','.'));
              $('#total_venta').attr('value',data.total);
              $('#total_en_letras').html(data.total_en_letras);
              $('#iva5').html(data.iva5);
              $('#iva10').html(data.iva10);
              $('#ivainput5').val(data.ivainput5)
              $('#ivainput10').val(data.ivainput10)
              $('#sumaexcento').html(data.sumaexcento);
              $('#sumaiva5').html(data.sumaiva5);
              $('#sumaiva10').html(data.sumaiva10);
              if($('#total_venta').val()>0){
                $('#cancelar_venta').hide();
              }else{
                $('#cancelar_venta').show();
              }
            }
          }
        }
        document.getElementById('producto_cod').focus();
      }
    });
    
  }
  
  
  
}



function buscarSimboloMonedaJS(idMoneda){



  var datos = new FormData(); 
  var accion = "buscarMoneda";
  datos.append("accion",accion);
  datos.append("idMoneda",idMoneda); 


  $.ajax({
   url: "ajax/ajaxProductos.php",
   method : "POST",
   data: datos,
   chache: false,
   contentType: false,
   processData:false,
   dataType: "json",
   success: function(respuesta){  

     document.querySelector('#monedaV').innerText = respuesta;
   }  
 });

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






