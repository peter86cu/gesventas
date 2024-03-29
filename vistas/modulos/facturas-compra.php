<?php 
 $color_header="";
 $i_principal="";
 $botton_principal="";
 $botton_editar="";
 $botton_eliminar="";
 $color_tabla="";
        $datos= "SELECT * FROM `color_sistema` WHERE modulo=1";
        $colores = ControlRoles::colores($datos);
        
        foreach ($colores as $key => $value) {
            if($value['posicion']==2){              
              $i_principal=$value['style'];
            }            
            if($value['posicion']==1){
               $color_header=$value['style'];
            }
            if($value['posicion']==3){
               $botton_principal=$value['style'];
            }
            if($value['posicion']==4){
               $botton_editar=$value['style'];              
            }
            if($value['posicion']==5){
               $botton_eliminar=$value['style'];               
            }
            if($value['posicion']==6){
               $color_tabla=$value['style'];               
            }
           
        }

         $db = new BaseDatos();
      $rol="";
      $niveles = array();     
      $resultado=$db->buscarSQL("select DISTINCT r.id_rol,r.id_modulo,r.id_nivel,m.nombre FROM  roles_modulos_niveles r inner join roles_modulos rm on (rm.id_modulo=r.id_modulo) inner join modulos m on (r.id_modulo=m.id_modulo) where estado =1 and r.id_rol=".$_SESSION['rol']." and m.id_modulo=9");
        foreach($resultado as $row) { 
        $niveles[] = $row['id_nivel']; 
        
      }

 ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> <i class="fas fa-file-invoice-dollar" style="<?php echo $i_principal ?>"></i> <strong>FACTURAS DE COMPRAS</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Facturas de compras</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
      <?php if(in_array(2, $niveles)) { ?>   <button class="btn btn-primary" style="<?php echo $botton_principal ?>" href="javascript:;" onclick="agregarFacturaInicial(); return false" ><i class="fas fa-plus"></i>Agregar</button>  <?php } ?> 

     </div>
   </div>
   <div class="card-body">
<div align="right" class="form-group">
 <input type="text" class="form-control pull-right" style="width:20%;"  id="searchfacturas" placeholder="Type to search table...">
