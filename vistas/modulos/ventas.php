 <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-dark-indigo">
    <!-- Brand Logo -->
    <span  class="brand-link navbar-info">   <h1 id="HoraActual"> </h1></span>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-4 pb-6 mb-3 d-flex">
        <div class="image">
          <img src="vistas/recursos/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <?php
          $db = new BaseDatos();
          $rol="";
          if($resultado=$db->buscar("rol","id_rol=".$_SESSION['rol']."")){
            foreach($resultado as $row) {
              $rol=$row['rol'];
            }
          }
          $caja="";
          if($resultado2=$db->buscar("caja","ip='".$_SESSION['ip']."'")){
            foreach($resultado2 as $row2) {
              $caja=$row2['nombre'];
            }
          }
         ?>
        <div class="info">
          <h4 class="color"><strong>Bienvenido</strong></h4>
          <span class="color"><?php echo $_SESSION['user'] ?></span >
          <p><span class="color"><?php echo  $rol ?></span ></p>
          <p><span class="color"><?php echo  $caja ?></span ></p>

           <div> <a href="logout" class="d-block"> <strong>Cerrar Sessión</strong>  </a></div>
      </div>
      </div>

       <!-- SidebarSearch Form -->
      <div class="form-inline">

             <p style ="float: right;"> <p class="color"><strong>Código Venta:</strong>
              <input type="text" name="txt" id="txtVenta" style=" border: 0; color: #000000;" disabled="true"></p>
              <p class="color"><strong> Código Apertura Caja:</strong>
              <input type="text" name="txt" id="txtApertura" style=" border: 0;color: #000000;" disabled="true"></p>
              <p class="color"><strong> # Ticket:</strong>
              <input type="text" name="txt" id="txtOrden" style=" border: 0;color: #000000;" disabled="true"></p>

      </div>
     </aside>



