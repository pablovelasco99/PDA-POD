<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDA-POD</title>
</head>
<body>
    <?php

    include_once 'Functions/functions.php';
    include_once './DB/conexion.php';

    //-------------//
    include_once './Model/TITULACION_Model.php';
    include_once './Model/PROFESOR_Model.php';
    include_once './Model/DEPARTAMENTO_Model.php';
    include_once './Model/AREA_Model.php';
    include_once './Model/ASIGNATURA_Model.php';
    include_once './Model/PROFESOR_ASIGNATURA_Model.php';
    include_once './Model/GRUPO_Model.php';
    session_start();

    $conn = ConnectDB();

    if (($archivo = fopen("Files/PDA/test.csv", "r")) !== FALSE) {
        $i = 0;
        while (($rawfile1[$i++] = fgetcsv($archivo)) !== FALSE);
        fclose($archivo);
    }
    if (($archivo = fopen("Files/POD/test2.csv", "r")) !== FALSE) {
        $i = 0;
        while (($rawfile2[$i++] = fgetcsv($archivo)) !== FALSE);
        fclose($archivo);
    }

    $titulacion = parseTitulacion($rawfile1);
    $materias = parseAsignaturas($rawfile1, $titulacion);
    $departamentos = parseDepartamentos($rawfile1);
    $areas = parseAreas($rawfile1);
    $grupos = parseGrupos($rawfile1, $areas);
    $profesores = parseProfesores($rawfile2);
    $profesorAsignatura = parseProfesorAsignatura($rawfile2);

    /*echo("<br><h3>TITULACION</h3><br>");
    foreach($titulacion as $entry){
        echo("$entry ");
    }
    echo("<br>");

    echo("<br><h3>Materias</h3><br>");
    foreach($materias as $entry){
        foreach($entry as $value){
            echo("$value ");
        }
        echo("<br>");
    }
    echo("<br><h3>Departamentos</h3><br>");
    foreach($departamentos as $entry){
        foreach($entry as $value){
            echo("$value ");
        }
        echo("<br>");
    }
    
    echo("<br><h3>Áreas por departamento</h3><br>");
    foreach($areas as $entry){
        foreach($entry as $value){
            echo("$value ");
        }
        echo("<br>");
    }
    echo("<br><h3>Grupos por departamento</h3><br>");
    foreach($grupos as $entry){
        foreach($entry as $value){
            echo("$value ");
        }
        echo("<br>");
    }

    /*echo("<br><h3>Profesores</h3><br>");
    foreach($profesores as $entry){
        foreach($entry as $value){
            echo("$value ");
        }
        echo("<br>");
    }
    

    echo("<br><h3>Profesores y Asignaturas</h3><br>");
    foreach($profesorAsignatura as $entry){
        foreach($entry as $value){
            echo("$value ");
        }
        echo("<br>");
    }*/


    //PARA TABLA TITULACION
    $codigo = $titulacion[0];
    $nombre = $titulacion[1];
    $campus = $titulacion[2];

    $TITULACION = new TITULACION_Model($nombre, $campus, $codigo);
    $TITULACION->ADD();

    //PARA TABLA DEPARTAMENTO
    foreach ($departamentos as $row) {

        $codigo = $row[0];
        $nombre = $row[1];

        $DEPARTAMENTO = new DEPARTAMENTO_Model($nombre, $codigo);
        $DEPARTAMENTO->ADD();
    }

    //PARA TABLA AREA
    foreach($areas as $row){
        $nombre = $row[2];
        $codigo = $row[1];
        $departamento = $row[0];

        $AREA = new AREA_Model($nombre, $departamento, $codigo);
        $AREA->ADD();
    }

    //PARA TABLA PROFESORES
    foreach($profesores as $row){
        $DNI = $row[1];
        $departamento = $row[0];
        $nombre = $row[2];

        $PROFESOR = new PROFESOR_Model($DNI, $nombre, $departamento);
        $PROFESOR->ADD();
        $PROFESOR->TRIM();
    }

    //PARA TABLA ASIGNATURA
    foreach ($materias as $row) {
        $nombre = $row[2];
        $titulacion = $row[0];
        $codigo = $row[1];

        $ASIGNATURA = new ASIGNATURA_Model($codigo, $nombre, $titulacion);
        $ASIGNATURA->ADD();
        $ASIGNATURA->CHANGE_LINEBREAKS();
        $ASIGNATURA->TRIM();
    }

    foreach($profesorAsignatura as $row){

        $codigo = $row[1];
        $dni = $row[0];

        $RELACION_PA = new PROFESOR_ASIGNATURA_Model($codigo, $dni);
        $RELACION_PA->ADD();

    }

    foreach($grupos as $row){

        $tag = $row[0];
        $nombre = $row[1];
        $horas = $row[3];

        $GRUPO = new GRUPO_Model($tag, $nombre, $horas);
        $GRUPO->ADD();

    }

    mysqli_close($conn);
    
    ?>
</body>
</html>