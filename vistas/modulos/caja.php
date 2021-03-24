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
          <h1><i class="fas fa-hand-holding-usd" style="<?php echo $i_principal ?>"></i> <strong>APERTURA DE CAJA</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Caja</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">    
       <input type="hidden" id="variable_sesion" value="<?php echo $_SESSION['loginCaja']; ?>"> 
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
       <button class="btn btn-primary" href="javascript:;" onclick="abrirCaja(<?php echo $_SESSION['id'] ?>); return false" ><i class="fas fa-plus"></i> Apertura y Cierre</button>

     </div>
   </div>
   <div class="card-body">

     <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr style="<?php echo $color_tabla ?>">
          <th style="text-align: center;"><strong># ARQUEO</strong></th>
          <th style="text-align: center;"><strong>FECHA</strong></th>
          <th style="text-align: center;"><strong># APERTURA</strong></th>
          <th style="text-align: center;"><strong>TURNO</strong></th>
          <th style="text-align: center;"><strong>CAJA</strong></th>
          <th style="text-align: center;"><strong>TIPO DE ARQUE</strong></th>
          <th style="text-align: center;"><strong>CAJERO</strong></th>
          <th style="text-align: center;"><strong>ESTADO</strong></th>
          <th style="width: 4%; text-align: center;"><strong>ACCIÓN</strong></th>
        </tr>
      </thead>
      <tbody>


        <?php

        if( $_SESSION['rol']==2 || $_SESSION['rol']==3  ) {
          $sql= "and a.id_usuario=".$_SESSION['id'];
        } else if($_SESSION['rol']==1){
          $sql= "";
        }
        $parametro= null;
        $datos= "SELECT ar.id_arqueo,
        a.id_apertura_cajero,
        a.hora_inicio as inicio,
        a.fecha_hora_cierre as fin,
        a.fecha_hora_cierre,
        u.nombres,
        s.descripcion as sucursal,
        ar.fecha_hora as fecha,ta.id_tipo_arqueo,ta.descripcion,ar.id_cuadre,a.id_caja,a.id_turno
        FROM usuarios u,aperturas_cajeros a,sucursales s, arqueos ar, tipo_arqueo ta
        WHERE u.id_usuario=ar.id_usuario and ar.fecha_baja is null and s.id_sucursal=ar.id_sucursal and ar.id_apertura_cajero=a.id_apertura_cajero
        and ta.id_tipo_arqueo= ar.id_estado_arqueo ".$sql." order by ar.id_arqueo DESC ";
        $ordenes = ControlApertura::mostrarAperturas($parametro,$datos);
        foreach ($ordenes as $key => $value) {
          if($value['id_tipo_arqueo']==1){
            $color = "naranja";
          }elseif($value['id_tipo_arqueo']==2){
            $color = "azul";
          }elseif($value['id_tipo_arqueo']==3){
            $color = "verde";
          }

           $parametro1=null;
          $cuadre="select descripcion as cuadre from tipo_cuadre_caja where id_cuadre =".$value['id_cuadre']."";
          $tipo_cuadre = ControlApertura::mostrarAperturas($parametro1,$cuadre);

          foreach ($tipo_cuadre as $key => $values) {
            $des_cuadre=$values['cuadre'];

          }

          if($value['id_cuadre']==1){
            $color_cuadre = "naranja";
          }elseif($value['id_cuadre']==2){
            $color_cuadre = "verde";
          }elseif($value['id_cuadre']==3){
            $color_cuadre = "rojo";
          }

          $parametro2=null;
          $sql_turno="select concat(tipo_turno  , '  ',descripcion) as turno from turnos where id_turno =".$value['id_turno']."";
          $tipo_cuadre = ControlApertura::mostrarAperturas($parametro2,$sql_turno);

          foreach ($tipo_cuadre as $key => $row) {
            $turno=$row['turno'];

          }

          $parametro3=null;
          $sql_caja="select  nombre from caja where id_caja=".$value['id_caja']."";

          $caja = ControlApertura::mostrarAperturas($parametro3,$sql_caja);

          foreach ($caja as $key => $rows) {
            $caja=$rows['nombre'];

          }

          ?>

          <tr>
            <td style="width: 3%;text-align: center;"><?php echo $value['id_arqueo'] ?></td>
            <td style="width: 10%;text-align: center;"><?php echo $value['fecha']?></td>
            <td style="width: 5% ; text-align: center;"><?php echo $value['id_apertura_cajero']?></td>
            <td style="width: 8%; text-align: center;"><?php echo $turno ?></td> 
            <td style="width: 5%; text-align: center;"><?php echo $caja ?></td>
            <td style="width: 8%; text-align: center;">
              <span class="text_<?php echo $color ?>" ><?php echo $value['descripcion']?></span>
            </td>
            <td style="width: 10%; text-align: center;"><?php echo $value['nombres']?></td>
           <td style="width: 8%; text-align: center;">
              <span class="text_<?php echo $color_cuadre ?>" ><?php echo $des_cuadre?></span>
            </td>


            <td style="text-align: center;" >
              <div class="btn-bt-group"></div>

                <button class="btn btn-success" style="color:#001f3f"  href="javascript:;"  onclick="datosImprimirArqueo(<?php echo $value['id_apertura_cajero'] ?>,<?php echo $value['id_arqueo'] ?>,<?php echo $value['id_tipo_arqueo'] ?>); return false" ><i class="fas fa-print" ></i></button>

            </td>
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


</style>





<form class="form-horizontal" name="apertura" id="apertura">
  <!-- Modal -->
  <div class="modal fade bs-example-modal-lg" id="modalInicioCaja" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">

        </div>
        <div class="modal-body">

          <div class="row">

            <div class="col-md-6">
              <label for="txtTurno">Turno</label>
              <select id="txtTurno" name="txtTurno" class="form-control custom-select">
                <option selected disabled>Seleccione</option>
                <?php
                $db = new BaseDatos();
                if($resultado=$db->buscar("turnos","estado=1")){
                  foreach($resultado as $row) { ?>
                    <option value=<?=$row['id_turno'] ?> ><?=$row['descripcion']."    ".$row['tipo_turno'] ?></option> <?php } } ?>
                  </select>

                </div>
                <div class="col-md-6">
                  <label for="txtCaja">Caja</label>
                  <select id="txtCaja" name="txtCaja" class="form-control custom-select" disabled="true">

                    <?php
                    $db = new BaseDatos();
                //error_log("ip='".$_SESSION['ip']."' and id_sucursal=".$_SESSION['sucursal']."",0);
                    if($resultado=$db->buscar("caja","ip='".$_SESSION['ip']."' and id_sucursal=".$_SESSION['sucursal']."")){
                      foreach($resultado as $row) { ?>
                        <option value=<?=$row['id_caja'] ?> ><?=$row['nombre'] ?></option> <?php } } ?>
                      </select>

                    </div>

                  </div>
                  <input type="hidden"  id="idApertura" name="idApertura"  value="" >

                  <div class="row">
                    <div class="col-md-6">
                      <label>Consecutivo</label>
                      <input type="text" class="form-control" id="txtConsecutivo" name="txtConsecutivo" required disabled="true">
                    </div>

                    <div class="col-md-6">

                      <label for="txtTipo">Tipo Arqueo</label>
                      <select id="txtTipo" name="txtTipo" class="form-control custom-select">
                        <option selected disabled>Seleccione</option>
                        <?php
                        $db = new BaseDatos();
                        if($resultado=$db->buscar("tipo_arqueo","1")){
                          foreach($resultado as $row) { ?>
                            <option value=<?=$row['id_tipo_arqueo'] ?> ><?=$row['descripcion'] ?></option> <?php } } ?>
                          </select>

                        </div>

                      </div>





                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btAbrir" class="btn btn-info"  href="javascript:;" onclick="abrirTurno(1); return false" >Abrir Turno</button>
                        <button type="submit" id="btEjecutar" class="btn btn-info" href="javascript:;" visible=false onclick="abrirTurno(2); return false" >Ejecutar Arqueo</button>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </form>




            <!-- The Modal -->
            <div class="modal" id="arqueoCaja" data-backdrop="static" data-keyboard="false" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">

                  <!-- Modal body -->
                  <div class="modal-body">


                   <form action="?" method="post" id="form1" name="form1">
                    <input type="hidden" value="" name="apertura">
                    <div class="box grid_16 round_all">
                      <h2 class="box_head grad_colour">Listado de Billetes</h2>
                      <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
                      <div class="toggle_container">
                        <div class="block">

                         <p >  <table width="100%" border="2" cellspacing="2" cellpadding="0">
                          <br>Usuario: <?=$_SESSION['user']?>
                          <br>Caja:<label id="nombreCaja"></label>
                        </p><br style=" font-weight: bold;">APERTURA DE CUENTA: <h2><label id="_saldo_inicial"></label> </h2>
                        <br class="centrado">-------------------------------------------------------------------</br></p>
                        <thead>
                          <tr>
                            <th align="left" style="width: 4%">BILLETES/MONEDAS</th>
                            <th align="center" style="width: 4%">CANTIDAD</th>
                             <input type="hidden"  id="txtId_tipo_arqueo" name="txtId_tipo_arqueo"  value="" >
                             <input type="hidden"  id="saldo_inicial" name="saldo_inicial"  value="" >
                              <input type="hidden"  id="txtId_arqueo" name="txtId_arqueo"  value="" >
                          </tr>
                        </thead>

                        <?php
                        $ids_billetes = array();
                        $db = new BaseDatos();
                        $moneda= $db->buscar("monedas","defecto=1");
                        $m_defecto=0;
                        foreach($moneda as $row){
                          $m_defecto= $row['id_moneda'];
                        }

                        if($resultado=$db->buscar("billetes","fecha_baja is null and id_moneda=".$m_defecto."")){


                          foreach($resultado as $lista){
                            $ids_billetes[]= $lista['id_billete'];

                            ?>

                            <tbody>
                              <tr>
                                <td class="cantidad" ><?php echo $lista['descripcion'] ?></td>
                                <td align="center" class="productoCaja" ><input name="moneda_<?=$lista['id_billete']?>" type="text"  value="" id="moneda_<?=$lista['id_billete']?>" title="<?=$lista['descripcion'] ?>" placeholder="<?=$lista['monto']?>" autofocus onBlur="sumar(<?=$lista['id_billete']?>,this)" /></td>
                                <td align="right" style="width: 4%" class="precio"><label class="total">0</label></td>
                              </tr>
                            <?php }  }?>
                            <tr>
                              <td class="cantidad"></td>
                              <td class="productoCaja"><h2>TOTAL</h2></td>
                              <td valign="top" ><h2 id="_total_arqueo">$ 0</h2></td>

                            </tr>
                          </tbody>
                          <tr>



                          </tr>
                        </table>
                      </div>

                    </div>
                  </div>

                </form>

                   <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-warning"  href="javascript:;" onclick="guardarArqueo()">Guardar</button>
                </div>

                </div>



              </div>
            </div>
          </div>


<div class="modal" id="ModalLoginCaja" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">
       

        <!-- Modal body -->
        <div class="modal-body">
          <div class="box-body">

              <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Entrar a POS DE VENTAS<p>

      <form  method="post">
        <div class="input-group mb-2">
         <input type="text" name="txt_usuario" id ="txt_usuario" class="form-control" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-2">
          <input type="password" class="form-control" placeholder="Contraseña" name="txt_contra" id="txt_contra">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">          
                       
            <button type="submit" class="btn btn-primary btn-block" href="javascript:;"  onclick="entrarCaja(); return false">Entrar</button>
          

        </div>
     
     

      </form>

          
    </div>
    <!-- /.login-card-body -->
  </div>  

            
          </div>
        </div>


        <!---OK-->
      </form>

    </div>

  </div>

</div>