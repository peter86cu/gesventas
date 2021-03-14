    <?php 

    	
	 class ControlGeneral{

		

        // mostrar productos
  
        static  public function mostrarNotificaciones($parametro, $datos){


          $resultado=ModeloGeneral::mostrarNotif($parametro, $datos);
          
           return $resultado;
                       
          }




        
  }
    

	

