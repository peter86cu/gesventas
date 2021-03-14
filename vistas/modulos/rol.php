<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-user-lock" style="color:#218838"></i>   Roles de acceso</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Roles</li>
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
       <button class="btn btn-primary" data-toggle="modal" data-target="#ModalADDRoles"><i class="fas fa-plus"></i>Agregar</button>       


     </div>
   </div>
   <div class="card-body">

     <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width: 1%">Id</th>
          <th style="width: 15%">Nombre</th>
          <th style="width: 20%">Descripción</th>
          <th style="width: 10%">Estado</th>  
          <th style="width: 10%">Acciones</th>         
        </tr>
      </thead>
      <tbody>


        <?php 
        $parametro= null;
        $datos= "SELECT * FROM `rol` WHERE  1";
        $productos = ControlRoles::mostrarRoles($parametro,$datos);
         foreach ($productos as $key => $value) { ?>         
          <tr>
          <td><?php echo $value['id_rol'] ?></td>                  
          <td><?php echo $value['rol'] ?></td>
          <td><?php echo $value['descripcion']?></td> 
          <td>
          <?php if($value['estado']==1) { ?>         
          <span class="badge badge-success">Activo</span> <?php }else { ?> 
          <span class="badge badge-danger">Desactivo</span> <?php } ?>
        </td>

          <td>
          <div class="btn-bt-group"></div> 
          <button class="btn btn-warning btnEditarRol" idRol="<?php echo $value['id_rol'] ?>" data-toggle="modal" data-target="#ModalEditarRoles"><i class="far fa-edit"></i></button>
          <button class="btn btn-danger btnEliminarRol" idRol="<?php echo $value['id_rol'] ?>"><i  class="fas fa-trash"></i></button>
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
<div class="modal" id="ModalADDRoles">
  <div class="modal-dialog ">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="background: #218838">
          <h4 class="modal-title">Agregar nuevo rol</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="box-body">



            <div class="col-md-6" >
              <label for="txt_Nombre">Nombre:</label>
              <input type="text" id="txt_Nombre" name="txt_Nombre"  class="form-control" placeholder="Nombre del rol" required>
            </div>


            <div class="col-md-6 ">
              <label for="txt_descripcion">Descripción:</label>
              <textarea type="text"  id="txt_descripcion" name="txt_descripcion" class="form-control" rows="2" placeholder="Descripcion del rol" required></textarea>
            </div> 


            <div class="col-md-6">
              <label for="select_estado">Estado:</label>
              <select id="select_estado" name="select_estado" class="form-control custom-select" required>
                <option selected disabled>Seleccción</option>         
                <option value=1>Activo</option>
                <option value=0>Desactivado</option>
              </select>
            </div>  



            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="submit"  class="btn btn-primary" href="javascript:;" onclick="agregarRol(); return false"  >Guardar</button>
            </div>

            
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