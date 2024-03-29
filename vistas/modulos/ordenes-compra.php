<?php 
 $color_header="";
 $i_principal="";
 $botton_principal="";
 $botton_editar="";
 $botton_eliminar="";
 $color_tabla="";
 $botton_imprimir="";
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
            if($value['posicion']==7){
               $botton_imprimir=$value['style'];               
            }
           
        }


         $db = new BaseDatos();
      $rol="";
      $niveles = array();     
      $resultado=$db->buscarSQL("select DISTINCT r.id_rol,r.id_modulo,r.id_nivel,m.nombre FROM  roles_modulos_niveles r inner join roles_modulos rm on (rm.id_modulo=r.id_modulo) inner join modulos m on (r.id_modulo=m.id_modulo) where estado =1 and r.id_rol=".$_SESSION['rol']." and m.id_modulo=10");
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
          <h1><i class="fas fa-shipping-fast" style="<?php echo $i_principal ?>"></i> <strong>ORDENES DE COMPRAS</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Ordenes de compras</li>
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
     <?php if(in_array(2, $niveles)) { ?>  <button class="btn btn-primary" style="<?php echo $botton_principal ?>" href="javascript:;" onclick="agregarOrdenInicial(); return false" ><i class="fas fa-plus"></i>Agregar</button>  <?php } ?>


     </div>
   </div>
   <div class="card-body">

    <div align="right" class="form-group">
 <input type="text" class="form-control pull-right" style="width:20%;"  id="searchordenes" placeholder="Type to search table...">
