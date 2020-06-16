<?php

    include_once './index.php';
    class TITULACION_Model {

        var $nombre;
        var $campus;
        var $codigo;
        var $mysqli;

        function __construct($nombre, $campus, $codigo){
            $this->nombre = $nombre;
            $this->campus = $campus;
            $this->codigo = $codigo;

            include_once './DB/conexion.php';
            $this->mysqli = ConnectDB();
        }

        function ADD(){
            $sql = "INSERT INTO TITULACION(
                        nombre,
                        campus,
                        codigo)
                    VALUES(
                        '".$this->nombre."',
                        '".$this->campus."',
                        '".$this->codigo."')";

            if(mysqli_query($this->mysqli, $sql)){
                echo "Inserción de TITULACION realizada correctamente" . "<br>";
            }

        }

    }

?>