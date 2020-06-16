<?php

    class ASIGNATURA_Model {

        var $codigo;
        var $nombre;
        var $titulacion;

        function __construct($codigo, $nombre, $titulacion){
            $this->codigo = $codigo;
            $this->nombre = $nombre;
            $this->titulacion = $titulacion;

            include_once './DB/conexion.php';
            $this->mysqli = ConnectDB();
        }

        function ADD(){

            $sql = "INSERT INTO ASIGNATURA(
                        codigo,
                        nombre,
                        titulacion)
                    VALUES(
                        '$this->codigo',
                        '$this->nombre',
                        (SELECT id FROM TITULACION WHERE codigo = '$this->titulacion'))";

            if(mysqli_query($this->mysqli, $sql)){
                echo "Inserción de ASIGNATURA realizada correctamente" . "<br>";
            }
        }

        function CHANGE_LINEBREAKS(){

            $sql = "UPDATE ASIGNATURA SET nombre = REPLACE(nombre, '\n', ' ')";

            if(mysqli_query($this->mysqli, $sql)){
                echo "Actualización de ASIGNATURA realizada correctamente" . "<br>";
            }
        }

        function TRIM(){

            $sql = "UPDATE ASIGNATURA SET nombre = TRIM(nombre)";

            if(mysqli_query($this->mysqli, $sql)){
                echo "Actualización de ASIGNATURA realizada correctamente" . "<br>";
            }
        }

    }

?>