</div>
      <table id="factura" class="table table-bordered table-striped">
      <thead>
        <tr style="<?php echo $color_tabla ?>">
          <th><strong>NÚMERO</strong></th>
          <th><strong>FECHA</strong></th>
          <th><strong>ITEMS</strong></th>
          <th><strong>TOTAL</strong></th>
          <th><strong>ENTRADA POR</strong></th>
          <th><strong>RECIBIDO POR</strong></th>
          <th><strong>PROVEEDOR</strong></th>
          <th><strong>ESTADO</strong></th>
         <?php if(in_array(3, $niveles) || in_array(4, $niveles) || in_array(5, $niveles)) { ?>  <th style="width: 9%"><strong>ACCIÓN</strong></th>  <?php } ?>
        </tr>
      </thead>
      <tbody id="myFacturaBody">


        <?php
        $parametro= null;
        $datos= "SELECT ec.id_entrada_compra,
        DATE_FORMAT(ec.fecha_hora, '%d-%m-%Y') as fecha,
        (select count(*) from entradas_compras_detalle where id_entrada_compra=ec.id_entrada_compra) as items,
        e.descripcion as estado,
        e.id_entrada_compra_estado as id_estado,
        u.nombres,
        d.descripcion,
        ec.id_usuario_recibio,
        pro.razon_social as proveedor,
        (select CONCAT ( sum(cantidad*importe), ' ',m.descripcion)  from entradas_compras_detalle, monedas m where id_entrada_compra=ec.id_entrada_compra and m.id_moneda=ec.id_moneda ) as total
        FROM   entradas_compras_estados e,usuarios u,entradas_compras ec
        left join proveedores  as pro on ec.id_proveedor=pro.id_proveedor
        LEFT JOIN depositos as d on ec.id_deposito=d.id_deposito
        WHERE  e.id_entrada_compra_estado = ec.estado and u.id_usuario=ec.id_usuario and ec.fecha_baja is null order by id_entrada_compra desc";
        $ordenes = ControlFacturaCompras::mostrarFacturas($parametro,$datos);
        foreach ($ordenes as $key => $value) {
          if($value['id_estado']==2){
            $color = "azul";
          }elseif($value['id_estado']==3){
            $color = "verde";
          }elseif($value['id_estado']==4){
            $color = "rojo";
          }else{
            $color ="negro";
          }

          if($value['proveedor']==null){
            $provee ='<label class="text_naranja">Sin Proveedor</label>';
          }else{
            $provee =$value['proveedor'];
          }

          $total=0;
          if($value['total']>0){
            $total=$value['total'];
          }

          $parametro1=null;
          $usuario="SELECT nombres from usuarios where id_usuario=".$value['id_usuario_recibio']."";
          $recibido_por = ControlFacturaCompras::mostrarFacturas($parametro1,$usuario);
          $recibido="";
          foreach ($recibido_por as $key => $values) {
            $recibido=$values['nombres'];

          }

          ?>

          <tr>
            <td style="width: 1%"><?php echo $value['id_entrada_compra'] ?></td>
            <td style="width: 8%"><?php echo $value['fecha']?></td>
            <td style="width: 5%"><?php echo $value['items']?></td>
            <td style="width: 8%"><?php echo $total ?></td>
            <td style="width: 8%"><?php echo $value['nombres']?></td>
            <td style="width: 8%"><?php echo $recibido ?></td>
            <td style="width: 8%"><?php echo $provee ?></td>
            <td style="width: 8%">
              <span class="text_<?php echo $color ?>" ><?php echo $value['estado']?></span>
            </td>
          <?php if(in_array(3, $niveles) || in_array(4, $niveles) || in_array(5, $niveles)) { ?>  <td style="text-align: left;">
              <div class="btn-bt-group"></div>

              <?php if ($value['id_estado']!=1 and $value['items']>0 and in_array(3, $niveles)) { ?>
                <button class="btn btn-warning ModalEditarCompras" idCompra="<?php echo $value['id_entrada_compra'] ?>"  data-toggle="modal" data-target="#ModalEditarCompras" style="<?php echo $botton_editar ?>" ><i class="far fa-edit"></i></button>
              <?php } else { ?>
                <?php if(in_array(2, $niveles)) { ?>  <button class="btn btn-warning ModalADDFacturas" idCompra="<?php echo $value['id_entrada_compra'] ?>"  data-toggle="modal" data-target="#ModalADDFacturas" style="<?php echo $botton_editar ?>" ><i class="far fa-edit"></i></button>
              <?php } } ?>
              <?php if(in_array(4, $niveles)) { ?>  <button class="btn btn-danger btnEliminarFactura" style="<?php echo $botton_eliminar ?>" idCompra="<?php echo $value['id_entrada_compra'] ?>" ><i  class="fas fa-trash"></i></button><?php }  ?>
              <?php if ($value['id_estado']==3 and $value['items']>0 and in_array(5, $niveles)) { ?>
                <button class="btn btn-success" style="color:#001f3f"  href="javascript:;"  onclick="datosImprimir(<?php echo $value['id_entrada_compra'] ?>); return false" ><i class="fas fa-print" ></i></button>
              <?php }  ?>
            </td> <?php }  ?>
          </tr>

        <?php }  ?>




      </table>

      <div class="col-md-12 text-center">
           <ul class="pagination pagination-lg pager" id="myPager"></ul>
       </div>



    </div>

  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<style type="text/css">


  .text_rojo{
    color:#C40000;
    font-weight:bold;
  }

  .text_verde{
    color:#060;
    font-weight:bold;
  }
  .text_azul{
    color:#00F;
    font-weight:bold;
  }
  .text_naranja{
    color:#F60;
    font-weight:bold;
  }
  .text_negro{
    color:#000000;
    font-weight:bold;
  }

  .text_normal{
    color:inherit;

  }


a.active {
    background-color: #4CAF50;
    color: white;
    border-radius: 5px;
}


div.nav {
    display: inline-block;
    padding: 0;
    margin: 0;
}

.nav.a {display: inline;}

 a.bot  {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 5px;
}



</style>



