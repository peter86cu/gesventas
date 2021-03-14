<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-user-lock" style="color:#218838"></i>   Listado de Proveedores</h1>
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
       <button class="btn btn-primary" data-toggle="modal" data-target="#ModalADDProveedor"><i class="fas fa-plus"></i>Agregar</button>       


     </div>
   </div>
   <div class="card-body">

     <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width: 1%">Id</th>
          <th style="width: 15%">Razon Social</th>
          <th style="width: 10%">RUC</th>
          <th style="width: 15%">Dirección</th>  
          <th style="width: 8%">Teléfono</th>
          <th style="width: 8%">Celular</th>
          <th style="width: 10%">Email</th>
          <th style="width: 10%">Web</th>  
          <th style="width: 8%">Estado</th>           
          <th style="width: 10%">Acciones</th>         
        </tr>
      </thead>
      <tbody>


        <?php 
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
          <span class="badge badge-success">Activo</span> <?php }else { ?> 
          <span class="badge badge-danger">Inactivo</span> <?php } ?>
        </td>

          <td>
          <div class="btn-bt-group"></div> 
          <button class="btn btn-warning btnEditarRol" idRol="<?php echo $value['id_proveedor'] ?>" data-toggle="modal" data-target="#ModalEditarRoles"><i class="far fa-edit"></i></button>
          <button class="btn btn-danger btnEliminarRol" idRol="<?php echo $value['id_proveedor'] ?>"><i  class="fas fa-trash"></i></button>
          </td>
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
<div class="modal" id="ModalADDProveedor">
  <div class="modal-dialog ">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="background: #218838">
          <h4 class="modal-title">Agregar Proveedor</h4>         
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
              <button type="submit"  class="btn btn-primary" href="javascript:;" onclick="agregarProveedor(); return false"  >Guardar</button>
            </div>

            
         
        </div>


        <!---OK-->
      </form>

    </div>

  </div>

</div>


<div class="modal" id="ModalEditarRoles">
  <div class="modal-dialog ">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="background: #ffc107">
          <h4 class="modal-title">Agregar nuevo rol</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="box-body">

                <input type="hidden" id="idRol" name="idRol" value="">
           
              <div class="col-md-6" >
                <label for="txt_NombreEdit">Nombre:</label>
                <input type="text" id="txt_NombreEdit" name="txt_NombreEdit"  class="form-control" placeholder="Nombre del rol" required>
              </div>

             
                <div class="col-md-6 ">
                  <label for="txt_descripcionEdit">Descripción:</label>
                  <textarea type="text"  id="txt_descripcionEdit" name="txt_descripcionEdit" class="form-control" rows="2" placeholder="Descripcion del rol" required></textarea>
                </div> 
              

              <div class="col-md-6">
                <label for="select_estadoEdit">Estado:</label>
                <select id="select_estadoEdit" name="select_estadoEdit" class="form-control custom-select" required>
                  <option selected disabled>Seleccción</option>         
                  <option value=1>Activo</option>
                  <option value=0>Desactivado</option>
                </select>
              </div>  



              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit"  class="btn btn-primary" href="javascript:;"  onclick="updateRol(); return false">Guardar</button>
              </div>

            
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