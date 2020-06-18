<?php

    class AREA_Model {

        var $nombre;
        var $departamento;
        var $codigoArea;
        var $mysqli;

        function __construct($nombre, $departamento, $codigoArea){
            $this->nombre = $nombre;
            $this->departamento = $departamento;
            $this->codigoArea = $codigoArea;

            include_once './DB/conexion.php';
            $this->mysqli = ConnectDB();
        }

        function ADD(){

            $sql = "INSERT INTO AREA(
                        nombre,
                        departamento,
                        codigo)
                    VALUES(
                        '$this->nombre',
                        (SELECT id FROM DEPARTAMENTO WHERE codigo = '$this->departamento'),
                        '$this->codigoArea')";
            if(mysqli_query($this->mysqli, $sql)){
                echo "Inserción de AREA realizada correctamente" . "<br>";
            }

        }

    }

?>