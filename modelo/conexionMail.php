<?php
 class BaseDatosMail{
    private $host   ="localhost";
    private $usuario="root";
    private $clave  ="admin";
    private $db     ="correo";

    /*private $host   ="localhost";
    private $usuario="test";
    private $clave  ="@dmin860809*";
    private $db     ="admin_ventas";*/
    public $conexion;


    public function __construct(){

            $this->conexion = new mysqli($this->host, $this->usuario, $this->clave,$this->db) or die(mysql_error());
            $this->conexion->set_charset("utf8");


        //or die(mysql_error());

    }
    //INSERTAR
    public function insertar($tabla, $datos){
      error_log("INSERT INTO $tabla VALUES (null,$datos)");
        $resultado =  $this->conexion->query("INSERT INTO $tabla VALUES (null,$datos)");
        if($resultado)
            return true;
        return false;

    }

     //INSERTAR CAMPOS ESPECIFICOS
    public function insertarCamposEspecificos($tabla,$campos, $datos){
           error_log("INSERT INTO $tabla ($campos) VALUES (null,$datos)");
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
        error_log("DELETE FROM $tabla WHERE $condicion");
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
        if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;

    }

    //BUSCAR Ajax
    public function buscarAjax($tabla, $condicion){
  
        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion") or die($this->conexion->error);
        if($resultado)
            return $resultado->fetch_array(MYSQLI_ASSOC);
        return false;

    }

    //BUSCAR Ajax
    public function buscarAjaxSQL( $query){

        $resultado = $this->conexion->query($query) or die($this->conexion->error);
        if($resultado)
            return $resultado->fetch_array(MYSQLI_ASSOC);
        return false;

    }

    //BUSCAR
    public function buscarSQL($query){
error_log($query);
        $resultado = $this->conexion->query($query) or die($this->conexion->error);
        if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;

    }
}
