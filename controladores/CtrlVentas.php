    <?php 

    	
	 class ControlVentas{

		

      
        static  public function buscarVentasActuales($parametro){


          $resultado=ModeloVentas::buscarVentasInterzas($parametro);
          
           return $resultado;
                       
          }




        
  }
    

	

