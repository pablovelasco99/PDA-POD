<?php

    class GRUPO_Model {

        var $tag;
        var $asignatura;
        var $horas;
        

        function __construct($tag, $asignatura, $horas){
            $this->tag = $tag;
            $this->asignatura = $asignatura;
            $this->horas = $horas;

            include_once './DB/conexion.php';
            $this->mysqli = ConnectDB();
        }

        function ADD(){

            $sql = "INSERT INTO GRUPO(
                        tag,
                        asignatura,
                        horas)
                    VALUES(
                        '$this->tag',
                        (SELECT id FROM ASIGNATURA WHERE nombre = '$this->asignatura'),
                        '$this->horas')";

            if(mysqli_query($this->mysqli, $sql)){
                echo "Inserción de GRUPO realizada correctamente" . "<br>";
            }
        }

    }

?>