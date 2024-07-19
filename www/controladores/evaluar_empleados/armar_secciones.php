<?php
require_once __DIR__ ."/../../todo.php"; 
// variables Globales
$secciones =array();
// $id_evaluador =  $_GET["por"];
// $id_formulario =  $_GET["formulario"];
// $id_empleado =  $_GET["empleado"];
//obtenemos las seccciones
$consulta = <<<SQL
    SELECT id,seccion,texto 
    FROM preguntas 
    WHERE id_formularios=?
    ORDER BY seccion DESC, posicion ASC;
SQL;
$stmt = DB::query($consulta,[ $id_formulario]);
$tmp_preguntas = $stmt->fetchAll();

foreach($tmp_preguntas as $row){
    if(!isset( $secciones[$row["seccion"]] ))
    {
        $secciones[$row["seccion"]] = array( );
    }
    $secciones[$row["seccion"]][] = array(
        "pregunta"=>$row["texto"],
        "usuario1"=>'<label><input name="'.$row["id"].'" type="radio" required />SI</label> <label> <input name="'.$row["id"].'" type="radio" required/>NO</label>',
        "usuario2"=>'-',
        "usuario3"=>"NO");
    
}