<?php

    class PROFESOR_Model {

        var $dni;
        var $nombre;
        var $departamento;
        var $mysqli;

        function __construct($DNI, $nombre, $departamento){
            $this->dni = $DNI;
            $this->nombre = $nombre;
            $this->departamento = $departamento;

            include_once './DB/conexion.php';
            $this->mysqli = ConnectDB();
        }

        function ADD(){
                
            $sql = "INSERT INTO PROFESOR(
                        dni,
                        nombre,
                        cod_departamento)
                    VALUES(
                        '$this->dni',
                        '$this->nombre',
                        '$this->departamento')";

            if(mysqli_query($this->mysqli, $sql)){
                echo "Inserción de PROFESOR realizada correctamente" . "<br>";
            }

            
        }

        function TRIM(){

            $sql = "UPDATE PROFESOR SET nombre = TRIM(nombre)";

            if(mysqli_query($this->mysqli, $sql)){
                echo "Actualización de PROFESOR realizada correctamente" . "<br>";
            }
        }

    }

?>