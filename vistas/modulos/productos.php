<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
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

 ?>
          <h1><i class="fas fa-cart-arrow-down" style="<?php echo $i_principal ?>"></i> <STRONG>LISTADO DE PRODUCTOS</STRONG></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Productos</li>
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
       <button class="btn btn-primary" data-toggle="modal" data-target="#ModalADDProductos"><i class="fas fa-plus"></i>Agregar</button>       


     </div>
   </div>
   <div class="card-body">

     <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr style="<?php echo $color_tabla ?>">
          <th><strong>ID</strong></th>
          <th><strong>IMAGEN</strong></th>
          <th><strong>CÓDIGO</strong></th>
          <th><strong>NOMBRE PRODUCTO</strong></th>
          <th><strong>PRECIO VENTA</strong></th>
          <th><strong>CATEGORÍA</strong></th>
          <th><strong>STOCK</strong></th>
          <th><strong>TIPO</strong></th>
          <th><strong>IMPUESTO</strong></th>
          <th><strong>ACCIÓN</strong></th>
        </tr>
      </thead>
      <tbody>


        <?php 
        $parametro= null;
        $datos= "SELECT c.descripcion as categoria,p.*,t.descripcion as tipo, u.simbolo, i.descripcion as impuesto
        FROM productos p, categorias_productos c,tipos_productos t, unidades_medidas u , impuestos i
        WHERE p.id_categoria=c.id_categoria_producto and p.id_tipo_producto=t.id_tipo_producto and u.id_unidad_medida=p.id_unidad_medida and p.id_impuesto=i.id_impuesto and p.disponible=1";
        $productos = ControlProductos::mostrarProducto($parametro,$datos);
        foreach ($productos as $key => $value) {
        
        $stock= "select  s.cantidad stock from stock s where s.id_producto=".$value['id_producto']."";
        $cantidad = ControlProductos::mostrarProducto($parametro,$stock);
        $cantidad_stock=0;
        foreach ($cantidad as $key => $values) {
          $cantidad_stock=$values['stock'];
        }


          $foto='vistas/recursos/dist/img/productos/'.$value['foto'];
          echo '<tr>
          <td style="width: 1%">'.$value['id_producto'].' </td>
          <td style="width: 4%"><img class="table-avatar" alt="Avatar" src="'.$foto.'" alt="'.$value['foto'].'  width="80" height="70""></td>         
          <td style="width: 12%">'.$value['codigo'].' </td>
          <td style="width: 15%">'.$value['nombre'].'</td>
          <td style="width: 8%">'.$value['precio_venta'].' '.$value['simbolo'].'</td>
          <td style="width: 10%">'.$value['categoria'].'</td>          
          <td style="width: 10%">'.$cantidad_stock.'</td>          
          <td style="width: 8%">'.$value['tipo'].'</td>
          <td style="width: 8%">'.$value['impuesto'].'</td>
          <td style="width: 12%">
          <div class="btn-bt-group"></div> 
          <button class="btn btn-default btnEditarProducto" idProducto="'.$value['id_producto'].'" data-toggle="modal" data-target="#ModalEditarProductos" style="'.$botton_editar.'"><i class="far fa-edit"></i></button>
          <button class="btn btn-default btnEliminarProducto" idProducto="'.$value['id_producto'].'" style="'.$botton_eliminar.'"><i  class="fas fa-trash"></i></button>
          </td>
          </tr>   ';
          
        }

        ?>
      </tbody>

      </table>

<?php 
define('NUM_ITEMS_BY_PAGE', 6);
$cantidad_row="SELECT COUNT(*) cantidad FROM productos p, categorias_productos c,tipos_productos t, unidades_medidas u , impuestos i WHERE p.id_categoria=c.id_categoria_producto and p.id_tipo_producto=t.id_tipo_producto and u.id_unidad_medida=p.id_unidad_medida and p.id_impuesto=i.id_impuesto and p.disponible=1 ";
        $cant_registros = ControlProductos::cantidadRegistros($cantidad_row);
         foreach ($cant_registros as $key => $value) {
        //printf("Result set has %d rows.\n", $value['cantidad']);
      }
