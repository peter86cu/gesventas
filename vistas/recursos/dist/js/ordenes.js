function agregarOrdenInicial(event){

  var datos = new FormData();
  var accion = "inicial";

  datos.append("accion",accion);

  $.ajax({
    url: "ajax/ajaxOrdenesCompras.php",
    method : "POST",
    data: datos,
    chache: false,
    contentType: false,
    processData:false,
    dataType: "json",
    success: function(respuesta){

     if(respuesta){
      
      $("#idOrdenT").val(respuesta);
      document.querySelector('#idOrden').innerText = respuesta;
      $('#ModalADDOrdenes').modal('show');     
      mostrar_items(respuesta,"nada");
    }else{
      Swal.fire({
       icon: "error",
       title: "Oops...",
       text: "A ocurrido un error!",
       footer: "<a href>Ver que mensaje dar?</a>"
     })
    }
  }
});	


}




$('#myModal').on('hidden.bs.modal', function (e) {
  $(this)
    .find("input,textarea,select,span")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
})

$(".ModalEditarOrdenes").click(function(){

  var idOrden = $(this).attr("idOrden");  

  var datos = new FormData();
  
  var accion = "buscar";
  datos.append("accion",accion);
  datos.append("idOrden",idOrden); 
  

  $.ajax({
   url: "ajax/ajaxOrdenesCompras.php",
   method : "POST",
   data: datos,
   chache: false,
   contentType: false,
   processData:false,
   dataType: "json",
   success: function(respuesta){     
    

    document.querySelector('#idOrdenE').innerText = respuesta["id_orden_compra"];
    //document.querySelector('#datepicker').innerText = respuesta["fecha_hora"]; 
    $("#txtFormaPagoE > option[value="+respuesta["id_forma_pago"]+"]").attr("selected",true);                 
    $("#txtEnvioE > option[value="+respuesta["id_plazo"]+"]").attr("selected",true);
    buscar_proveedor_orden(respuesta["id_proveedor"],"1");
    mostrar_items(respuesta["id_orden_compra"],"editar");
    
    $("#idOrden1E").val(respuesta["id_orden_compra"]);
    $("#proveedorE1").val(respuesta["id_proveedor"]);
    $("#datepickerE").val(respuesta["fecha_hora"]);

  }
  

});

})


$(".ModalADDOrdenes").click(function(){

  var idOrden = $(this).attr("idOrden");  

  var datos = new FormData();
  
  var accion = "buscar";
  datos.append("accion",accion);
  datos.append("idOrden",idOrden); 
  

  $.ajax({
   url: "ajax/ajaxOrdenesCompras.php",
   method : "POST",
   data: datos,
   chache: false,
   contentType: false,
   processData:false,
   dataType: "json",
   success: function(respuesta){     
    
    document.querySelector('#idOrden').innerText = respuesta["id_orden_compra"];
    //document.querySelector('#datepicker').innerText = respuesta["fecha_hora"]; 
    $("#txtFormaPago > option[value="+respuesta["id_forma_pago"]+"]").attr("selected",true);                 
    $("#txtEnvio > option[value="+respuesta["id_plazo"]+"]").attr("selected",true);
    $("#idOrdenT").val(respuesta["id_orden_compra"]);
    $("#proveedor").val(respuesta["id_proveedor"]);
    $("#datepicker").val(respuesta["fecha_hora"]);
    buscar_proveedor_orden(respuesta["id_proveedor"],"2");
    mostrar_items(respuesta["id_orden_compra"],"nada");
    
    

  }
  

});

})


function guardarDetalleOrden(event){


  var idProducto = $('#producto').val();   
  var idOrden = $('#idOrdenT').val();
  var cantidad = $('#cantidad').val();
  var importe = $('#precio').val();
  var datos = new FormData();
  var accion = "insert";

  datos.append("accion",accion);
  datos.append("idProducto",idProducto);
  datos.append("idOrden",idOrden);
  datos.append("cantidad",cantidad);
  datos.append("importe",importe);

  $.ajax({
    url: "ajax/ajaxOrdenesCompras.php",
    method : "POST",
    data: datos,
    chache: false,
    contentType: false,
    processData:false,
    dataType: "json",
    success: function(respuesta){
      if(respuesta){
        $('#myModal').modal('hide');
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Item agregado",
         showConfirmButton: false,
         timer: 1100
       })
      // setTimeout(function() {location.reload();}, 1505)
/*jQuery(document).ready(function(){
 
  jQuery('#ModalADDOrdenes').on('hidden.bs.modal', function (e) {
      jQuery(this).removeData('bs.modal');
      jQuery(this).find('.modal-content').empty();
  })
 
})*/

mostrar_items(idOrden,"nada");

}else{
  Swal.fire({
   icon: "error",
   title: "Oops...",
   text: "A ocurrido un error!",
   footer: "<a href>Ver que mensaje dar?</a>"
 })
}
}
}); 
}

