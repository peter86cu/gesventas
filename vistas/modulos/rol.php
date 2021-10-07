<!-- Content Wrapper. Contains page content -->
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
      $resultado=$db->buscarSQL("select DISTINCT r.id_rol,r.id_modulo,r.id_nivel,m.nombre FROM  roles_modulos_niveles r inner join roles_modulos rm on (rm.id_modulo=r.id_modulo) inner join modulos m on (r.id_modulo=m.id_modulo) where estado =1 and r.id_rol=".$_SESSION['rol']." and m.id_modulo=2");
        foreach($resultado as $row) { 
        $niveles[] = $row['id_nivel']; 
        
      }

 ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-user-lock" style="<?php echo $i_principal ?>"></i>   <strong>ROLES DE ACCESO</strong></h1>
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
     <?php if(in_array(2, $niveles)) { ?>  <button class="btn btn-primary" style="<?php echo $botton_principal ?>" data-toggle="modal" data-target="#ModalADDRoles"><i class="fas fa-plus"></i>Agregar</button>  <?php } ?>     


     </div>
   </div>
   <div class="card-body">

     <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr style="<?php echo $color_tabla ?>">
          <th style="width: 3%">ID</th>
          <th style="width: 15%"><strong>NOMBRE</strong></th>
          <th style="width: 20%"><strong>DESCRIPCIÓN</strong></th>
          <th style="width: 20%"><strong>MODULOS DE ACCESO</strong></th>
          <th style="width: 10%"><strong>ESTADO</strong></th>  
        <?php if(in_array(3, $niveles) || in_array(4, $niveles)) { ?>  <th style="width: 10%"><strong>ACCIÓN</strong></th> <?php } ?>      
        </tr>
      </thead>
      <tbody>


        <?php 
        $activo="";
        $parametro= null;
        $palote= " | ";
        $datos= "SELECT * FROM `rol` WHERE  1";
        $productos = ControlRoles::mostrarRoles($parametro,$datos);
         foreach ($productos as $key => $value) {
          $listado="";
          $parametro= null;
        $modulos= "SELECT m.nombre FROM modulos m INNER JOIN  roles_modulos rm ON(rm.id_modulo=m.id_modulo) WHERE rm.id_rol=".$value['id_rol']."";
        $result = ControlRoles::mostrarRoles($parametro,$modulos);
          foreach ($result as $key => $values) {
              $listado=$listado.$values['nombre'].$palote;
          }

          ?>         
          <tr>
          <td><?php echo $value['id_rol'] ?></td>                  
          <td><?php echo $value['rol'] ?></td>
          <td><?php echo $value['descripcion']?></td> 
          <td><?php echo $listado; ?></td> 
          <td>
          <?php if($value['estado']==1) { ?>         
          <span class="badge badge-success">Activo</span> <?php $activo=""; }else { ?> 
          <span class="badge badge-danger">Desactivo</span> <?php $activo="disabled"; } ?>
        </td>

         <?php if(in_array(3, $niveles) || in_array(4, $niveles)) { ?> <td>
          <div class="btn-bt-group"></div> 
         <?php if(in_array(3, $niveles)) { ?> <button class="btn btn-default btnEditarRol" idRol="<?php echo $value['id_rol'] ?>" style="<?php echo $botton_editar ?>" data-toggle="modal" data-target="#ModalEditarRoles"><i class="far fa-edit"></i></button> <?php } ?>
         <?php if(in_array(4, $niveles)) { ?> <button class="btn btn-default btnEliminarRol" <?php echo $activo ?> idRol="<?php echo $value['id_rol'] ?>" style="<?php echo $botton_eliminar ?>"><i  class="fas fa-trash"></i></button> <?php } ?>
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


<style type="text/css">
  
  .modal-dialog.modal-800 {
    width: 1000px;
    margin: 30px auto;
}

</style>



<!-- The Modal Add Productos -->
<div class="modal fade" id="ModalADDRoles" role="dialog" aria-labelledby="" aria-hidden="true" >
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document" >
    <div class="modal-content" style="width:1200px;">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>">
          <h4 class="modal-title"><strong>NUEVO ROL</strong></h4>
         </div>

        <!-- Modal body -->
        <div class="modal-body" style="width:1080px;">
         <div class="box-body"  >

          
              <label for="txt_Nombre">Nombre:</label>
              <input  type="text" id="txt_Nombre" name="txt_Nombre"  class="form-control" placeholder="Nombre del rol" required>
            
              <label for="txt_descripcion">Descripción:</label>
              <textarea  type="text"  id="txt_descripcion" name="txt_descripcion" class="form-control" rows="2" placeholder="Descripcion del rol" required></textarea>
          
           
               <div class="card-body" >
               
                  <table width="100%" border="2" id="example1" class="table table-bordered table-striped" >
                           <?php 
                $parametro= null;
                $datos= "SELECT * FROM `modulos` WHERE  estado=1";
                $modulos = ControlRoles::mostrarModulos($parametro,$datos);
                $pos=1;
                $cantidad_modulos=0;
                $cantidad_niveles=0;
                 foreach ($modulos as $key => $value) { 
                  $cantidad_modulos++;
                  ?>  
                 
                            <tr >  
                              <td align="float-right"  >
                                  <input align="left" type="hidden" id="idModulo_<?=$value['id_modulo']?>" name="idModulo" value="<?=$value['id_modulo']?>">
                                  <input align="left" id="modulo_<?=$value['id_modulo']?>" class="form-check-input" type="checkbox" onclick="check(<?=$value['id_modulo'] ?>)">
                                  <label align="left"  class="form-check-label"><?php echo $value['nombre'] ?></label>
                             </td>
                             
                           
                             <?php 
                             $parametro= null;
                $datos= "SELECT * FROM nivel_acceso WHERE  estado=1";
                $nivel = ControlRoles::mostrarModulos($parametro,$datos);
                 foreach ($nivel as $key => $value) {  $cantidad_niveles++;
                  ?> 

                  <td >
                                   <input type="hidden" id="idNivel_<?=$cantidad_niveles ?>" name="idNivel" value="<?=$value['id']?>">
                                   <input  class="nivel_<?=$pos ?>" id="niveles_<?=$cantidad_niveles ?>_<?=$pos ?>"  class="form-check-input" type="checkbox" disabled>
                                   <label  class="form-check-label"><?php echo $value['descripcion'] ?></label>
                                  </td>
                                   <?php  } ?> 
                                  
                            </tr>    
                                  
                                <?php $pos++; } ?> 
                      
        <input type="hidden"  id="rolSize" name="rolSize"  value="<?=$cantidad_modulos ?>" > 
        <input type="hidden"  id="nivelesSize" name="nivelesSize"  value="<?=$cantidad_niveles ?>" > 
                    
                      </table>          
              </div>
            

            
              <label for="select_estado">Estado:</label>
              <select id="select_estado" name="select_estado" class="form-control custom-select" required>
                <option selected disabled>Seleccción</option>         
                <option value=1>Activo</option>
                <option value=0>Desactivado</option>
              </select>
           



            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="submit"  class="btn btn-success" href="javascript:;" onclick="agregarRol(); return false"  >Guardar</button>
            </div>

            </div>
          
        </div>


        <!---OK-->
      </form>

    </div>

  </div>

</div>


<div class="modal" id="ModalEditarRoles" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="width:1200px;">

      <form role="form" method="POST" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header" style="<?php echo $color_header?>" >
          <h4 class="modal-title"><strong>EDITAR ROL</strong></h4>          
        </div>

        <!-- Modal body -->
        <div class="modal-body" style="width:1080px;">
         
                <input type="hidden" id="idRolE" name="idRol" value="">
           
              <div class="col-md-12">
                <label for="txt_NombreEdit">Nombre:</label>
                <input type="text" id="txt_NombreEdit" name="txt_NombreEdit"  class="form-control" placeholder="Nombre del rol" required>
              </div>

             
                <div class="col-md-12">
                  <label for="txt_descripcionEdit">Descripción:</label>
                  <textarea type="text"  id="txt_descripcionEdit" name="txt_descripcionEdit" class="form-control" rows="2" placeholder="Descripcion del rol" required></textarea>
                </div> 
              
               <div class="card-body" >
               
                  <table width="100%" border="2" id="k-table" class="table table-bordered table-striped" >
                   <tfoot id="result">       
                  
                                  
                  </tfoot>         
                      
        <input type="hidden"  id="rolSizeE" name="rolSize"  value="" > 
        <input type="hidden"  id="nivelesSizeE" name="nivelesSize"  value="" > 
                    
                      </table>          
              </div>

              <div class="col-md-12">
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
                <button type="submit"  class="btn btn-success" href="javascript:;"  onclick="updateRol(); return false">Guardar</button>
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