<body class="hold-transition sidebar-mini" >


  <div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">


            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Producto</h5>

                <p class="card-text">
                  <input type="text" name="txtProductoV" id="txtProductoV" style=" border: 0;">

                  <input type="text" name="txtCantP" id="txtCantP" style=" border: 0; float: right;" size=10 value="1" >
                </p>
                <script type="text/javascript">

                  function ponleFocusCantidadProductos(){
                    document.getElementById("txtCantP").focus();
                    $('#txtCantP').val(1);
                  }
                    showTime();
                  function showTime(){
                  myDate = new Date();
                  hours = myDate.getHours();
                  minutes = myDate.getMinutes();
                  seconds = myDate.getSeconds();
                  if (hours < 10) hours = 0 + hours;
                  if (minutes < 10) minutes = "0" + minutes;
                  if (seconds < 10) seconds = "0" + seconds;
                  $("#HoraActual").text(hours+ ":" +minutes+ ":" +seconds);
                  setTimeout("showTime()", 1000);

                  }

                  ponleFocusylimpiarProductos();
                  function ponleFocusylimpiarProductos(){
                    document.getElementById("txtProductoV").focus();
                    $('#txtProductoV').val("");
                  }

                  inicio();

                  function inicio(){
                  document.title = "POS | Caja ";

                    var datos = new FormData();
                    var accion = "buscarArqueoCaja";
                    datos.append("accion",accion);

                    $.ajax({
                     url: "ajax/ajaxVentas.php",
                     method : "POST",
                     data: datos,
                     chache: false,
                     contentType: false,
                     processData:false,
                     dataType: "json",
                     success: function(resp){

                       if(resp!=null && resp['id_apertura_cajero']!=null)  {
                         $('#txtApertura').val(resp['id_apertura_cajero']) ;
                         $('#txtVenta').val(resp['id_venta']) ;
                         $('#txtOrden').val(resp['consecutivo']) ;
                         genera_tabla();

                       }else{
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
                            console.log(respuesta)
                            if(respuesta){

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

                                  var datos = new FormData();
                                  var accion = "buscarArqueoCaja";
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

                                     genera_tabla();
                                     enviarVentaId(respuesta['id_venta'],respuesta['id_apertura_cajero']);
                                     $('#txtApertura').val(respuesta['id_apertura_cajero']) ;
                                     $('#txtVenta').val(respuesta['id_venta']) ;
                                     $('#txtOrden').val(respuesta['consecutivo']) ;
                                   }

                                 });

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
                     }
                     });
                  }

                    function enviarVentaId(idVenta){
                      var datos = new FormData();
                      var accion = "enviarDatos";
                      datos.append("accion",accion);
                      datos.append("idVenta",idVenta);


                      $.ajax({
                       url: "vistas/modulos/ventas.php",
                       method : "POST",
                       data: datos,
                       chache: false,
                       contentType: false,
                       processData:false,
                       dataType: "json",
                       success: function(respuesta){
                       }
                     });}


                      $(document).ready(function(){
                       $("#txtProductoV").keypress(function(e) {
        //no recuerdo la fuente pero lo recomiendan para
        //mayor compatibilidad entre navegadores.
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13 || $(this).val().length >= 7){

         var codigo= $("#txtProductoV").val();
         var datos = new FormData();
         var accion = "buscarP";
         datos.append("accion",accion);
         datos.append("codigo",codigo);

         $.ajax({
           url: "ajax/ajaxProductos.php",
           method : "POST",
           data: datos,
           chache: false,
           contentType: false,
           processData:false,
           dataType: "json",
           success: function(respuesta){

            console.log(respuesta)
            if (respuesta) {

              var datos = new FormData();
              var accion = "buscarStock";
              var cant = $("#txtCantP").val();
              datos.append("accion",accion);
              datos.append("codigo",respuesta["id_producto"]);
              $.ajax({
               url: "ajax/ajaxVentas.php",
               method : "POST",
               data: datos,
               chache: false,
               contentType: false,
               processData:false,
               dataType: "json",
               success: function(cantidad){
                console.log(cantidad)
                if(cantidad>0 && cantidad > cant){
                 document.querySelector('#nombreProductoV').innerText = respuesta["nombre"];
                 document.querySelector('#codigoProdV').innerText = respuesta["codigo"];
                 document.querySelector('#precioP').innerText = respuesta["precio_venta"];
                 document.querySelector('#paraCodigo').innerText = "Código:";
                 buscarSimboloMonedaJS(respuesta["id_moneda"]);
                 $("#idImagenP").attr("src","vistas/recursos/dist/img/productos/"+respuesta["foto"]);
                 ponleFocusylimpiarProductos();
                 insertDetalleVenta(respuesta["id_producto"]);
               }else{
                alert("No hay stock disponible")
                                  //error de que no hay suficiente es stock
                                  ponleFocusylimpiarProductos();
                                }
                              }
                            });
            }else{
             alert("El producto no se encuentra")
                  //aqui es error de que no existe el producto
                  ponleFocusylimpiarProductos();
                }
              }

            })

       }
     });
                     });

                      function genera_tabla() {

                        var datos = new FormData();
                        var accion = "buscarVentas";
                        var idVenta = $("#txtVenta").val();
                        datos.append("accion",accion);
                        datos.append("idVenta",idVenta);

                        $.ajax({
                         url: "ajax/ajaxVentas.php",
                         method : "POST",
                         data: datos,
                         chache: false,
                         contentType: false,
                         processData:false,
                         dataType: "json",
                         success: function(resul){
                          $('#g-table > tbody').empty();
                          $('#h-table > tfoot').empty();
                          var cantotal1=0;
                          var cantotal2=0;
                          var cantotal3=0;
                          var suma_total=0;
                          var sumaexcento=0;
                          var sumaiva5=0;
                          var sumaiva10=0;
                          var iva5=0;
                          var iva10=0;
                          var ivainput5=0;
                          var ivainput10=10;
                          var id_moneda=0;
                          var sumaexcento =0;
                          var simbolo_moneda =0;
                          var classs='';
                          for(var i=0; i<resul.length; i++){
                            console.log(resul)


                            id_moneda=resul[i].id_moneda;
                            if(resul[i].cantidad!=0){
                              if ( i % 2 == 0 ) {
                               classs = 'gradeA odd';
                             }else{
                               classs = 'gradeA even';
                             }
                             cantotal=resul[i].precio*resul[i].cantidad;


                             if(resul[i].id_impuesto==1){
                              sumaexcento +=cantotal;
                            }else if(resul[i].id_impuesto==2){
                              sumaiva5 +=cantotal;
                            }else if(resul[i].id_impuesto==3){
                              sumaiva10 +=cantotal;
                            }

                            suma_total = resul[i].precio*resul[i].cantidad+suma_total;

                          }

                          simbolo_moneda=resul[i].moneda;

                          if(resul[i].id_impuesto==1)
                           cantotal1=resul[i].precio*resul[i].cantidad;
                         if(resul[i].id_impuesto==2)
                          cantotal2=resul[i].precio*resul[i].cantidad;
                        if(resul[i].id_impuesto==3)
                          cantotal3=resul[i].precio*resul[i].cantidad;

                        var tr2 = `<tr style="background: #ccffcc">
                        <td style="width: 5%"><h5><strong>`+resul[i].cantidad+ `</strong></h5></td><td style="width: 12%"><h5><strong>`+resul[i].codigo+`</strong></td><td style="width: 34%"><h5><strong>`+resul[i].nombre+`</strong></td><td style="width: 12%" align="center"><h5><strong>`+resul[i].precio+ ' ' +resul[i].moneda+ `</strong></td><td style="width: 12%" align="center"><h5><strong>` +cantotal1+  `</strong></td><td style="width: 12%" align="center"><h5><strong>` +cantotal2+  `</strong></td><td style="width: 12%" align="center"><h5><strong>` +cantotal3+  `</strong></td><td class='text-right'><a href="#" onclick="eliminar_producto(`+idVenta+','+resul[i].id_venta_detalle +','+resul[i].id_producto +`)" ><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAeFBMVEUAAADnTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDx+VWpeAAAAJ3RSTlMAAQIFCAkPERQYGi40TVRVVlhZaHR8g4WPl5qdtb7Hys7R19rr7e97kMnEAAAAaklEQVQYV7XOSQKCMBQE0UpQwfkrSJwCKmDf/4YuVOIF7F29VQOA897xs50k1aknmnmfPRfvWptdBjOz29Vs46B6aFx/cEBIEAEIamhWc3EcIRKXhQj/hX47nGvt7x8o07ETANP2210OvABwcxH233o1TgAAAABJRU5ErkJggg=="></a></td></tr>`;

                        $("#cuerpo").append(tr2);


                      }

                      iva5=sumaiva5/21;
                      iva10=sumaiva10/11;
                      ivainput5=sumaiva5/21;
                      ivainput10=sumaiva10/11;

                      var datos= `<tr><th width="5%" ></th><th  ></th></tr><th width="34%"></th>
                      <th width="12%" id="sumaexcento">`+simbolo_moneda+ ' '+sumaexcento+ `</th>
                      <th width="12%" id="sumaiva5">`+simbolo_moneda+ ' '+sumaiva5+ `</th>
                      <th width="12%" id="sumaiva10">`+simbolo_moneda+ ' '+sumaiva10+ `</th></tr>`;

                      var datos2= `<tr>
                      <th align="right"><label  id="total" style="font-size:240%; width:100%; margin-bottom:0;">
                      `+simbolo_moneda+suma_total+ `
                      </label></th>
                      </tr>`;



                      var datos3= `<tr>
                      <th width="5%"></th>
                      <th align="right"  style="background:#7F8793;color:#fff">IVA 5%<input type="hidden" id="ivainput5" value="`+iva5+ `"></th>
                      <th align="left" id="iva5">`+number_format(iva5,2,',','.')+ `</th>
                      <th align="right"  style="background:#7F8793;color:#fff">IVA 10%<input type="hidden" id="ivainput10" value="<`+iva10+ `"></th>
                      <th align="left" id="iva10">` +simbolo_moneda+ ' ' +number_format(iva10,2,',','.')+ `</th>
                      </tr>`;
                     // $("#result").append(datos);

                     $("#result").append(datos3);
                     $("#result").append(datos2);
                     $("#total_venta").val(suma_total);
                     $('#total').html(simbolo_moneda+number_format(suma_total,2,',','.'));
                     document.querySelector('#total_venta_confirmar').innerText = simbolo_moneda+number_format(suma_total,2,',','.');
                   }

                 });



}



