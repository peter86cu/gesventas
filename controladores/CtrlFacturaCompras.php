    <?php 

    	
	 class ControlFacturaCompras{

		

        // mostrar productos
  
        static  public function mostrarFacturas($parametro, $datos){


          $resultado=ModeloFacturasCompras::mostrarFacturas($parametro, $datos);
          
           return $resultado;
                       
          }

          static  public function mostrarDatosProveedor($datos){


          $resultado=ModeloFacturasCompras::mostrarDatosProveedor( $datos);
          
           return $resultado;
                       
          }

          




        
  }
    

	

