    <?php 

    	
	 class ControlMail{

		

      
        static  public function buscarMail($parametro, $consulta){


          $resultado=ModeloMail::buscasMailAll($parametro,$consulta);
          
           return $resultado;
                       
          }


        static  public function validarNoExistenVentas(){


          $resultado=ModeloVentas::validarVentasSalir();
          
           return $resultado;
                       
          }



                 
  }
    

	

