    <?php 

    	
	 class ControlApertura{

		

       
  
        static  public function mostrarNotificaciones($parametro, $datos){


          $resultado=ModeloGeneral::mostrarNotif($parametro, $datos);
          
           return $resultado;
                       
          }



        static  public function mostrarAperturas($parametro, $datos){


          $resultado=ModeloApertura::buscasApertura($parametro, $datos);
          
           return $resultado;
                       
          }




        
  }
    

	