<!-- The Modal Add Ordenes -->
<div class="modal" id="ModalADDFacturas" data-backdrop="static" data-keyboard="false"  >
  <div class="modal-dialog modal-xl"   >
    <div class="modal-content">

      <form class="form-horizontal" role="form" id="datos_factura" id="datos_factura" method="post">

        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>">
          <h4 class="modal-title">NUEVA FACTURA DE COMPRA</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" >
          <div class="box-body">


            <div id="print-area">



              <div class="row ">
                <hr />
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h2>Detalles del proveedor :</h2>
                  <select style="width: 50%" class="proveedor2 form-control" name="proveedor2" id="proveedor2">
                    <option  value="">Selecciona el proveedor</option>
                  </select>
                  <h5><strong>Proveedor: </strong><Label id="proveedorNF"></Label></h5>
                  <span id="direccionF"></span>
                  <input type="hidden"  id="idProveedorF" name="idProveedorF"  value="" >
                  <h5><strong>E-mail: </strong><span id="emailF"></span></h5>
                  <h5><strong>Teléfono: </strong><span id="telefonoF"></span></h5>

                  <div class="row">
                    <div class="col-lg-6">

                      <label for="txtOrdenCompra">Orden de Compra</label>
                     <!-- <input type="text"  id="txtOrdenCompra" name="txtOrdenCompra" value="" onBlur="validarOrdenCompra(1);" autofocus required > -->
                        <select id="txtOrdenCompra" name="txtOrdenCompra" class="form-control custom-select" onBlur="validarOrdenCompra(1);" required>
                        <option value="1"  selected >S/N</option>
                        <?php
                        $db = new BaseDatos();
                        if($resultado=$db->buscar("ordenes_de_compras","estado = 3")){
                          foreach($resultado as $row) { ?>
                            <option value=<?=$row['id_orden_compra'] ?>><?=$row['id_orden_compra'] ?></option> <?php } } ?>
                          </select>
                    </div>
                    <div class="col-lg-6">
                      <label for="txtNumeroFactura">No. Factura</label>
                      <input type="text"  id="txtNumeroFactura" name="txtNumeroFactura" value="" onBlur="validarNumeroFactura(1);" autofocus required>
                    </div>

                  </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h2>Detalles de la orden de compra :</h2>
                  <div class="row">
                    <div class="col-lg-5">
                      <h4><strong>Entrada #: </strong><label id="idFactura" value=""></label></h4>
                      <input type="hidden"  id="idCompra" name="idCompra"  value="" >
                    </div>
                    <div class="col-lg-5">
                     <h3><strong>Fecha: </strong>
                      <label id="fecha" value=""></label></h3><input type="text" id="datepickerF" onBlur="validarFecha(1);" autofocus required="true">
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-lg-5">

                      <label for="txtFormaPagoF">Forma de Pago</label>
                      <select id="txtFormaPagoF" name="txtFormaPagoF" class="form-control custom-select" onBlur="validarFormaPago(1);" required>
                        <option  selected disabled>Seleccione</option>
                        <?php
                        $db = new BaseDatos();
                        if($resultado=$db->buscar("formas_pagos","1")){
                          foreach($resultado as $row) { ?>
                            <option value=<?=$row['id_forma_pago'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                          </select>

                        </div>


                        <div class="col-lg-5">
                          <label for="txtEnvioF">Plazo</label>
                          <select id="txtEnvioF" name="txtEnvioF" class="form-control custom-select" onBlur="validarMetodoEnvio(1);" required>
                            <option  selected disabled>Seleccines</option>
                            <?php
                            $db = new BaseDatos();
                            if($resultado=$db->buscar("plazos","1")){
                              foreach($resultado as $row) { ?>
                                <option value=<?=$row['id_plazo'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                              </select>
                            </div>

                          </div>

                          <div class="row">
                            <div class="col-lg-5">

                              <label for="txtDeposito">Deposito</label>
                              <select id="txtDeposito" name="txtDeposito" class="form-control custom-select" onBlur="validarDeposito(1);" >
                                <option  selected disabled required>Seleccines</option>
                                <?php
                                $db = new BaseDatos();
                                if($resultado=$db->buscar("depositos","1")){
                                  foreach($resultado as $row) { ?>
                                    <option value=<?=$row['id_deposito'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                                  </select>

                                </div>


                                <div class="col-lg-5">
                                  <label for="txtMonedaF">Moneda</label>
                                  <select id="txtMonedaF" name="txtMonedaF" class="form-control custom-select" onBlur="validarMoneda(1);" required>
                                    <option  selected disabled>Seleccines</option>
                                    <?php
                                    $db = new BaseDatos();
                                    if($resultado=$db->buscar("monedas","1")){
                                      foreach($resultado as $row) { ?>
                                        <option value=<?=$row['id_moneda'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                                      </select>
                                    </div>

                                  </div>

                                  <div class="row">
                                   <div class="col-lg-5">

                                    <label for="txtReceptor">Receptor</label>
                                    <select id="txtReceptor" name="txtReceptor" class="form-control custom-select" onBlur="validarReceptor(1);" required >
                                      <option  selected disabled>Seleccione</option>
                                      <?php
                                      $db = new BaseDatos();
                                      if($resultado=$db->buscar("usuarios","1")){
                                        foreach($resultado as $row) { ?>
                                          <option value=<?=$row['id_usuario'] ?>><?=$row['nombres'] ?></option> <?php } } ?>
                                        </select>

                                      </div>
                                    </div>




                                  </div>
                                </div>

                                <div class="row">
                                  <hr />
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                      <table class="table table-bordered">
                                        <thead>
                                          <tr >
                                            <th class='text-center'>Item</th>
                                            <th class='text-center'>Cantidad</th>
                                            <th class='text-center'>Código</th>
                                            <th class='text-center'>Descripción</th>
                                            <th class='text-center'>Ultimo Precio</th>
                                            <th class='text-center'>Total</th>
                                            <th class='text-center'></th>
                                          </tr>
                                        </thead>
                                        <tbody class='items'>
                                        </tbody>


                                      </table>


                                    </div>
                                  </div>
                                </div>

                              </div>
                              <div class="row"> <hr /></div>
                              <div class="row pad-bottom  pull-right">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <button type="submit" class="btn btn-warning" href="javascript:;" onclick="guardar_compra(1); return false">Pendiente de recepción</button>
                                  <button type="submit" class="btn btn-success" style ="float: right;" href="javascript:;" onclick="guardar_compra(2); return false">Completado</button>
                                </div>
                              </div>
                            </div>
                          </div>

                        </form>
                      </div>

                    </div>


                  </div>


                  <form class="form-horizontal" name="guardar_item" id="guardar_item">
                    <!-- Modal -->
                    <div class="modal fade bs-example-modal-lg" id="myModalCompra"  role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">

                          </div>
                          <div class="modal-body">

                            <div class="row">
                             <div class="col-lg-6 col-md-6 col-sm-6">
                              <select style="width: 100%" class="producto form-control" name="producto" id="producto" required>
                                <option value="">Selecciona el producto</option>
                              </select>
                            </div>

                            <div class="col-md-12">
                              <label>Producto</label>
                              <input class="form-control" id="descripcion" name="descripcion"  required  disabled="false"></input>
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
                          <button type="submit" class="btn btn-info" href="javascript:;" onclick="guardarDetalleCompra(); return false">Guardar</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </form>





                <style type="text/css">
                 tr{
                  text-align: center;

                }
                td{
                  padding: 50px;
                  border: 1px black;
                }
                table{
                  border: 5px solid green;
                }
              </style>



              <!-- The Modal editar Productos -->
              <div class="modal" id="ModalEditarCompras" data-backdrop="static" data-keyboard="false" tabindex="-1" >
                <div class="modal-dialog modal-xl" >
                  <div class="modal-content">

                    <form class="form-horizontal" role="form" id="datos_editar" method="post">

                      <!-- Modal Header -->
                      <div class="modal-header" style="<?php echo $color_header?>">
                        <h4 class="modal-title">EDITAR FACTURA DE ENTRADA</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body" style = "overflow: hidden;">
                        <div class="box-body">


                          <div id="print-area">

                            <div class="row ">
                              <hr />
                              <div class="col-lg-6 col-md-6 col-sm-6">
                                <h2>Detalles del proveedor :</h2>
                                <h5><strong>Proveedor: </strong><Label id="proveedorNE"></Label></h5>
                                <input type="hidden"  id="proveedorCE" name="proveedorCE"  value="" >
                                <h5><strong>Dirección: </strong><Label id="direccionE"></Label></h5>
                                  <h5><strong>E-mail: </strong><Label id="emailE"></Label></h5>
                                  <h5><strong>Teléfono: </strong><Label id="telefonoE"></Label></h5>
                                  <div class="row">
                                    <div class="col-lg-6">

                                      <label for="txtOrdenCompraE">Orden de Compra</label>
                                     <!-- <input type="text"  id="txtOrdenCompraE" name="txtOrdenCompraE" value="" onBlur="validarOrdenCompra(2);" autofocus required> -->
                                          <select id="txtOrdenCompraE" name="txtOrdenCompraE" class="form-control custom-select" onBlur="validarOrdenCompra(2);" required>
                                          <option  selected >S/N</option>
                                          <?php
                                          $db = new BaseDatos();
                                          if($resultado=$db->buscar("ordenes_de_compras","estado = 3")){
                                            foreach($resultado as $row) { ?>
                                              <option value=<?=$row['id_orden_compra'] ?>><?=$row['id_orden_compra'] ?></option> <?php } } ?>
                                            </select>

                                    </div>
                                    <div class="col-lg-6">
                                      <label for="txtNumeroFacturaE">No. Factura</label>
                                      <input type="text"  id="txtNumeroFacturaE" name="txtNumeroFacturaE" value="" onBlur="validarNumeroFactura(2);" autofocus required >
                                    </div>




                                  </div>

                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                  <h2>Detalles de la orden de compra :</h2>
                                  <div class="row">
                                    <div class="col-lg-5">
                                      <h4><strong>Entrada #: </strong><label id="idCompraE" ></label></h4>
                                      <input type="hidden"  id="idCompra1E" name="idCompra1E"  value="" >
                                    </div>
                                    <div class="col-lg-5">
                                     <h5><strong>Fecha: </strong></h5><input type="text" id="datepickerCE" onBlur="validarFecha(2);" autofocus required="true">
                                   </div>

                                 </div>
                                 <div class="row">
                                  <div class="col-lg-5">

                                    <label for="txtFormaPagoFE">Forma de Pago</label>
                                    <select id="txtFormaPagoFE" name="txtFormaPagoFE" class="form-control custom-select" onBlur="validarFormaPago(2);" required>
                                      <option  selected disabled>Seleccines</option>
                                      <?php
                                      $db = new BaseDatos();
                                      if($resultado=$db->buscar("formas_pagos","1")){
                                        foreach($resultado as $row) { ?>
                                          <option value=<?=$row['id_forma_pago'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                                        </select>

                                      </div>


                                      <div class="col-lg-5">
                                        <label for="txtEnvioFE">Método de envío</label>
                                        <select id="txtEnvioFE" name="txtEnvioFE" class="form-control custom-select" onBlur="validarMetodoEnvio(2);" required>
                                          <option  selected disabled>Seleccione</option>
                                          <?php
                                          $db = new BaseDatos();
                                          if($resultado=$db->buscar("plazos","1")){
                                            foreach($resultado as $row) { ?>
                                              <option value=<?=$row['id_plazo'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                                            </select>
                                          </div>

                                        </div>

                                        <div class="row">
                                          <div class="col-lg-5">

                                            <label for="txtDepositoE">Deposito</label>
                                          <select id="txtDepositoE" name="txtDepositoE" class="form-control custom-select" onBlur="validarDeposito(2);" required>
                                              <option  selected disabled>Seleccines</option>
                                              <?php
                                              $db = new BaseDatos();
                                              if($resultado=$db->buscar("depositos","1")){
                                                foreach($resultado as $row) { ?>
                                                  <option value=<?=$row['id_deposito'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                                                </select>

                                              </div>


                                              <div class="col-lg-5">
                                                <label for="txtMonedaFE">Moneda</label>
                                                <select id="txtMonedaFE" name="txtMonedaFE" class="form-control custom-select" onBlur="validarMoneda(2);">
                                                  <option  selected disabled>Selecciones</option>
                                                  <?php
                                                  $db = new BaseDatos();
                                                  if($resultado=$db->buscar("monedas","1")){
                                                    foreach($resultado as $row) { ?>
                                                      <option value=<?=$row['id_moneda'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                                                    </select>
                                                  </div>

                                                </div>

                                                <div class="row">
                                                 <div class="col-lg-5">

                                                  <label for="txtReceptorE">Receptor</label>
                                                  <select id="txtReceptorE" name="txtReceptorE" class="form-control custom-select" onBlur="validarReceptor(2);">
                                                    <option  selected disabled>Seleccione</option>
                                                    <?php
                                                    $db = new BaseDatos();
                                                    if($resultado=$db->buscar("usuarios","1")){
                                                      foreach($resultado as $row) { ?>
                                                        <option value=<?=$row['id_usuario'] ?>><?=$row['nombres'] ?></option> <?php } } ?>
                                                      </select>

                                                    </div>
                                                  </div>

                                                </div>
                                              </div>


                                              <div class="row">
                                                <hr />
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                  <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                      <thead>
                                                        <tr >
                                                          <th class='text-center'>Item</th>
                                                          <th class='text-center'>Cantidad</th>
                                                          <th class='text-center'>Código</th>
                                                          <th class='text-center'>Descripción</th>
                                                          <th class='text-center'>Ultimo Precio</th>
                                                          <th class='text-center'>Total</th>
                                                          <th class='text-center'></th>
                                                        </tr>
                                                      </thead>
                                                      <tbody class='items'>

                                                      </tbody>


                                                    </table>


                                                  </div>
                                                </div>
                                              </div>

                                            </div>
                                            <div class="row"> <hr /></div>

                                            <button id="autorizar" type="submit" class="btn btn-success" href="javascript:;" onclick="guardar_compraEditadas(2); return false"><span>COMPLETAR COMPRA<br><b>A <label id="autorizo"></label></b></span></button>


                                            <button id="cancelar" type="submit" class="btn btn-danger"  style ="float: right;" href="javascript:;" onclick="guardar_compraEditadas(3); return false"><span>CANCELAR<br><b>A <label id="cancelo"></b></span></button>






                                            </div>
                                          </div>

                                        </form>
                                      </div>

                                    </div>


                                  </div>
