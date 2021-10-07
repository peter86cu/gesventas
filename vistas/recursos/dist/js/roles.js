


function AccesoModulosNiveles(modulo, nivel) {

  this.modulo = modulo;
  this.nivel = nivel;
}

var modulo = [];


function agregarRol(event){

   //Obtengo los valores



   var selectedAcceso = new Array();

   var cantidadrol = $('#rolSize').val();

   var modulos='';
   var niveles='';
   var posModulos=0;

   while(cantidadrol>0){
       posModulos++;        
       if ($('#modulo_'+posModulos).is(':checked') ) {
          modulo.push($("#idModulo_"+posModulos).val());
          var nivel = new Array();
          var cantidadnivel = $('#nivelesSize').val(); 
          var posNiveles=0;
          while(cantidadnivel>0){            
            posNiveles++;                    
            if ($("#niveles_"+posNiveles+"_"+posModulos).is(':checked') ) {             
              nivel.push($("#idNivel_"+posNiveles).val());

          }
          cantidadnivel--;
      }

      var acc = new AccesoModulosNiveles($("#idModulo_"+posModulos).val(),nivel);
      selectedAcceso.push(acc);         
      nivel = [];   

  } 

  cantidadrol--;


} 



var rol = $('#txt_Nombre').val();
var descripcion = $("#txt_descripcion").val();
var estado = $('#select_estado').val();

var datos = new FormData();
var accion = "insert";  

datos.append("accion",accion);    
datos.append("rol",rol); 
datos.append("descripcion",descripcion);
datos.append("estado",estado);
datos.append("array",JSON.stringify(selectedAcceso));

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



function updateRol(event){

   //Obtengo los valores



   var selectedAcceso = new Array();

   var cantidadrol = $('#rolSizeE').val();

   

   var modulos='';
   var niveles='';
   var posModulos=0;

   while(cantidadrol>0){
       posModulos++;   
      if ($('#moduloE_'+posModulos).is(':checked') ) {
        
          modulo.push($("#idModuloE_"+posModulos).val());
          var nivel = new Array();
          var cantidadnivel = $('#nivelesSizeE').val(); 
         
          var posNiveles=0;
          while(cantidadnivel>0){            
            posNiveles++;                    
            if ($("#nivelesE_"+posNiveles+"_"+posModulos).is(':checked') ) {             
              nivel.push($("#idNivelE_"+posNiveles).val());

          }
          cantidadnivel--;
      }

      var acc = new AccesoModulosNiveles($("#idModuloE_"+posModulos).val(),nivel);
      selectedAcceso.push(acc);         
      nivel = [];   

  } 

  cantidadrol--;


} 



   var idRol=  $('#idRolE').val();
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
   datos.append("array",JSON.stringify(selectedAcceso));

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
         title: "No se pudo actualizar el rol"
         //text: "A ocurrido un error!",
        // footer: "<a href>Ver que mensaje dar?</a>"
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
    title: 'Confirma desahabilitar el rol?',    
    showCancelButton: true,
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
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
         'El rol ha sido desahabilitado'                        
         ).then((result)=> {
           if (result.isConfirmed)
             location.reload();
     });

     }else{
        Swal.fire({
         icon: 'error',
         title: 'No se pudo desahabilitar el rol' 

     })
    }

}
});  
 } 
})

})

function moduloNivel(id_nivel,descripcion){

    this.id_nivel=id_nivel;
    this.descripcion=descripcion;
    
}

