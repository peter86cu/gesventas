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


       static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){
    

        $respuesta = ModeloVentas::mdlRangoFechasVentas($fechaInicial, $fechaFinal);

        return $respuesta;
       
    
        }


         static public function comparativoAnualdeVentas(){
    

        $respuesta = ModeloVentas::comparativoAnualdeVentas();

        return $respuesta;
       
    
        }


        static public function crecimientoMesActualAnterior(){
    

        $respuesta = ModeloVentas::procientoCrecimietoUltimoMensual();

        return $respuesta;
       
    
        }

                 
  }
    

	