function insertDetalleVenta(idProducto) {
  var datos = new FormData();
  var accion = "insertVentaDetalle";
  var idVenta = $('#txtVenta').val();
  var cantidad = $('#txtCantP').val();

  datos.append("accion",accion);
  datos.append("idVenta",idVenta);
  datos.append("cantidad",cantidad);
  datos.append("idProducto",idProducto);
  $.ajax({
   url: "ajax/ajaxVentas.php",
   method : "POST",
   data: datos,
   chache: false,
   contentType: false,
   processData:false,
   dataType: "json",
   success: function(resul){

     if(resul){
      enviarVentaId(idVenta);
      genera_tabla();

    }

  }
});



}


function eliminar_producto(idVenta, idVentaDetalle, idProducto){

  var accion ="eliminar";
  var datos = new FormData();
  datos.append("accion",accion);
  datos.append("idVenta",idVenta);
  datos.append("idVentaDetalle",idVentaDetalle);
  datos.append("idProducto",idProducto);

  $.ajax({
   url: "ajax/ajaxVentas.php",
   method : "POST",
   data: datos,
   chache: false,
   contentType: false,
   processData:false,
   dataType: "json",
   success: function(data){
    if(data){
      $('#g-table > tbody').empty();
      $('#h-table > tfoot').empty();
      genera_tabla();
    }
  }
});
}

