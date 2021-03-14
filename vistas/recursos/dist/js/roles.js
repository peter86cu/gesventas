function agregarRol(event){

   //Obtengo los valores
   
   var rol = $('#txt_Nombre').val();
   var descripcion = $("#txt_descripcion").val();
   var estado = $('#select_estado').val();
   
   var datos = new FormData();
   var accion = "insert";  

   datos.append("accion",accion);    
   datos.append("rol",rol); 
   datos.append("descripcion",descripcion);
   datos.append("estado",estado);

   $.ajax({
    url: "ajax/ajaxRoles.php",
    method : "POST",
    data: datos,
    chache: false,
    contentType: false,
    processData:false,
    dataType: "json",
    success: function(respuesta){

     if(respuesta){
      $('#ModalADDRoles').modal('hide');
      Swal.fire({
       position: "top-end",
       icon: "success",
       title: "Rol agregado",
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



 $(".btnEliminarRol").click(function(){  

   var idRol=  $(this).attr("idRol");

   var datos = new FormData();

   var accion = "delete";

   datos.append("accion",accion);
   datos.append("idRol",idRol);

   const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false      
  })

   swalWithBootstrapButtons.fire({
    title: 'Estas seguro?',
    text: "Dar de baja al rol !",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si! ',
    cancelButtonText: 'No!',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {

     $.ajax({
      url: "ajax/ajaxRoles.php",
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
         'El rol ha sido dado de baja.',
         'success'                   
         ).then((result)=> {
           if (result.isConfirmed)
             location.reload();
         });

       }else{
        Swal.fire({
         icon: 'error',
         title: 'Oops...',
         text: 'Ocurrio un error eliminando el rol!',
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


 $(".btnEditarRol").click(function(){

  var idRol = $(this).attr("idRol");
  var datos = new FormData();
  alert(idRol);
  var accion = "buscar";
  datos.append("accion",accion);
  datos.append("idRol",idRol,);

  $.ajax({
   url: "ajax/ajaxRoles.php",
   method : "POST",
   data: datos,
   chache: false,
   contentType: false,
   processData:false,
   dataType: "json",
   success: function(respuesta){     
    $("#idRol").val(respuesta["id_rol"]);
    $("#txt_NombreEdit").val(respuesta["rol"]);
    $("#txt_descripcionEdit").val(respuesta["descripcion"]);                     
    $("#select_estadoEdit > option[value="+respuesta["estado"]+"]").attr("selected",true);

  }
  

})

})

function updateRol(event){ 

   var idRol=  $('#idRol').val();
   var rol = $('#txt_NombreEdit').val();
   var descripcion = $("#txt_descripcionEdit").val();
   var estado = $('#select_estadoEdit').val();
   var datos = new FormData();
   var accion = "update";
   
   datos.append("accion",accion);    
   datos.append("rol",rol); 
   datos.append("descripcion",descripcion);
   datos.append("estado",estado);
   datos.append("idRol",idRol);
   

   $.ajax({
     url: "ajax/ajaxRoles.php",
     method : "POST",
     data: datos,
     chache: false,
     contentType: false,
     processData:false,
     dataType: "json",
     success: function(respuesta){

      if(respuesta){
        $('#ModalEditarRoles').modal('hide');
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Rol modificado",
         showConfirmButton: false,
         timer: 1500
       })
        setTimeout(function() {location.reload();}, 1505)   

      }else{

        Swal.fire({
         icon: "error",
         title: "Oops...",
         text: "A ocurrido un error!",
        // footer: "<a href>Ver que mensaje dar?</a>"
      })
      }

    }
  }); 

 }