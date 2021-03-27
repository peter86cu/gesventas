    <?php 

    	
	 class ControlReportes{

		

      
        static  public function buscasReportes($parametro, $query){


          $resultado=ModeloReportes::buscasReporte($parametro,$query);
          
           return $resultado;
                       
          }


       



                 
  }
    

	

