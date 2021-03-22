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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
         <h1> <i class="fas fa-users-cog" style="<?php echo $i_principal ?>"></i> <strong>LISTA DE USUARIOS</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Usuarios</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
     <div class="card">
      <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#ModalADDUsuarios"><i class="fas fa-plus"></i> Agregar</button>       


      </div>
    </div>
    <div class="card-body">

       <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr style="<?php echo $color_tabla ?>">
          <th style="width: 1%"><strong>ID</strong></th>
          <th style="width: 5%"><strong>USUARIO</strong></th>
          <th style="width: 10%"><strong>NOMBRE</strong></th>
          <th style="width: 10%"><strong>ROL</strong></th> 
          <th style="width: 5%"><strong>SUCURSAL</strong></th> 
          <th style="width: 5%"><strong>ESTADO</strong></th> 
          <th style="width: 5%"><strong>ACCIÓN</strong></th>         
        </tr>
      </thead>
      <tbody>


        <?php 
        $parametro= null;
        $datos= "SELECT u.id_usuario,u.usuario,u.nombres,u.email,u.estado,r.descripcion as rol,s.descripcion as sucursal FROM usuarios u, rol r, sucursales s WHERE  u.nivel = r.id_rol and u.sucursal= s.id_sucursal";
        $usuarios = ControlUsuario::mostrarUsuario($parametro,$datos);
         foreach ($usuarios as $key => $value) { ?>         
          <tr>
          <td><?php echo $value['id_usuario'] ?></td>                  
          <td><?php echo $value['usuario'] ?></td>
          <td><?php echo $value['nombres']?></td> 
          <td><?php echo $value['rol']?></td> 
          <td><?php echo $value['sucursal']?></td> 
          <td>
          <?php if($value['estado']==1) { ?>         
          <span class="badge badge-success">Activo</span> <?php }else { ?> 
          <span class="badge badge-danger">Desactivo</span> <?php } ?>
        </td>

          <td>
          <div class="btn-bt-group"></div> 
          <button class="btn btn-default btnEditarUsuario" idUsuario="<?=$value['id_usuario'] ?>" data-toggle="modal" data-target="#ModalEditarUsuario" style="<?php echo $botton_editar ?>"><i class="far fa-edit"></i></button>
          <button class="btn btn-default btnEliminarUsuario" style="<?php echo $botton_eliminar ?>" idUsuario="<?=$value['id_usuario'] ?>"><i  class="fas fa-trash"></i></button>
          </td>
          </tr> 
       <?php  }

        ?>

      </table>



    </div>

    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<!-- The Modal Add usuarios -->

<div class="modal" id="ModalADDUsuarios">
  <div class="modal-dialog ">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>">
          <h4 class="modal-title"><strong>NUEVO USUARIO</strong></h4>          
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="box-body">


            <div class="form-group">
              <label for="txt_nombre">Nombre y Apellidos</label>
              <input type="text" class="form-control" id="txt_nombre" placeholder="Nombre y Apellidos" required>
            </div> 

            <div class="form-group">
              <label for="txt_user">Usuario</label>
              <input type="text" class="form-control" id="txt_user" placeholder="usuario" required>
            </div> 

            <div class="form-group">
              <label for="txt_pass">Password</label>
              <input type="password" class="form-control" id="txt_pass" placeholder="Password" required>
            </div>
            
            <div class="form-group">
              <label for="txt_mail">Email address</label>
              <input type="email" class="form-control" id="txt_mail" placeholder="Email">
            </div>
            
            <div class="row">
              <div class="col-md-6 ">
                <label for="txt_rol">Rol</label>
                <select id="txt_rol" name="txt_rol" class="form-control custom-select">
                  <option  selected disabled>Seleccione</option>
                  <?php
                  $db = new BaseDatos();                                                           
                  if($resultado=$db->buscar("rol","estado=1")){
                    foreach($resultado as $row) { ?>
                      <option value=<?=$row['id_rol'] ?>><?=$row['rol'] ?></option> <?php } } ?>                                        
                    </select>    
                  </div> 

                  <div class="col-md-6 ">
                    <label for="txt_sucursal">Sucursal</label>
                    <select id="txt_sucursal" name="txt_sucursal" class="form-control custom-select">
                      <option  selected disabled>Seleccione</option>
                      <?php
                      $db = new BaseDatos();                                                           
                      if($resultado=$db->buscar("sucursales","1")){
                        foreach($resultado as $row) { ?>
                          <option value=<?=$row['id_sucursal'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>                                        
                        </select>    
                      </div> 
                    </div>
           


            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-success" href="javascript:;" onclick="agregarUsuario(); return false"  >Guardar</button>
            </div>

            
          </div>
        </div>


        <!---OK-->
      </form>

    </div>

  </div>

</div>



<!-- The Modal Editar usuarios -->
<div class="modal" id="ModalEditarUsuario">
  <div class="modal-dialog ">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>">
          <h4 class="modal-title"><strong>EDITAR USUARIO</strong></h4>          
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="box-body">

            <input type="hidden" id="idUsuario" name="idUsuario" value="">

            <div class="form-group">
              <label for="txt_nombreE">Nombre y Apellidos</label>
              <input type="text" class="form-control" id="txt_nombreE" placeholder="Nombre y Apellidos" required>
            </div> 

            <div class="form-group">
              <label for="txt_user">Usuario</label>
              <input type="text" class="form-control" id="txt_userE" placeholder="usuario" required>
            </div> 

            <div class="form-group">
              <label for="txt_pass">Password</label>
              <input type="password" class="form-control" id="txt_passE" placeholder="Password" required>
            </div>
            
            <div class="form-group">
              <label for="txt_mail">Email address</label>
              <input type="email" class="form-control" id="txt_mailE" placeholder="Email">
            </div>
            
            <div class="row">
              <div class="col-md-6 ">
                <label for="txt_rolE">Rol</label>
                <select id="txt_rolE" name="txt_rolE" class="form-control custom-select">
                  <option  selected disabled>Seleccione</option>
                  <?php
                  $db = new BaseDatos();                                                           
                  if($resultado=$db->buscar("rol","estado=1")){
                    foreach($resultado as $row) { ?>
                      <option value=<?=$row['id_rol'] ?>><?=$row['rol'] ?></option> <?php } } ?>                                        
                    </select>    
                  </div> 

                  <div class="col-md-6 ">
                    <label for="txt_sucursal">Sucursal</label>
                    <select id="txt_sucursalE" name="txt_sucursalE" class="form-control custom-select">
                      <option  selected disabled>Seleccione</option>
                      <?php
                      $db = new BaseDatos();                                                           
                      if($resultado=$db->buscar("sucursales","1")){
                        foreach($resultado as $row) { ?>
                          <option value=<?=$row['id_sucursal'] ?>><?=$row['descripcion'] ?></option> <?php } } ?>                                        
                        </select>    
                      </div> 
                    </div>
           


            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="submit"  class="btn btn-success" href="javascript:;"  onclick="updateUsuario(); return false" >Guardar</button>
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