?>
<!---<div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1. <?php echo $value['cantidad'] ?></a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
              </div> -->

    </div>

    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->






<!-- The Modal Add Productos -->
<div class="modal" id="ModalADDProductos" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
          <!-- Modal Header -->
          <div class="modal-header" style="<?php echo $color_header?>">
            <h4 class="modal-title">NUEVO PRODUCTO</h4>           
          </div>

                <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">


                      <div class="photo">  
                        <div class="prevPhoto">
                          <span class="delPhoto notBlock">X</span>
                          <label for="foto"></label>
                        </div>
                      <div class="upimg">
                          <input  type="file" name="foto" id="foto">
                          <input type="hidden" name="MAX_FILE_SIZE" value="30000" />              
                      </div>
                        <div id="form_alert"></div>
                      </div>


                      <div class="col-md-5" >
                        <label for="inputCodigo">Código de Producto:</label>
                        <input type="text" id="inputCodigo" name="inputCodigo"  class="form-control"  required>
                      </div>

                      <div class="row">
                        <div class="col-md-6 ">
                          <label for="inputNombre">Producto:</label>
                          <input type="text"  id="inputNombre" name="inputNombre" class="form-control" required>
                        </div> 
                      </div> 


                      <div class="row">
                        <div class="col-md-4 ">
                            <label for="inputMinimo">Cantidad Minima:</label>
                            <input type="text"  id="inputMinimo" name="inputMinimo" class="form-control" required>
                          </div> 
                      </div> 

                      <div class="row">  
                        <div class="col-md-4">
                          <label for="inputPVenta">Precio de Venta:</label>
                          <input type="text" id="inputPVenta" name="inputPVenta" class="form-control" required>
                        </div> 

                        <div class="col-md-4">
                          <label for="inputPCompra">I.V.A de Venta:</label>
                            <select id="inputIVAVenta" name="inputIVAVenta" class="form-control custom-select">
                              <option  selected disabled>Select one</option>
                                <?php
                                $db = new BaseDatos();                                                           
                                if($resultado=$db->buscar("impuestos","1")){
                                  foreach($resultado as $row) { ?>
                              <option value=<?=$row['id_impuesto'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>                                        
                            </select>    
                          </div> 
                        </div>


                        <div class="row"> 

                          <div class="form-group col-md-3">
                            <label for="inputStatus">Categoría:</label>
                            <select id="inputCategoria" name="inputCategoria" class="form-control custom-select">
                              <option  selected disabled>Select one</option>
                              <?php
                              $db = new BaseDatos();   
                              if($resultado=$db->buscar("categorias_productos","1")){
                                foreach($resultado as $row) { ?>
                                <option value=<?=$row['id_categoria_producto'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>                                        
                              </select>                
                            </div>

                            <div class="form-group col-md-3">
                              <label for="inputStatus">Marca:</label>
                              <select id="input_id_marca" name="inputId_marca" class="form-control custom-select">
                                <option selected disabled>Select one</option> 
                                <?php
                                $db = new BaseDatos();                                                         
                                if($resultado=$db->buscar("marcas","1")){
                                  foreach($resultado as $row) { ?>
                                  <option value=<?=$row['id_marca'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>                             
                                </select>                
                              </div>


                              <div class="imput-group col-md-3">
                                <label for="inputStatus">Tipo Producto:</label>
                                <select id="input_tipo_producto" name="inputTipo_producto" class="form-control custom-select">
                                  <option selected disabled>Select one</option>                
                                  <?php
                                  $db = new BaseDatos();       
                                  if($resultado=$db->buscar("tipos_productos","1")){
                                    foreach($resultado as $row) { ?>
                                    <option value=<?=$row['id_tipo_producto'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>                             
                                  </select>                
                                </div>
                              </div>    

                                  <div class="row">                             
                                        <div class="form-group col-md-3">
                                        <label for="inputStatus">Unidad de medida:</label>
                                        <select id="inputUnidad" name="inputUnidad" class="form-control custom-select">
                                        <option selected disabled>Select one</option>                
                                        <?php
                                        $db = new BaseDatos();        

                                        if($resultado=$db->buscar("unidades_medidas","1")){
                                          foreach($resultado as $row) { ?>
                                          <option value=<?=$row['id_unidad_medida'] ?> ><?=$row['nombre'] ?></option> <?php } } ?>                                    
                                        </select> 
                                    </div>   


                                  <div class="form-group col-md-3">
                                    <label for="inputStatus">Inventariable:</label>
                                    <select id="inputInve" name="inputInve" class="form-control custom-select">
                                      <option selected disabled>Select one</option>                
                                      <option value=1>SI</option>
                                      <option value=0>NO</option>
                                    </select>
                                  </div>

                                  <div class="form-group col-md-3">
                                    <label for="inputStatus">Disponible:</label>
                                    <select id="inputDispo" name="inputDispo" class="form-control custom-select">
                                      <option selected disabled>Select one</option>         
                                      <option value=1>SI</option>
                                      <option value=0>NO</option>
                                    </select>
                                  </div>  


                                  <div class="form-group col-md-3">
                                    <label for="inputStatus">Moneda:</label>
                                    <select id="inputMoneda" name="inputMoneda" class="form-control custom-select">
                                      <option selected disabled>Select one</option>                
                                      <?php
                                      $db = new BaseDatos();        
                                      if($resultado=$db->buscar("monedas","1")){
                                        foreach($resultado as $row) { ?>
                                        <option value=<?=$row['id_moneda'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>                                    
                                      </select> 
                                    </div>  

                                  </div> 



                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit"  class="btn btn-primary" href="javascript:;" onclick="agregarProductos(); return false"  >Guardar</button>
                              </div>

                             
                </div>
              </div>
                    
         
         <!---OK-->
      </form>
    
    </div>
  
  </div>

</div>



<div class="modal" id="ModalEditarProductos" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>">
          <h4 class="modal-title"><strong>MODIFICAR PRODUCTO</strong></h4>          
        </div>

        <!-- Modal body -->
         <div class="modal-body">
            <div class="box-body">

            <div class="photo">  
                        <div class="prevPhoto">
                          <span class="delPhoto notBlock">X</span>
                          <label for="foto"></label>
                        </div>
                      <div class="upimg">
                          <input  type="file" name="foto" id="foto">
                          <input type="hidden" name="MAX_FILE_SIZE" value="30000" />              
                      </div>
                        <div id="form_alert"></div>
                      </div>
               
                      <input type="hidden" id="idProducto" name="idProducto" value="">

                      <div class="col-md-5" >
                        <label for="inputCodigo">Código de Producto:</label>
                        <input type="text" id="inputCodigoEdit" name="inputCodigoEdit"  class="form-control"  required>
                      </div>

                      <div class="row">
                        <div class="col-md-6 ">
                          <label for="inputNombre">Producto:</label>
                          <input type="text"  id="inputNombreEdit" name="inputNombreEdit" class="form-control" required>
                        </div> 
                      </div> 


                      <div class="row">
                        <div class="col-md-4 ">
                            <label for="inputMinimo">Cantidad Minima:</label>
                            <input type="text"  id="inputMinimoEdit" name="inputMinimoEdit" class="form-control" required>
                          </div> 
                      </div> 

                      <div class="row">  
                        <div class="col-md-4">
                          <label for="inputPVenta">Precio de Venta:</label>
                          <input type="text" id="inputPVentaEdit" name="inputPVentaEdit" class="form-control" required>
                        </div> 

                        <div class="col-md-4">
                          <label for="inputPCompra">I.V.A de Venta:</label>
                            <select id="inputIVAVentaEdit" name="inputIVAVentaEdit" class="form-control custom-select">
                              <option  selected disabled>Select one</option>
                                <?php
                                $db = new BaseDatos();
                                 if($resultado=$db->buscar("impuestos","1")){
                                  foreach($resultado as $row) { ?>
                              <option id="opcionIVAVentaEdit" value=<?=$row['id_impuesto'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>                                        
                            </select>    
                          </div> 
                        </div>


                        <div class="row"> 

                          <div class="form-group col-md-3">
                            <label for="inputStatus">Categoría:</label>
                            <select id="inputCategoriaEdit" name="inputCategoriaEdit" class="form-control custom-select">
                              <option  selected disabled>Select one</option>
                              <?php
                              $db = new BaseDatos();       
                               if($resultado=$db->buscar("categorias_productos","1")){
                                foreach($resultado as $row) { ?>
                                <option value=<?=$row['id_categoria_producto'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>                                        
                              </select>                
                            </div>

                            <div class="form-group col-md-3">
                              <label for="inputStatus">Marca:</label>
                              <select id="input_id_marcaEdit" name="inputId_marcaEdit" class="form-control custom-select">
                                <option selected disabled>Select one</option> 
                                <?php
                                $db = new BaseDatos();        
                                if($resultado=$db->buscar("marcas","1")){
                                  foreach($resultado as $row) { ?>
                                  <option value=<?=$row['id_marca'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>                             
                                </select>                
                              </div>


                              <div class="imput-group col-md-3">
                                <label for="inputStatus">Tipo Producto:</label>
                                <select id="input_tipo_productoEdit" name="inputTipo_productoEdit" class="form-control custom-select">
                                  <option selected disabled>Select one</option>                
                                  <?php
                                  $db = new BaseDatos();                         
                                  if($resultado=$db->buscar("tipos_productos","1")){
                                    foreach($resultado as $row) { ?>
                                    <option value=<?=$row['id_tipo_producto'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>                             
                                  </select>                
                                </div>
                              </div>    

                                  <div class="row">                             
                                        <div class="form-group col-md-3">
                                        <label for="inputStatus">Unidad de medida:</label>
                                        <select id="inputUnidadEdit" name="inputUnidadEdit" class="form-control custom-select">
                                        <option selected disabled>Select one</option>                
                                        <?php
                                        $db = new BaseDatos();       
                                          if($resultado=$db->buscar("unidades_medidas","1")){
                                          foreach($resultado as $row) { ?>
                                          <option value=<?=$row['id_unidad_medida'] ?> ><?=$row['nombre'] ?></option> <?php } } ?>                                    
                                        </select> 
                                    </div>   


                                  <div class="form-group col-md-3">
                                    <label for="inputStatus">Inventariable:</label>
                                    <select id="inputInveEdit" name="inputInveEdit" class="form-control custom-select">
                                      <option selected disabled>Select one</option>                
                                      <option value=1>SI</option>
                                      <option value=0>NO</option>
                                    </select>
                                  </div>

                                  <div class="form-group col-md-3">
                                    <label for="inputStatus">Disponible:</label>
                                    <select id="inputDispoEdit" name="inputDispoEdit" class="form-control custom-select">
                                      <option selected disabled>Select one</option>         
                                      <option value=1>SI</option>
                                      <option value=0>NO</option>
                                    </select>
                                  </div>  


                                  <div class="form-group col-md-3">
                                    <label for="inputStatus">Moneda:</label>
                                    <select id="inputMonedaEdit" name="inputMonedaEdit" class="form-control custom-select">
                                      <option selected disabled>Select one</option>                
                                      <?php
                                      $db = new BaseDatos();                
                                      if($resultado=$db->buscar("monedas","1")){
                                        foreach($resultado as $row) { ?>
                                        <option value=<?=$row['id_moneda'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>                                    
                                      </select> 
                                    </div>  

                                  </div> 
                

                

                         <!-- Modal footer -->
                         <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                          <button type="submit"  class="btn btn-success" href="javascript:;"  onclick="updateProducto(); return false" >Guardar</button>
                        </div>

                      
            </div>
          </div>
                    
      </form>
    </div>
  </div>

</div>




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