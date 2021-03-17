    <?php 

    	
	 class ControlVentas{

		

      
        static  public function buscarVentasActuales($parametro){


          $resultado=ModeloVentas::buscarVentasInterzas($parametro);
          
           return $resultado;
                       
          }


        static  public function validarNoExistenVentas(){


          $resultado=ModeloVentas::validarVentasSalir();
          
           return $resultado;
                       
          }



                 
  }
    

	