function mostrar_items(id,accion){

if(accion=="nada"){
  var parametros={"action":"ajax","idOrden":id,"action2":"nada"};
  }

  if(accion=="editar"){
    var parametros={"action":"ajax","idOrden":id,"action2":"editar"};
  }
  $.ajax({
    url:'ajax/items.php',
    data: parametros,
    beforeSend: function(objeto){
     $('.items').html('Cargando...');
   },
   success:function(data){
    $(".items").html(data).fadeIn('slow');
  }
})
}

function buscar_proveedor_orden(id,paso){
  
  var datos = new FormData();
  
  var accion = "buscarProveedor";
  datos.append("accion",accion);
  datos.append("idProveedor",id,);

  $.ajax({
   url: "ajax/ajaxOrdenesCompras.php",
   method : "POST",
   data: datos,
   chache: false,
   contentType: false,
   processData:false,
   dataType: "json",
   success: function(respuesta){
     
    
    if(paso=="1"){
    document.querySelector('#proveedorNE').innerText = respuesta["razon_social"];
    document.querySelector('#direccionE').innerText = respuesta["direccion"]; 
    document.querySelector('#emailE').innerText = respuesta["email"];
    document.querySelector('#telefonoE').innerText = respuesta["telefono"]; 
    document.querySelector('#autorizo').innerText = respuesta["razon_social"];
    document.querySelector('#cancelo').innerText = respuesta["razon_social"]; 
   }if(paso=="2"){
    document.querySelector('#proveedorN').innerText = respuesta["razon_social"];
    document.querySelector('#direccion').innerText = respuesta["direccion"]; 
    document.querySelector('#email').innerText = respuesta["email"];
    document.querySelector('#telefono').innerText = respuesta["telefono"]; 
  
   }

  }
  

})
}


$(document).ready(function() {
  $( ".proveedor" ).select2({        
    ajax: {
      url: "ajax/buscarProveedor.php",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
                q: params.term // search term
              };
            },
            processResults: function (data) {
              return {
                results: data
              };
            },
            cache: true
          },
          minimumInputLength: 2
        }).on('change', function (e){ 
          var idProveedor = $('.proveedor').select2('data')[0].id;        
          var nombre = $('.proveedor').select2('data')[0].text;
          var email = $('.proveedor').select2('data')[0].email;    
          var telefono = $('.proveedor').select2('data')[0].telefono;
          var direccion = $('.proveedor').select2('data')[0].direccion;
          $('#idProveedor').html(idProveedor);         
          $('#proveedorN').html(nombre);
          $('#email').html(email);
          $('#telefono').html(telefono);
          $('#direccion').html(direccion);
          guardar_proveedor(idProveedor);

        })
      });




$(document).ready(function() {
  $( ".producto" ).select2({        
    ajax: {
      url: "ajax/buscarProductos.php",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
                q: params.term // search term
              };
            },
            processResults: function (data) {
              return {
                results: data
              };
            },
            cache: true
          },
          minimumInputLength: 2
        }).on('change', function (e){

          $("#descripcion").val($('.producto').select2('data')[0].nombre);    
          $("#precio").val($('.producto').select2('data')[0].precio);


        })
      }); 


function eliminar_item(id){
  var idOrden = $('#idOrdenT1').val();
  $.ajax({
    type: "GET",
    url: "ajax/items.php",
    data: "action=ajax&id="+id,
    beforeSend: function(objeto){
     $('.items').html('Cargando...');
   },
   success: function(data){
        //$(".items").html(data).fadeIn('slow');
        mostrar_items(idOrden,"nada");
      }
    });
}



function guardar_orden(estado){  
  
  if(estado==1){
    var var_estado  =2;
  }
  if(estado==2){
    var var_estado  =3;
  }
  if(estado==3){
    var var_estado  =4;
  }
  if(estado==4){
    var var_estado  =5;
  }


if(estado==0){
    $('#ModalADDOrdenes').modal('hide');
      Swal.fire({
       position: "top-end",
       icon: "success",
       title: "Se guardo la orden como borrador.",
       showConfirmButton: false,
       timer: 1500
     })
      setTimeout(function() {location.reload();}, 1505)
  }else{


  var idProveedor = $('#proveedor').val();   
  var idOrden = $('#idOrdenT').val();
  var plazo = $('#txtEnvio').val();
  var forma_pago = $('#txtFormaPago').val();
  var fecha = $('#datepicker').val();
  var datos = new FormData();
  var accion = "update";

  datos.append("accion",accion);
  datos.append("idProveedor",idProveedor);
  datos.append("idOrden",idOrden);
  datos.append("plazo",plazo);
  datos.append("forma_pago",forma_pago);
  datos.append("fecha",fecha);
  datos.append("estado",var_estado);

  $.ajax({
    url: "ajax/ajaxOrdenesCompras.php",
    method : "POST",
    data: datos,
    chache: false,
    contentType: false,
    processData:false,
    dataType: "json",
    success: function(respuesta){

     if(respuesta){
      $('#ModalADDOrdenes').modal('hide');
      Swal.fire({
       position: "top-end",
       icon: "success",
       title: "Orden emitida con exito.",
       showConfirmButton: false,
       timer: 1500
     })
      setTimeout(function() {location.reload();}, 1505)
    }else{

      Swal.fire({
       icon: "error",
       title: "Oops...",
       text: "A ocurrido un error!",
       footer: "<a href>Ver que mensaje dar?</a>"
     })
    }
  }
}); 

  }



  
}