$(".btnEditarRol").click(function(){

  var idRol = $(this).attr("idRol");
  var datos = new FormData();  
  var accion = "buscar";
  datos.append("accion",accion);
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
    $("#idRolE").val(idRol);
    $("#txt_NombreEdit").val(respuesta["rol"]);
    $("#txt_descripcionEdit").val(respuesta["descripcion"]);                     
    $("#select_estadoEdit > option[value="+respuesta["estado"]+"]").attr("selected",true);

    if(respuesta["id_rol"]){
      var datos = new FormData();  
      var accion = "lista_modulos";
      datos.append("accion",accion);

      $.ajax({
       url: "ajax/ajaxRoles.php",
       method : "POST",
       data: datos,
       chache: false,
       contentType: false,
       processData:false,
       dataType: "json",
       success: function(modulos){


        if(modulos){

          var datos = new FormData();  
          var accion = "modulos_niveles";
          datos.append("accion",accion);
          datos.append("idRol",respuesta["id_rol"]);
          $.ajax({
           url: "ajax/ajaxRoles.php",
           method : "POST",
           data: datos,
           chache: false,
           contentType: false,
           processData:false,
           dataType: "json",
           success: function(valor){    


            $('#k-table > tfoot').empty();

            var cantidadModulos=0;
            var cantidadNiveles=1;

            var niveles = ["Vista", "Add","Editar","Eliminar", "Imprimir", "Notificar", "Abir y cerrar caja"];

            var objetoModulo=null;
                $("#rolSizeE").val(modulos.length);   
               

            for(var j=0; j<modulos.length; j++){
               var esta=false;
               cantidadModulos++;
               var listadoniveles=[];
               var objetoModulo = new Object();
               for(var i=0; i<valor.length; i++){ 



                if(modulos[j].id_modulo==valor[i].id_modulo){

                    esta=true;
                    var data = new moduloNivel(valor[i].id_nivel,valor[i].descripcion);
                    listadoniveles.push(data);
                    objetoModulo= modulos[j];
                                    //valor.splice(i, 1);

                                }

                            }

                            var tr1 =``;
                            var tr2 =``;
                            var tr3 =``;
                            var tr4 =``;
                            var tr5 =``;  


                            if(esta==true){

                                tr1 = `<tr > `;

                                tr2= ` <td align="float-right"  >
                                <input align="left" type="hidden" id="idModuloE_`+objetoModulo.id_modulo+`" name="idModuloE" value="`+objetoModulo.id_modulo+`">
                                <input align="left" id="moduloE_`+objetoModulo.id_modulo+`" class="form-check-input" type="checkbox" checked onclick="checkEdit(`+objetoModulo.id_modulo+`)">
                                <label align="left"  class="form-check-label">`+objetoModulo.nombre+`</label></td>`;       

                                var temp=0;  
                                var cont=1;                           


                                var val=0;                     

                                var encontre=false;
                                for(var h=0; h<niveles.length; h++){                                   
                                    if(objetoModulo.id_modulo==modulos[j].id_modulo && validarExiste(listadoniveles,niveles[h],temp)){
                                       tr3+=    `<td ><input type="hidden" id="idNivelE_`+cantidadNiveles+`" name="idNivelE" value="`+cont+`">
                                       <input  class="nivelE_`+objetoModulo.id_modulo+`" id="nivelesE_`+cantidadNiveles+`_`+modulos[j].id_modulo+`"  class="form-check-input" checked type="checkbox" >
                                       <label  class="form-check-label">`+niveles[h]+`</label></td>`; 
                                   }else {                                     

                                    tr3+=    `<td ><input type="hidden" id="idNivelE_`+cantidadNiveles+`" name="idNivelE" value="`+cont+`">
                                    <input  class="nivelE_`+modulos[j].id_modulo+`" id="nivelesE_`+cantidadNiveles+`_`+modulos[j].id_modulo+`"  class="form-check-input"  type="checkbox" >
                                    <label  class="form-check-label">`+niveles[h]+`</label></td>`;  
                                } 
                                                   
                                cantidadNiveles++;
                                cont++;
                            }
                             val++; 
                            listadoniveles=[];



                            t4 =` </tr> `;
                        }else{
                          tr1 = `<tr >`;  

                          tr2=  `  <td align="float-right"  >
                          <input align="left" type="hidden" id="idModuloE_`+modulos[j].id_modulo+`" name="idModuloE" value="`+modulos[j].id_modulo+`">
                          <input align="left" id="moduloE_`+modulos[j].id_modulo+`" class="form-check-input" type="checkbox" onclick="checkEdit(`+modulos[j].id_modulo+`)">
                          <label align="left"  class="form-check-label">`+modulos[j].nombre+`</label></td>`; 

                          var temp=0;  
                          var cont=1;                           
                          var val=0;    

                          for(var h=0; h<niveles.length; h++){                            
                            var pos2=1; 
                            tr3+=    `<td ><input type="hidden" id="idNivelE_`+cantidadNiveles+`" name="idNivelE" value="`+cont+`">
                            <input  class="nivelE_`+modulos[j].id_modulo+`" id="nivelesE_`+cantidadNiveles+`_`+modulos[j].id_modulo+`"  class="form-check-input"  type="checkbox" disabled >
                            <label  class="form-check-label">`+niveles[h]+`</label></td>`;  



                            cont++;
                            pos2++;
                            temp++;
                            val++;
                            cantidadNiveles++;
                        }                   


                        tr4=  `</tr> `; 
                    }




                    $("#result").append(tr1+tr2+tr3+tr4);      


                }

                 $("#nivelesSizeE").val(cantidadNiveles);
            }


        })


}
}
})

}
}
})
})


function validarExiste(lista,valor, intera){

    var esta=false;

    for (var i = 0; i < lista.length; i++) {        
        if(lista[i].descripcion==valor){
            esta= true;
            break;
        }
    }
   
    return esta;

}






function check(id){

 $("#modulo_"+id).on( 'change', function() {
    if( $(this).is(':checked') ) {
        // Hacer algo si el checkbox ha sido seleccionado
        $("input.nivel_"+id).removeAttr("disabled");

    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        $("input.nivel_"+id).attr("disabled", true);
    }
});

} 



function checkEdit(id){

 $("#moduloE_"+id).on( 'change', function() {
    if( $(this).is(':checked') ) {
        // Hacer algo si el checkbox ha sido seleccionado
        $("input.nivelE_"+id).removeAttr("disabled");

    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        $("input.nivelE_"+id).attr("disabled", true);
    }
});

}