function abrir(){

  if($('#total_venta').val()>0){
   var opt = {
    autoOpen: false,
    modal: true,
    width: 550,
    height:650

  };

  var theDialog = $("#confirm-form").dialog(opt);
  theDialog.dialog("open");


  //  $('#confirm-form').dialog('open').html("<div align='center'><img src='cargando.gif' /></div>").load("ajax_formas_cobros");
}else{
  alert('No existe ningun items');
  document.getElementById('producto_cod').focus();
}
}

function cargar(evt,t){
 var charCode = (evt.which) ? evt.which : evt

 if(charCode=='13'){
   if($(t).hasClass("cantidad")){

    agregar_forma_cobro(t);
  }else{
    agregar_forma_cobro(t);
  }
}

}

</script>

</div>
</div>

<div class="card card-primary card-outline">
  <div class="card-body">
    <div class="prevPhoto ">


      <img id="idImagenP" src="vistas/recursos/dist/img/productos/img_producto.png" style="border: silver 1px solid background: #218838;"  width="400" height="300">
    </div>

    <div>
     <p ><h2 style="color:#218838";><label id="nombreProductoV"></label> </h2></p>
     <p ><h6><label id="paraCodigo"></label><label id= "codigoProdV"></label> </h6></p>
     <p ><h1><strong><label id="precioP"> </label> <label id="monedaV"> </label></strong> </h2></p>

     </div>



   </div>
 </div><!-- /.card -->
</div>
<!-- /.col-md-6 -->
<div class="col-lg-6">
  <div id="div1" class="card">
    <div class="card-header">
      <h5 class="m-0">Items</h5>
    </div>
    <div  class="card-body">
     <table id="g-table" class="table ">
      <thead>
        <tr>
          <th width="5%" align="center" valign="middle">Cant</th>
          <th width="12%" align="center" valign="middle">&nbsp;Codigo</th>
          <th width="34%" align="center" valign="middle">Descripcion</th>
          <th width="12%" align="center" valign="middle">Precio&nbsp;U.</th>
          <th width="12%" align="center" valign="middle">Excenta.</th>
          <th width="12%" align="center" valign="middle">5%</th>
          <th width="12%" align="center" valign="middle">10%</th>
        </tr>

      </thead>


      <tbody id= "cuerpo">
        <tr style="background: #ccffcc">

        </tr>
      </tbody>
    </table>


    <table width="100%" border="0" cellspacing="3" cellpadding="2" class="display" id="h-table" >
      <tfoot id="result">

      </tfoot>
    </table>
    <?php $titulo_form = "Confirmar Venta"; ?>

    <button type="submit" id="btPagar" class="btn btn-info" style="float:right"  href="javascript:;" onclick="abrir(); return false" >Confirmar</button>
    <input  type="hidden" value="" id="total_venta" name="total_venta"/>
  </div>
