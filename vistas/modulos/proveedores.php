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
      $resultado=$db->buscarSQL("select DISTINCT r.id_rol,r.id_modulo,r.id_nivel,m.nombre FROM  roles_modulos_niveles r inner join roles_modulos rm on (rm.id_modulo=r.id_modulo) inner join modulos m on (r.id_modulo=m.id_modulo) where estado =1 and r.id_rol=".$_SESSION['rol']." and m.id_modulo=5");
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
          <h1><i class="fas fa-user-lock" style="<?php echo $i_principal ?>"></i>   <strong>LISTADO DE PROVEEDORES</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Proveedores</li>
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
      <?php if(in_array(2, $niveles)) { ?>   <button class="btn btn-primary" data-toggle="modal" data-target="#ModalADDProveedor"><i class="fas fa-plus"></i>Agregar</button>   <?php } ?>      


     </div>
   </div>
   <div class="card-body">

     <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr style="<?php echo $color_tabla ?>">
          <th style="width: 1%"><strong>ID</strong></th>
          <th style="width: 15%"><strong>RAZON SOCIAL</strong></th>
          <th style="width: 10%"><strong>RUC</strong></th>
          <th style="width: 15%"><strong>DIRECCIÓN</strong></th>  
          <th style="width: 8%"><strong>TELÉFONO</strong></th>
          <th style="width: 8%"><strong>CELULAR</strong></th>
          <th style="width: 10%"><strong>EMAIL</strong></th>
          <th style="width: 10%"><strong>WEB</strong></th>  
          <th style="width: 8%"><strong>ESTADO</strong></th>           
         <?php if(in_array(3, $niveles) || in_array(4, $niveles)) { ?>   <th style="width: 10%"><strong>ACCIÓN</strong></th>   <?php } ?>       
        </tr>
      </thead>
      <tbody>


        <?php 
        $activo="";
        $parametro= null;
        $datos= "SELECT * FROM `proveedores` WHERE  1";
        $proveedores = ControlProveedor::mostrarProveedores($parametro,$datos);
         foreach ($proveedores as $key => $value) { ?>         
          <tr>
          <td><?php echo $value['id_proveedor'] ?></td>                  
          <td><?php echo $value['razon_social'] ?></td>
          <td><?php echo $value['ruc']?></td> 
          <td><?php echo $value['direccion']?></td>
          <td><?php echo $value['telefono']?></td> 
          <td><?php echo $value['celular']?></td> 
          <td><?php echo $value['email']?></td>
          <td><?php echo $value['web']?></td>          
          <td>
          <?php if($value['fecha_baja']==null) { ?>         
          <span class="badge badge-success">Activo</span> <?php  }else { ?> 
          <span class="badge badge-danger">Inactivo</span> <?php $activo="disabled";} ?>
        </td>

         <?php if(in_array(3, $niveles) || in_array(4, $niveles)) { ?>  <td>
          <div class="btn-bt-group"></div> 
          <?php if(in_array(3, $niveles)) { ?> <button class="btn btn-default btnEditarProveedor" idProveedor="<?php echo $value['id_proveedor'] ?>" style="<?php echo $botton_editar ?>" data-toggle="modal" data-target="#ModalEditarProveedor"><i class="far fa-edit"></i></button> <?php } ?>
          <?php if(in_array(4, $niveles)) { ?> <button class="btn btn-default btnEliminarProveedor" <?php echo $activo ?> style="<?php echo $botton_eliminar ?>" idProveedor="<?php echo $value['id_proveedor'] ?>"><i  class="fas fa-trash"></i></button> <?php } ?>
          </td> <?php } ?>
          </tr> 
       <?php  }

        ?>

      </table>



    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->






