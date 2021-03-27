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
          <h1><i class="fas fa-user-lock" style="<?php echo $i_principal ?>"></i>   <strong><?php echo $_SESSION['id_reporte'] ?></strong></h1>
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
       <button class="btn btn-primary" data-toggle="modal" data-target="#ModalADDProveedor"><i class="fas fa-plus"></i>Exportar</button>       


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
          <th style="width: 10%"><strong>ACCIÓN</strong></th>         
        </tr>
      </thead>
      <tbody>


        <?php 
        $parametro= null;
        $datos= "select s.id_sucursal,p.id_producto,p.codigo,p.nombre,s.costo_contable,s.cantidad from stock s, productos p where p.id_producto=s.id_producto and p.inventariable=true";
        $proveedores = ControlReportes::buscasReportes($parametro,$datos);
         foreach ($proveedores as $key => $value) { error_log($value['nombre']);  ?>         
          <tr>
          <td><?php echo $value['id_sucursal'] ?></td>                  
          <td><?php echo $value['id_producto'] ?></td>
          <td><?php echo $value['codigo']?></td> 
          <td><?php echo $value['nombre']?></td>
          <td><?php echo $value['costo_contable']?></td> 
          <td><?php echo $value['cantidad']?></td> 
          <td>X</td>
          <td>X</td>          
         

          <td>
          <div class="btn-bt-group"></div> 
          <button class="btn btn-default btnEditarProveedor" idProveedor="<?php echo $value['id_producto'] ?>" style="<?php echo $botton_editar ?>" data-toggle="modal" data-target="#ModalEditarProveedor"><i class="far fa-edit"></i></button>
          <button class="btn btn-default btnEliminarProveedor" style="<?php echo $botton_eliminar ?>" idProveedor="<?php echo $value['id_producto'] ?>"><i  class="fas fa-trash"></i></button>
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