</div>



<!-- /.content-wrapper -->


<!--  ventas -->
<script src="vistas/recursos/dist/js/ventas.js"></script>


</body>
</html>


<form class="form-horizontal" name="apertura" id="apertura">
  <!-- Modal -->
  <div class="modal fade bs-example-modal-lg" id="modalInicioCaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">

        </div>
        <div class="modal-body">

          <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-6">
            <select class="producto form-control" name="producto" id="producto" required>
              <option value="">Selecciona el producto</option>
            </select>
          </div>

          <div class="col-md-12">
            <label>Producto</label>
            <input class="form-control" id="descripcion" name="descripcion"  required required disabled="false"></input>
            <input type="hidden"  id="idCompra1" name="idCompra1"  value="" >
            <input type="hidden" class="form-control" id="action" name="action"  value="ajax">
          </div>

        </div>

        <div class="row">
          <div class="col-md-4">
            <label>Cantidad</label>
            <input type="text" class="form-control" id="cantidadC" name="cantidadC" required>
          </div>

          <div class="col-md-4">
            <label>Ultimo Precio</label>
            <input type="text" class="form-control" id="precioC" name="precioC" required >
          </div>

        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-info" >Guardar</button>

      </div>
    </div>
  </div>
</div>
</form>
<?php

include("config/db.php");
include("config/conexion.php");




