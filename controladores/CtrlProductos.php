    <?php 

    	
	 class ControlProductos{

		//insertar productos
      	static	public function insertarProducto(){	 	
         if (isset($_POST["inputCodigo"]) && isset($_POST["inputNombre"])) {

                          error_log($_FILES['foto']['tmp_name']) ;

                          print_r($_POST);

          $foto= $_FILES['foto'];
           $nombre_foto = $foto['name'];
          $url_tem = $foto['tmp_name'];
          $imgProducto= 'img_producto.png';

          if($nombre_foto!=''){
            $destino = 'vistas/recursos/dist/img/productos/';
            $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
            $imgProducto = $img_nombre.'.jpg';
            $src= $destino.$imgProducto;
          }


              $resultado=ModeloProductos::insertarProductoNew($_POST["inputCodigo"], $_POST["inputNombre"], $_POST["inputPVenta"], $_POST["inputIVAVenta"], $_POST["inputCategoria"], $_POST["inputId_marca"], $_POST["inputTipo_producto"],$_POST["inputUnidad"], $imgProducto,
               $_POST["inputInve"], $_POST["inputDispo"],$_POST["inputMoneda"], $_POST["inputMinimo"]);

                error_log($resultado,0);
                 if($resultado==1){

                    if ($nombre_foto!='') {
                     move_uploaded_file($url_tem, $src);
                    }
                  /* echo '<script>Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Producto guardado",
                    showConfirmButton: false,
                    timer: 1900
                  })</script>';*/

                  echo '<script>
                      Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "A ocurrido un error!",
                        footer: "<a href>Ver que mensaje dar?</a>"
                      })</script>';

                } elseif($resultado==null){
                      echo '<script>
                      Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "A ocurrido un error!",
                        footer: "<a href>Ver que mensaje dar?</a>"
                      })</script>';
                    }
                    
             } 
          }


        // mostrar productos
  
        static  public function mostrarProducto($parametro, $datos){


          $resultado=ModeloProductos::mostrarProductos($parametro, $datos);
          
           return $resultado;
                       
          }




          static  public function cantidadRegistros( $datos){


          $resultado=ModeloProductos::cantidadRegistros( $datos);
          
           return $resultado;
                       
          }



        
  }
    

	

