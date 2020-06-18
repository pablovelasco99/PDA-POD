<?php

    class DEPARTAMENTO_Model {

        var $nombre;
        var $codigo;
        var $mysqli;

        function __construct($nombre, $codigo){
            $this->nombre = $nombre;
            $this->codigo = $codigo;

            include_once './DB/conexion.php';
            $this->mysqli = ConnectDB();
        }

        function ADD(){

            $sql = "INSERT INTO DEPARTAMENTO(
                        nombre,
                        codigo)
                    VALUES(
                        '$this->nombre',
                        '$this->codigo')";
            
            if(mysqli_query($this->mysqli, $sql)){
                echo "Inserción de DEPARTAMENTO realizada correctamente" . "<br>";
            }
        }

    }

?>