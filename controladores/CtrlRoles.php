    <?php 

    	
	 class ControlRoles{

		

        // mostrar productos
  
        static  public function mostrarRoles($parametro, $datos){


          $resultado=ModeloRol::mostrarRoles($parametro, $datos);
          
           return $resultado;
                       
          }




        
  }
    

	
