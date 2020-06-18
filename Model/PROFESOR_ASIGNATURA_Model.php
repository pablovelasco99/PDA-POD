<?php

    class PROFESOR_ASIGNATURA_Model {

        var $id_asignatura;
        var $id_profesor;
        

        function __construct($id_asignatura, $id_profesor){
            $this->id_profesor = $id_profesor;
            $this->id_asignatura = $id_asignatura;

            include_once './DB/conexion.php';
            $this->mysqli = ConnectDB();
        }

        function ADD(){

            $sql = "INSERT INTO PROFESOR_ASIGNATURA(
                        id_profesor,
                        id_asignatura)
                    VALUES(
                        (SELECT id FROM ASIGNATURA WHERE codigo = '$this->id_asignatura'),
                        (SELECT id FROM PROFESOR WHERE dni = '$this->id_profesor'))";

            if(mysqli_query($this->mysqli, $sql)){
                echo "Inserción de RELACION PROFESOR-ASIGNATURA realizada correctamente" . "<br>";
            }
        }

    }

?>