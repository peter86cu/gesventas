    <?php 

    	
	 class ControlProveedor{

		

        // mostrar productos
  
        static  public function mostrarProveedores($parametro, $datos){


          $resultado=ModeloProveedor::mostrarProveedores($parametro, $datos);
          
           return $resultado;
                       
          }




        
  }
    

	

