  <?php
 class BaseDatos{
   /* private $host   ="localhost";
    private $usuario="root";
    private $clave  ="admin";
    private $db     ="test1";*/

    private $host   ="178.33.57.246";
    private $usuario="lmjqusfo_root";
    private $clave  ="Ayala860809-";
    private $db     ="lmjqusfo_gesventas";
    public $conexion;


    public function __construct(){

            $this->conexion = new mysqli($this->host, $this->usuario, $this->clave,$this->db) or die(mysql_error());
            $this->conexion->set_charset("utf8");


        //or die(mysql_error());

    }
    //INSERTAR
    public function insertar($tabla, $datos){
      
        $resultado =  $this->conexion->query("INSERT INTO $tabla VALUES (null,$datos)");
        if($resultado)
            return true;
        return false;

    }

     //INSERTAR CAMPOS ESPECIFICOS
    public function insertarCamposEspecificos($tabla,$campos, $datos){
         
        $resultado =  $this->conexion->query("INSERT INTO $tabla ($campos) VALUES (null,$datos)");
        if($resultado)
            return true;
        return false;

    }

    //INSERTAR ARQUEO INICIAL
    public function insertarInicial($tabla,$campos, $datos){

        $resultado =  $this->conexion->query("INSERT INTO $tabla ($campos) $datos");
        if($resultado)
            return true;
        return false;

    }

    //BORRAR
    public function borrar($tabla, $condicion){

        $resultado  =   $this->conexion->query("DELETE FROM $tabla WHERE $condicion") or die($this->conexion->error);
        if($resultado)
            return true;
        return false;
    }
    //ACTUALIZAR
    public function actualizar($tabla, $campos, $condicion){
error_log("UPDATE $tabla SET $campos WHERE $condicion");
           $resultado  =   $this->conexion->query("UPDATE $tabla SET $campos WHERE $condicion") or die($this->conexion->error);
            if($resultado)
                return true;
            return false;

    }

    //BUSCAR
    public function buscar($tabla, $condicion){

        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion") or die($this->conexion->error);
        $filas= array();
      if($resultado){
          while ($fila = $resultado->fetch_assoc()) {
        $filas[] = $fila;
          } 
          return $filas;
      }else
      return false;

    }

    //BUSCAR Ajax
    public function buscarAjax($tabla, $condicion){

        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion") or die($this->conexion->error);
        $filas= array();
      if($resultado){
          return  $resultado->fetch_array();
      }else
      return false;

    }

    //BUSCAR Ajax
    public function buscarAjaxSQL( $query){

        $resultado = $this->conexion->query($query) or die($this->conexion->error);
        $filas= array();
      if($resultado){
        return  $resultado->fetch_array();
      }else
      return false;

    }

    //BUSCAR
    public function buscarSQL($query){
           
        $resultado = $this->conexion->query($query) or die($this->conexion->error);
        /*if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);*/
            $filas= array();
      if($resultado){
          while ($fila = $resultado->fetch_assoc()) {
        $filas[] = $fila;
          } 
          return $filas;
      }else
      return false;

    }
}