</div>

     <table id="ordenes" class="table table-bordered table-striped">
      <thead>
        <tr style="<?php echo $color_tabla ?>">
          <th><strong>NÚMERO</strong></th>
          <th><strong>FECHA</strong></th>
          <th><strong>FORMA DE PAGO</strong></th>
          <th><strong>ITEMS</strong></th>
          <th><strong>SOLICITADO POR</strong></th>
          <th><strong>APROBADO POR</strong></th>
          <th><strong>PROVEEDOR</strong></th>
          <th><strong>ESTADO</strong></th>
        <?php if(in_array(3, $niveles) || in_array(4, $niveles) || in_array(5, $niveles) || in_array(6, $niveles)) { ?>   <th style="width: 9%"><strong>ACCIÓN</strong></th> <?php } ?> 
        </tr>
      </thead>
      <tbody>


        <?php
        $parametro= null;
        $datos= "SELECT oc.id_orden_compra,
        DATE_FORMAT(oc.fecha_hora, '%d-%m-%Y')   as fecha,
        p.descripcion as plazo,
        f.descripcion as forma_pago,
        (select count(*) from ordenes_de_compras_detalle where id_orden_compra=oc.id_orden_compra) as items,
        e.descripcion as estado,
        e.id_orden_compra_estado as id_estado,
        u.nombres,
        pro.razon_social as proveedor
        FROM plazos p, formas_pagos f, ordenes_de_compras_estados e,usuarios u,ordenes_de_compras oc
        left join proveedores  as pro on oc.id_proveedor=pro.id_proveedor
        WHERE oc.id_plazo=p.id_plazo and oc.id_forma_pago = f.id_forma_pago and e.id_orden_compra_estado = oc.estado and u.id_usuario=oc.id_usuario and oc.fecha_baja is null order by id_orden_compra desc";
        $ordenes = ControlOrdenes::mostrarOrdenes($parametro,$datos);
        foreach ($ordenes as $key => $value) {
          if($value['id_estado']==2){
            $color = "naranja";
          }elseif($value['id_estado']==3){
            $color = "azul";
          }elseif($value['id_estado']==4){
            $color = "verde";
          }elseif($value['id_estado']==5){
            $color = "rojo";
          }else{
            $color ="negro";
          }

          if($value['proveedor']==null){
            $provee ='<label class="text_naranja">Sin Proveedor</label>';
          }else{
            $provee =$value['proveedor'];
          }
          $parametro1=null;
          $usuario_aprobado="SELECT u.nombres from usuarios u inner join ordenes_compras_modificaciones om
          on(u.id_usuario=om.id_usuario_autorizo) and om.id_orden_compra=".$value['id_orden_compra']."";
          $aprobado_por = ControlOrdenes::mostrarOrdenes($parametro1,$usuario_aprobado);
          $apobado="";
          foreach ($aprobado_por as $key => $values) {
            $apobado=$values['nombres'];

          }
          ?>

          <tr>
            <td style="width: 1%"><?php echo $value['id_orden_compra'] ?></td>
            <td style="width: 8%"><?php echo $value['fecha']?></td>
            <td style="width: 8%"><?php echo $value['forma_pago']?></td>
            <td style="width: 5%"><?php echo $value['items']?></td>
            <td style="width: 8%"><?php echo $value['nombres']?></td>
            <td style="width: 8%"><?php echo $apobado ?></td>
            <td style="width: 8%"><?php echo $provee ?></td>
            <td style="width: 8%">
              <span class="text_<?php echo $color ?>" ><?php echo $value['estado']?></span>
            </td>
          <?php if(in_array(3, $niveles) || in_array(4, $niveles) || in_array(5, $niveles) || in_array(6, $niveles)) { ?>   <td style="text-align: left;">
              <div class="btn-bt-group"></div>

              <?php if ($value['id_estado']!=1 && $value['items']>0 && in_array(3, $niveles) ) { ?>
                <button class="btn btn-default ModalEditarOrdenes" idOrden="<?php echo $value['id_orden_compra'] ?>" idEstado="<?php echo $value['id_estado'] ?>" data-toggle="modal" data-target="#ModalEditarOrdenes" style="<?php echo $botton_editar ?>" ><i class="far fa-edit"></i></button>
              <?php } else { ?>
               <?php if(in_array(2, $niveles)) { ?>  <button class="btn btn-default ModalADDOrdenes" idOrden="<?php echo $value['id_orden_compra'] ?>"  data-toggle="modal" data-target="#ModalADDOrdenes" style="<?php echo $botton_editar ?>"><i class="far fa-edit"></i></button>
              <?php } } ?>
              <button class="btn btn-default btnEliminarOrden" idOrden="<?php echo $value['id_orden_compra'] ?>" style="<?php echo $botton_eliminar ?>"><i  class="fas fa-trash"></i></button>
              <?php if ($value['id_estado']==3 || $value['id_estado']==4 && $value['items']>0 && in_array(5, $niveles)) { ?>
                <button class="btn btn-success" style="color:#001f3f"  href="javascript:;" style="<?php echo $botton_eliminar ?>" onclick="datosImprimir(<?php echo $value['id_orden_compra'] ?>); return false" ><i class="fas fa-print" ></i></button>
             <?php }  ?>

              <?php if ( $value['id_estado']==3 && $value['items']>0  && in_array(6, $niveles)) { ?>
                <button class="btn btn-default"   href="javascript:;" style="<?php echo $botton_imprimir ?>" onclick="datosEnviarMail(<?php echo $value['id_orden_compra'] ?>); return false" ><i class="far fa-paper-plane"></i></button>
             <?php }  ?>
           </td>    <?php }  ?>
         </tr>

       <?php }  ?>




     </table>

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
<div class="modal" id="ModalADDOrdenes" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-xl"   >
    <div class="modal-content">

      <form class="form-horizontal" role="form" id="datos_presupuesto" method="post">

        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>">
          <h4 class="modal-title">NUEVA ORDEN DE COMPRA</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" >
          <div class="box-body">


          
              <div class="row ">
                <hr />
                <div class="col-lg-6 col-md-6 col-sm-6">
                <h2>Detalles del proveedor :</h2>
                 <select style="width: 50%" class="proveedor form-control" name="proveedor" id="proveedor" >
                    <option value="">Selecciona el proveedor</option>
                  <h4><strong>Proveedor: </strong><Label id="proveedorN"></Label></h4>
                  <span id="direccion"></span>
                  <input type="hidden"  id="idProveedor" name="idProveedor"  value="" >
                  <h4><strong>E-mail: </strong><span id="email"></span></h4>
                  <h4><strong>Teléfono: </strong><span id="telefono"></span></h4>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h2>Detalles de la orden de compra :</h2>
                  <div class="row">
                    <div class="col-lg-6">
                      <h4><strong>Orden #: </strong><label id="idOrden" value=""></label></h4>
                      <input type="hidden"  id="idOrdenT" name="idOrdenT"  value="" >
                    </div>
                    <div class="col-lg-6">
                     <h3><strong>Fecha: </strong>
                      <label id="fecha" value=""></label></h3><input type="text" id="datepicker">
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-lg-6">

                      <label for="txtFormaPago">Forma de Pago</label>
                      <select id="txtFormaPago" name="txtFormaPago" class="form-control custom-select">
                        <option  selected disabled>Seleccines</option>
                        <?php
                        $db = new BaseDatos();
                        if($resultado=$db->buscar("formas_pagos","1")){
                          foreach($resultado as $row) { ?>
                            <option value=<?=$row['id_forma_pago'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                          </select>

                        </div>


                        <div class="col-lg-6">
                          <label for="txtEnvio">Método de envío</label>
                          <select id="txtEnvio" name="txtEnvio" class="form-control custom-select">
                            <option  selected disabled>Seleccines</option>
                            <?php
                            $db = new BaseDatos();
                            if($resultado=$db->buscar("plazos","1")){
                              foreach($resultado as $row) { ?>
                                <option value=<?=$row['id_plazo'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
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

                    
                    <div class="row"> <hr /></div>
                    <div class="row pad-bottom  pull-right">

                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <button type="submit" class="btn btn-success" href="javascript:;" onclick="guardar_orden(1); return false">Crear orden de compra</button>
                        <button type="submit" class="btn btn-danger" style ="float: right;" href="javascript:;" onclick="guardar_orden(0); return false">Guardar borrador</button>
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
          <div class="modal fade bs-example-modal-lg" id="myModal"  role="dialog" aria-labelledby="myModalLabel">
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
                    <input class="form-control" id="descripcion" name="descripcion"  required required disabled="false"></input>
                    <input type="hidden"  id="idOrdenT1" name="idOrdenT1"  value="" >
                    <input type="hidden" class="form-control" id="action" name="action"  value="ajax">
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-4">
                    <label>Cantidad</label>
                    <input type="text" class="form-control" id="cantidad" name="cantidad" required>
                  </div>

                  <div class="col-md-4">
                    <label>Ultimo Precio</label>
                    <input type="text" class="form-control" id="precio" name="precio" required disabled="false">
                  </div>

                </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-info" href="javascript:;" onclick="guardarDetalleOrden(); return false">Guardar</button>

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
    <div class="modal" id="ModalEditarOrdenes" >
      <div class="modal-dialog modal-xl" data-backdrop="static" data-keyboard="false" tabindex="-1" >
        <div class="modal-content">

          <form class="form-horizontal" role="form" id="datos_editar" method="post">

            <!-- Modal Header -->
            <div class="modal-header" style="<?php echo $color_header?>">
              <h4 class="modal-title">EDITAR ORDEN DE COMPRA</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style = "overflow: hidden;">
              <div class="box-body">


                <div id="print-area">
                  <div class="row pad-top font-big">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <a href="https://obedalvarado.pw/" target="_blank">  <img src="assets/img/logo.png" alt="Logo sistemas web" /></a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <strong>E-mail : </strong> Prueba
                      <br />
                      <strong>Teléfono :</strong> Prueba <br />
                      <strong>Sitio web :</strong> prueba.com

                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <strong>comercial</strong>
                      <br />
                      Dirección : alguna
                    </div>

                  </div>


                  <div class="row ">
                    <hr />
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <h2>Detalles del proveedor :</h2>
                      <h4><strong>Proveedor: </strong><Label id="proveedorNE"></Label></h4>
                      <input type="hidden"  id="proveedorE1" name="proveedorE1"  value="" >
                      <h4><strong>Dirección: </strong><Label id="direccionE"></Label>
                        <h4><strong>E-mail: </strong><Label id="emailE"></Label></h4>
                        <h4><strong>Teléfono: </strong><Label id="telefonoE"></Label></h4>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <h2>Detalles de la orden de compra :</h2>
                        <div class="row">
                          <div class="col-lg-6">
                            <h4><strong>Orden #: </strong><label id="idOrdenE" ></label></h4>
                            <input type="hidden"  id="idOrden1E" name="idOrden1E"  value="" >
                          </div>
                          <div class="col-lg-5">
                           <h5><strong>Fecha: </strong></h5><input type="text" id="datepickerE">
                         </div>

                       </div>
                       <div class="row">
                        <div class="col-lg-6">

                          <label for="txtFormaPagoE">Forma de Pago</label>
                          <select id="txtFormaPagoE" name="txtFormaPagoE" class="form-control custom-select">
                            <option  selected disabled>Seleccines</option>
                            <?php
                            $db = new BaseDatos();
                            if($resultado=$db->buscar("formas_pagos","1")){
                              foreach($resultado as $row) { ?>
                                <option value=<?=$row['id_forma_pago'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
                              </select>

                            </div>


                            <div class="col-lg-6">
                              <label for="txtEnvioE">Método de envío</label>
                              <select id="txtEnvioE" name="txtEnvioE" class="form-control custom-select">
                                <option  selected disabled>Seleccines</option>
                                <?php
                                $db = new BaseDatos();
                                if($resultado=$db->buscar("plazos","1")){
                                  foreach($resultado as $row) { ?>
                                    <option value=<?=$row['id_plazo'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>
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

                        <button type="submit"  id="bttautorizo" class="btn btn-success" href="javascript:;" onclick="guardar_ordenEditadas(2); return false"><span>AUTORIZAR ORDEN<br><b>A <label id="autorizo"></label></b></span></button>


                        <button type="submit" class="btn btn-danger" id="bttcancelo"  style ="float: right;" href="javascript:;" onclick="guardar_ordenEditadas(5); return false"><span>CANCELAR<br><b>A <label id="cancelo"></b></span></button>






                        </div>
                      </div>

                    </form>
                  </div>

                </div>


              </div>