<!-- The Modal Add Productos -->
<div class="modal" id="ModalADDProveedor" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog ">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>">
          <h4 class="modal-title"><strong>NUEVO PROVEEDOR</strong></h4>         
        </div>

        <!-- Modal body -->
        <div class="modal-body">
       
            <div class="col-md-10" >
              <label for="txt_razon_social">Razón Social:</label>
              <input type="text" id="txt_razon_social" name="txt_razon_social"  class="form-control" placeholder="Razon Social" required>
            </div>


            <div class="col-md-10 ">
              <label for="txt_ruc">RUC:</label>
              <input type="text"  id="txt_ruc" name="txt_ruc" class="form-control"  placeholder="RUC" required></input>
            </div> 

             <div class="col-md-10 ">
              <label for="txt_direccion">Dirección:</label>
              <input type="text"  id="txt_direccion" name="txt_direccion" class="form-control"  placeholder="Dirección" required></input>
            </div> 

             <div class="col-md-10 ">
              <label for="txt_telefono">Teléfono:</label>
              <input type="text"  id="txt_telefono" name="txt_telefono" class="form-control"  placeholder="Teléfono" required></input>
            </div> 

            <div class="col-md-10 ">
              <label for="txt_celular">Celular:</label>
              <input type="text"  id="txt_celular" name="txt_celular" class="form-control"  placeholder="Celular" ></input>
            </div>

             <div class="col-md-10 ">
              <label for="txt_email">Email:</label>
              <input type="text"  id="txt_email" name="txt_email" class="form-control"  placeholder="Email" required></input>
            </div>

            <div class="col-md-10 ">
              <label for="txt_web">Web:</label>
              <input type="text"  id="txt_web" name="txt_web" class="form-control"  placeholder="Web" ></input>
            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="submit"  class="btn btn-success" href="javascript:;" onclick="agregarProveedor(); return false"  >Guardar</button>
            </div>

            
         
        </div>


        <!---OK-->
      </form>

    </div>

  </div>

</div>


<div class="modal" id="ModalEditarProveedor" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog ">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>">
          <h4 class="modal-title"><strong>EDITAR PROVEEDOR</strong></h4>         
        </div>
        <input type="hidden" id="idProveedor" name="idProveedor" value="">
        <!-- Modal body -->
        <div class="modal-body">
          <div class="col-md-10" >
              <label for="txt_razon_social">Razón Social:</label>
              <input type="text" id="txt_razon_socialE" name="txt_razon_social"  class="form-control" placeholder="Razon Social" required>
            </div>


            <div class="col-md-10 ">
              <label for="txt_ruc">RUC:</label>
              <input type="text"  id="txt_rucE" name="txt_ruc" class="form-control"  placeholder="RUC" required></input>
            </div> 

             <div class="col-md-10 ">
              <label for="txt_direccion">Dirección:</label>
              <input type="text"  id="txt_direccionE" name="txt_direccion" class="form-control"  placeholder="Dirección" required></input>
            </div> 

             <div class="col-md-10 ">
              <label for="txt_telefono">Teléfono:</label>
              <input type="text"  id="txt_telefonoE" name="txt_telefono" class="form-control"  placeholder="Teléfono" required></input>
            </div> 

            <div class="col-md-10 ">
              <label for="txt_celular">Celular:</label>
              <input type="text"  id="txt_celularE" name="txt_celular" class="form-control"  placeholder="Celular" ></input>
            </div>

             <div class="col-md-10 ">
              <label for="txt_email">Email:</label>
              <input type="text"  id="txt_emailE" name="txt_email" class="form-control"  placeholder="Email" required></input>
            </div>

            <div class="col-md-10 ">
              <label for="txt_web">Web:</label>
              <input type="text"  id="txt_webE" name="txt_web" class="form-control"  placeholder="Web" ></input>
            </div>

           
                                <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="customSwitch1" >
                      <label class="custom-control-label" for="customSwitch1">Habilitado</label>
                    </div>
                  </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="submit"  class="btn btn-success" href="javascript:;" onclick="updateProveedorJS(); return false"  >Guardar</button>
            </div>

            
          
        </div>


        <!---OK-->
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