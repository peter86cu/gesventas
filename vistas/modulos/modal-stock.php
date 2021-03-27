  
<div class="modal" id="ModalReporteStock" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">


        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">

            <div class="col-md-6">
              <label for="inicio">Desde:</label>
              <label id="fechaI1" value=""></label></h3><input type="text" id="datepickerI1"  autofocus required="true">

            </div>
            <div class="col-md-6">
              <label for="fin">Hasta:</label>
              <label id="fechaF1" value=""></label></h3><input type="text" id="datepickerF1"  autofocus required="true">

            </div>
          </div>
          <div class="row">       
            <label for="idProductoStock">Reporte:</label>      
            
              <div class="col-md-4">
               <select id="idReporte" name="idReporte" class="form-control custom-select">
              <option  selected disabled>Select one</option>
              <?php
              $db = new BaseDatos();                                                           
              if($resultado=$db->buscar("reportes","rol =".$_SESSION['rol']."")){
                foreach($resultado as $row) { ?>
                  <option value=<?=$row['id'] ?>><?=$row['reporte'] ?></option> <?php } } ?>                                        
                </select> 
              </div>
              
            </div>

                <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btAbrir" class="btn btn-info"  href="javascript:;" onclick="abirirReporte(); return false" >Generar Reporte</button>
                        
                      </div>

          </div>
       
      </form>

    </div>

  </div>

</div>