$(function(){
    $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd"
    });
});
     
$(function(){
    $("#datepickerE").datepicker({
        dateFormat: "yy-mm-dd"
    });
});
    


function guardar_ordenEditadas(estado){  
  if(estado==1){
    var var_estado  =2;
  }
  if(estado==2){
    var var_estado  =3;
  }
  if(estado==3){
    var var_estado =4;
  }
  if(estado==5){
    var var_estado  =5;
  }


  var idProveedor = $('#proveedorE1').val();   
  var idOrden = $('#idOrden1E').val();
  var plazo = $('#txtEnvioE').val();
  var forma_pago = $('#txtFormaPagoE').val();
  var fecha = $('#datepicker').val();
  var datos = new FormData();
  var accion = "update";

  datos.append("accion",accion);
  datos.append("idProveedor",idProveedor);
  datos.append("idOrden",idOrden);
  datos.append("plazo",plazo);
  datos.append("forma_pago",forma_pago);
  datos.append("fecha",fecha);
  datos.append("estado",var_estado);

  if(var_estado>1){
    $.ajax({
    url: "ajax/ajaxOrdenesCompras.php",
    method : "POST",
    data: datos,
    chache: false,
    contentType: false,
    processData:false,
    dataType: "json",
    success: function(respuesta){

     if(respuesta){
      $('#ModalEditarOrdenes').modal('hide');
      Swal.fire({
       position: "top-end",
       icon: "success",
       title: "Orden actualizada con exito.",
       showConfirmButton: false,
       timer: 1500
     })
      setTimeout(function() {location.reload();}, 1505)
    }else{

      Swal.fire({
       icon: "error",
       title: "Oops...",
       text: "A ocurrido un error!",
       footer: "<a href>Ver que mensaje dar?</a>"
     })
    }
  }
}); 
  }else if(var_estado==5){
 Swal.fire({
       icon: "error",
       title: "Oops...",
       text: "Esta orden ya esta cancelada",
       
     })

  }
  
  
}


function guardar_proveedor(idProveedor){ 
  var idOrden = $('#idOrdenT').val();
  var datos = new FormData();
  var accion = "uProveedor";  
  datos.append("accion",accion);
  datos.append("idProveedor",idProveedor); 
  datos.append("idOrden",idOrden); 
  
    $.ajax({
    url: "ajax/ajaxOrdenesCompras.php",
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


$(".btnEliminarOrden").click(function(){  

   var idOrden=  $(this).attr("idOrden");
   var datos = new FormData();
   var accion = "delete";

   datos.append("accion",accion);
   datos.append("idOrden",idOrden);

   const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false      
  })

   swalWithBootstrapButtons.fire({
    title: 'Estas seguro?',
    text: "De eliminar la oden!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si! ',
    cancelButtonText: 'No!',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {

     $.ajax({
      url: "ajax/ajaxOrdenesCompras.php",
      method : "POST",
      data: datos,
      chache: false,
      contentType: false,
      processData:false,
      dataType: "json",
      success: function(respuesta){
       if(respuesta){
        swalWithBootstrapButtons.fire(
         'Eliminado!',
         'La orden a sido eliminada.',
         'success'                   
         ).then((result)=> {
           if (result.isConfirmed)
             location.reload();
         });

       }else{
        Swal.fire({
         icon: 'error',
         title: 'Oops...',
         text: 'Ocurrio un error eliminando la orden!',
         footer: '<a href>Why do I have this issue?</a>'
       })
      }

    }
  });  

   } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
    ) {
    swalWithBootstrapButtons.fire(
      'Cancelado',
      'Has cambiado de idea. Bien :)',
      'error'
      )
  }
})

}) 


function datosImprimir(idOrden){

     
      VentanaCentrada('./pdf/documentos/orden.php?idOrden='+idOrden,'Orden','','1024','768','true');  
     
     
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