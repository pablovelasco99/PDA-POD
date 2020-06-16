<?php

function parseTitulacion($raw){
    $i = 0;
    while($raw[$i++][0][0] != '(');
    $result[0] = explode(") ", str_replace("(", "", $raw[--$i][0]))[0];
    $result[1] = explode(") ", $raw[$i][0])[1];
    switch ($result[0][0]) {
        case 'O':
            $result[2] = "Ourense";
            break;
        case 'V':
            $result[2] = "Vigo";
            break;
        case 'P':
            $result[2] = "Pontevedra";
            break;
    }
    
    return $result;
}

function parseAsignaturas($raw, $titulacion){
    $i = 0;
    $j = 0;
    while ($raw[$i++][0] != "Materias da titulación");
    while ($raw[$i++][0] != "Resumo de horas por departamento")
        if (count($raw[$i]) > 1 && strlen($raw[$i][0]) && $raw[$i][0][0] == 'G'){
            $table[$j][0] = $titulacion[0];
            $table[$j][1] = $raw[$i][0];
            $table[$j++][2] = $raw[$i][1];
        }
    return $table;
}

function parseDepartamentos($raw){
    $i = 0;
    $j = 0;
    while ($raw[$i++][0] != "Resumo de horas por departamento");
    while ($raw[$i++][0] != "Lenda:"){
        if (count($raw[$i]) > 1 && strlen($raw[$i][0]) && $raw[$i][0][0] == 'D'){
            $table[$j][0] = $raw[$i][0];
            $table[$j++][1] = str_replace("|", "", $raw[$i][1]);
        }
    }
    return $table;
}

function parseAreas($raw){
    $i = 0;
    $j = 0;
    while ($raw[$i++][0] != "Resumo de horas por áreas");
    $departamento = "";
    while ($raw[$i++][0] != "Lenda:"){
        if (count($raw[$i]) && strlen($raw[$i][0]) && $raw[$i][0][0] == 'D')
            $departamento = $raw[$i][0];
        else if (count($raw[$i]) > 1 && strlen($raw[$i][1]) && $raw[$i][1][0] == 'A'){
            $table[$j][0] = $departamento;
            $table[$j][1] = explode(" - ", $raw[$i][1])[0];
            $table[$j++][2] = explode(" - ", $raw[$i][1])[1];
        }
    }
    return $table;
}

function parseGrupos($raw, $table3){
    $i = 0;
    $j = 0;
    $k = 0;
    $tags = array();
    $table = array();
    while ($raw[$i++][0] != "Materias da titulación");
    while ($raw[$i++][0] != "Resumo de horas por departamento")
        if (count($raw[$i]) > 1 && strlen($raw[$i][4]) && $raw[$i][4][0] == 'A'){
            if (strlen($raw[$i][0]) && $raw[$i][0][0] == 'G'){
                $tags[$j] = getTag($raw[$i][1], $tags);
                $asignatura = $raw[$i][1];
            } else $j--;
            for($l = 1; $l <= intval($raw[$i][15]); $l++){
                $table[$k][0] = $tags[$j] . "A" . $l;
                $table[$k][1] = $asignatura;
                foreach($table3 as $entry)
                    if ($entry[1] == $raw[$i][4]){
                        $table[$k][2] = $entry[0];
                        break;
                    }
                $table[$k++][3] = floatval($raw[$i][12]);
            }
            for($l = 1; $l <= intval($raw[$i][16]); $l++){
                $table[$k][0] = $tags[$j] . "B" . $l;
                $table[$k][1] = $asignatura;
                foreach($table3 as $entry)
                    if ($entry[1] == $raw[$i][4]){
                        $table[$k][2] = $entry[0];
                        break;
                    }
                $table[$k++][3] = floatval($raw[$i][13]);
            }
            for($l = 1; $l <= intval($raw[$i][17]); $l++){
                $table[$k][0] = $tags[$j] . "C" . $l;
                $table[$k][1] = $asignatura;
                foreach($table3 as $entry)
                    if ($entry[1] == $raw[$i][4]){
                        $table[$k][2] = $entry[0];
                        break;
                    }
                $table[$k++][3] = floatval($raw[$i][14]);
            }
            $j++;
        }
    return $table;
}

function parseProfesores($raw){
    $i = 0;
    $j = 0;
    $departamento = "";
    $dni = "";
    $name = "";
    while (!strpos($raw[$i++][0], "Resumo")){
        if (strpos($raw[$i][0], "(D"))
            $departamento = explode(") ", str_replace("(", "", $raw[$i][0]))[0];
        else if (preg_match("/ NA | DESC | TC | P[0-9] /", $raw[$i][0])){
            $dni = array_values(array_filter(explode(" ", $raw[$i][0])))[0];
            $name = substr(preg_split("/ NA | DESC | TC | P[0-9] /", $raw[$i][0])[0], strlen($dni)+2);
            $table[$j][0] = $departamento;
            $table[$j][1] = $dni;
            $table[$j++][2] = $name;
        }
    }
    return $table;
}

function parseProfesorAsignatura($raw){
    $i = 0;
    $j = 0;
    $dni = "";
    $asignatura = "";
    while (!strpos($raw[$i++][0], "Resumo")){
        if (preg_match("/ NA | DESC | TC | P[0-9] /", $raw[$i][0])){
            $dni = array_values(array_filter(explode(" ", $raw[$i][0])))[0];
            $asignatura = array_values(array_filter(preg_split("/ +/", preg_split("/ NA | DESC | TC | P[0-9] /", $raw[$i][0])[1])))[1];
            $table[$j][0] = $dni;
            $table[$j++][1] = $asignatura;
        } else if (count($raw[$i])) {
            $data = array_values(array_filter(preg_split("/ +/", $raw[$i][0])));
            if (count($data) && strlen($data[0]) && $data[0][0] == 'O'){
                $table[$j][0] = $dni;
                $table[$j++][1] = $data[1];
            }
        }
    }
    return $table;
}

function getTag($name, $tags){
    $name = deleteAccentMarks($name);
    $seed = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "X", "Y", "Z", "W");
    $tag = "";
    foreach(explode(" ", $name) as $word){
        $tag = $tag . $word[0];
    }
    if(in_array($name, $tags)){
        $tag = $tag . $seed[array_count_values($tags)[$tag] - 1];
    }
    return $tag;
}

function deleteAccentMarks($string){
    $string = str_replace(array("Á", "á", "Ó", "ó", "É", "é", "Í", "í", "Ú", "ú", "Ü", "ü"), array("A", "A", "O", "O", "E", "E", "I", "I", "U", "U", "U", "U"), $string);
    $string = strtoupper($string);
    return $string;
}

function sendQueries($raw){
    
}

?>