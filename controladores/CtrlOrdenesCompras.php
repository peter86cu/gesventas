    <?php 

    	
	 class ControlOrdenes{

		

        // mostrar productos
  
        static  public function mostrarOrdenes($parametro, $datos){


          $resultado=ModeloOrdenes::mostrarOrdenes($parametro, $datos);
          
           return $resultado;
                       
          }

          static  public function mostrarDatosProveedor($datos){


          $resultado=ModeloOrdenes::mostrarDatosProveedor( $datos);
          
           return $resultado;
                       
          }

          




        
  }
    

	