?>
<script type="text/javascript" >

  function dolarcambio(t,evt){
    var cambio ='<?=$_claves["dolar"]?>';
    var valor  =$(t).val()*cambio;

    $(t).parent().parent().children('td').eq(2).find('input').val(valor);
    var charCode = (evt.which) ? evt.which : evt
    if(charCode=='13'){
     $(t).parent().parent().children('td').eq(2).find('input').focus();
   }
 }
 function chang1(t){
  if($(t).val()=='dolar'){
    $(t).parent().parent().parent().children('td').eq(1).html('<input type="text" id="dolar" onkeyup="dolarcambio(this,event)" size="4"/>');
    $(t).parent().parent().parent().children('td').eq(1).find('input').focus();
    $("#credito_html").hide();
  }else if($(t).val()=='credito'){
    $(t).parent().parent().parent().children('td').eq(1).html('');
    $("#credito_html").show();
    $("#meses").focus();
  }else{
    $(t).parent().parent().parent().children('td').eq(1).html('');
    $("#credito_html").hide();
  }
}
function chang(t){
  if($(t).val()=='dolar'){
    $(t).parent().parent().children('td').eq(1).html('<input type="text" id="dolar" onkeyup="dolarcambio(this,event)" size="4"/>');
    $("#credito_html").hide();
    $(t).parent().parent().children('td').eq(1).find('input').focus();
  }else if($(t).val()=='credito'){
    $(t).parent().parent().children('td').eq(1).html('');
    $("#credito_html").show();
    $("#meses").focus();
  }else{
    $(t).parent().parent().children('td').eq(1).html('');
    $("#credito_html").hide();
  }
}
function agregar_forma_cobro(t){

 var suma = 0;
 $('.cantidad').each(function(i){
  if($(this).val()!= ''&& $(this).val()!= 'undefined'){
    if(parseInt($(this).val())){
      suma = suma+parseInt($(this).val());
    }
  }

});
 var  selec = '';
 var array=Array();
 $('.pago').each(function(index, element) {
  if($(this).val()=='efectivo'){
    array.push('efectivo');
  }
  if($(this).val()=='credito'){
    array.push('credito');
  }
  if($(this).val()=='mastercard'){
    array.push('mastercard');
  }
  if($(this).val()=='visa'){
    array.push('visa');
  }
  if($(this).val()=='amex'){
    array.push('amex');
  }
  if($(this).val()=='cabal'){
    array.push('cabal');
  }
  if($(this).val()=='panal'){
    array.push('panal');
  }
  if($(this).val()=='dolar'){
    array.push('dolar');
  }
  if($(this).val()=='publicidad'){
    array.push('publicidad');
  }
  if($(this).val()=='cheque'){
    array.push('cheque');
  }
  if($(this).val()=='debito'){
    array.push('debito');
  }


});

 var selec = '';
 if(jQuery.inArray('efectivo',array)=='-1'){
  selec += '<option value="efectivo" selected="selected">Efectivo</option>';
}

if(jQuery.inArray('mastercard',array)=='-1'){
  selec += '<option value="mastercard">MasterCard</option>';
}
if(jQuery.inArray('visa',array)=='-1'){
  selec += '<option value="visa">Visa</option>';
}
if(jQuery.inArray('amex',array)=='-1'){
  selec += '<option value="amex">American Experss</option>';
}

if(jQuery.inArray('cabal',array)=='-1'){
  selec += '<option value="cabal">Cabal</option>';
}
if(jQuery.inArray('credito',array)=='-1'){
  selec += '<option value="credito">CREDITO CLIENTE</option>';
}
if(jQuery.inArray('panal',array)=='-1'){
  selec += '<option value="panal">Panal</option>';
}
<?php if($_claves["dolar"]!='') { ?>
  if(jQuery.inArray('dolar',array)=='-1'){
    selec += '<option value="dolar">Dolar</option>';
  }
<?php } ?>
if(jQuery.inArray('publicidad',array)=='-1'){
  selec += '<option value="publicidad">Publicidad y Propaganda</option>';
}
if(jQuery.inArray('cheque',array)=='-1'){
  selec += ' <option value="cheque">Cheque</option>';
}
if(jQuery.inArray('debito',array)=='-1'){
  selec += '<option value="debito">Debito</option>';
}




if(parseInt($('#total_venta').val())>suma){
 var valor= parseInt($('#total_venta').val())-suma;


 $('#tablita tbody').append('<tr>\
  <td><select style="width:100px" class="pago" onchange="chang(this)">'+selec+'</select></td>\
  <td id="de"></td>\
  <td><input type="text" name="cantidad" onkeypress="cargar(event,this)"  class="cantidad" value="'+valor+'" onfocus/> <label style="cursor:pointer" href="javascript:void(0)" onclick="quitar(this)">[ X ]</label></td>\
  </tr>');
 $('.cantidad').focus();
 $('#finalizar').hide('fast');
}else{
 var credito=0;
 $(".pago").each(function(){
  if($(this).val()=='credito'){
    credito=1;
  }
});
 if(credito==1){
  $("#credito_html").show();
  $("#meses").focus();
  if($("#cliente").val()=='1'){
    alert("Debe seleccionar Un cliente Valido");
    return false;
  }else{
    $('#vuelto').html(suma-parseInt($('#total_venta').val()).toString());
    $('#finalizar').show('fast');
  }
}else{
  $('#vuelto').html(suma-parseInt($('#total_venta').val()).toString());
  $('#finalizar').show('fast');
}


}

$(".pago").each(function(){
  if($(this).val()=='credito'){
    $("#credito_html").show();
    $("#meses").focus();
  }
})

}
function guardar(evt){
 var charCode = (evt.which) ? evt.which : evt
 var total=$('#total_venta').val();
 var id_venta = $('#txtVenta').val();
 var nombre_cliente = $('#cliente').val();
 var forma_pago = '';
 var cantidad = '';
 var vuelto = $('#vuelto').html();
 var suma = 0;
 $('.cantidad').each(function(i){
  cantidad +=$(this).val()+'|';
  if($(this).val()!= ''&& $(this).val()!= 'undefined'){
    if(parseInt($(this).val())){
      suma = suma+parseInt($(this).val());
    }
  }
});

 $('.pago').each(function(i){
  forma_pago += $(this).val()+'|';
});
 var tipo ='';
 $('input[type="radio"]').each(function(i){
  if($(this).parent().attr('class')=="checked"){
    tipo = $(this).val();
  }
});


 if(parseInt($('#total_venta').val())<=suma){
   $.ajax({
    url: "ajax/ajaxGuardarVenta.php",
    data: "total="+total+'&id_venta='+id_venta+'&forma_pago='+forma_pago+'&cantidad='+cantidad+'&tipo='+tipo+'&cliente='+nombre_cliente+'&vuelo='+vuelto+'&iva5='+$("#ivainput5").val()+'&iva10='+$("#ivainput10").val()+"&meses="+$("#meses").val()+"&interes_venta="+$("#interes_venta").val(),
    type: "POST",
    dataType: "json",
    success: function(data){
      if(data.exito=='si'){
        $('#confirm-form').modal('hide');
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Pago exitoso",
         showConfirmButton: false,
         timer: 1100
       })
       var accion = "buscarVentas";
         $.ajax({
           url: "ajax/ajaxVentas.php",
           data: "idVenta="+id_venta+'&accion='+accion,
           type: "POST",
           dataType: "json",
           success: function(resultado){
             console.log(resultado);
             if(resultado){
               for(let i=0; i< e.data.zonas.lenght;i++){
                 $.post(`https://167.62.136.170/printapp/print/venta`,{venta:resultado,zonas:null})

                }
             }

             setTimeout(function() {location.reload();}, 1105)
             inicio();
           }
         });


      }else{
        alert('No se pudo Guardar Ocurrio un error interno:\n:'+data.error);
      }
    }
  });
 }
 else{
  alert('los valores no superan a la venta');
}

}
function quitar(id){
  var td = id.parentNode;
  var tr= td.parentNode;
  var table = tr.parentNode;
  table.removeChild(tr);

}
$(function(){
  $('#total_venta_confirmar').html("Gs. "+number_format($('#total_venta').val(),0,',','.'));
  $('#cantidad').attr('value',$('#total_venta').val());
  document.getElementById('cantidad').focus();
})


function number_format (number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
  prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
  sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
  dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
  s = '',
  toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k;
  };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }
</script>

<style>
  #total_venta_confirmar{
   font-size: 35px;
 }
 #confirm-form input{
  background-color: #E7EDEF;
  border: 1px solid #CCCCCC;
  border-radius: 0 3px 3px 3px;
  font-size: 11px;
  height: 18px;
  width: 100px;
}
.color {color:#FFFFFF;}


</style>

<div id="confirm-form" title="<?=$titulo_form?>"  style="display: none">
 <fieldset>
  <h2 id="total_venta_confirmar"></h2>
  <hr />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tabla">
    <tr>
      <td width="55%"><select class="pago" onchange="chang1(this)">
        <option value="efectivo" selected="selected">Efectivo</option>
        <option value="mastercard">MasterCard</option>
        <option value="visa">Visa</option>
        <option value="amex">American Experss</option>
        <option value="cabal">Cabal</option>
        <option value="credito">CREDITO CLIENTE</option>
        <option value="panal">Panal</option>
        <?php if($_claves["dolar"]!='') { ?>
          <option value="dolar">Dolar</option>
        <?php } ?>
        <option value="cheque">Cheque</option>
        <option value="publicidad">Publicidad y Propaganda</option>
      </select></td>
      <td width="1%" id="de"></td>
      <td width="44%"><input type="text" name="cantidad" id="cantidad"  class="cantidad" onkeypress="cargar(event,this)" /></td>
    </tr>
  </table>
  <div id="credito_html" style="display:none">
    <table width="100%" style="border:1px solid #999; margin-top:5px;">
      <tr>
        <td width="56%"><strong>Cantidad Meses:</strong></td>
        <td width="44%"><input name="meses" value="2" type="text" class="small" id="meses" size="5" onkeypress="cargar(event,this)"/></td>
      </tr>
      <tr>
        <td><strong>% Interes Anual:</strong></td>
        <td><input name="interes_venta" type="text" class="small" id="interes_venta" size="5" value="<?=$_claves["interes_venta_anual"]?>" onkeypress="cargar(event,this)"/>
        %</td></tr></table>
      </div>
      <br>
      <h2>El Vuelto es:<label id="vuelto"></label></h2>
      <div style="position:absolute; bottom:1px;">Presione Enter Para confirmar</div>
      <button id="finalizar"  class="skin_colour round_all" style="float:right; display:none" onclick="guardar(event)"> <img width="24" height="24" alt="Price Tag" src="images/icons/small/white/Price%20Tag.png"> <span>Finalizar</span></button>
    </fieldset>
  </div>
