<?php

require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';
$id_evaluador =  $_GET["por"];
$id_formulario =  $_GET["formulario"];
$id_empleado =  $_GET["empleado"];


$consulta = <<<SQL
SELECT 
    ev.id,
    f.id AS id_formulario,
    e.id AS id_empleado,
    u.id AS id_evaluador,
    
    f.titulo AS formulario,    
    CONCAT(e.sid_titulos,' ',e.paterno,' ',e.materno,' ',e.nombres) AS empleado,
    CONCAT(e2.sid_titulos,' ',e2.paterno,' ',e2.materno,' ',e2.nombres) AS evaluador,
    a.descripcion AS empleado_area,
    c.descripcion AS empleado_cargo

FROM evaluadores AS ev
LEFT JOIN formularios AS f  ON  f.id  = ev.id_formularios
LEFT JOIN empleados   AS e  ON  e.id  = ev.id_empleados
LEFT JOIN usuarios    AS u  ON  u.id  = ev.id_usuarios
LEFT JOIN empleados   AS e2 ON e2.id  =  u.id_empleados
LEFT JOIN areas       AS a  ON  a.id  =  e.id_areas
LEFT JOIN cargos      AS c  ON  c.id  =  e.id_cargos
WHERE u.id = :id_evaluador AND f.id=:id_formulario AND e.id=:id_empleado
ORDER BY e.id ASC LIMIT 1
;
SQL;
$stmt = DB::query($consulta,['id_evaluador'=>$id_evaluador, 'id_formulario'=>$id_formulario, 'id_empleado'=>$id_empleado]);
$data = $stmt->fetch();

//fake data : para visualizar como queda
require __DIR__.'/evaluar_empleados/armar_secciones.php';
/*$secciones = array(
    "responsabilidad"=>array(
        array("pregunta"=>"¿?","usuario1"=>"SI/NO","usuario2"=>"SI/NO","usuario3"=>"SI/NO")
    ),
    "desempeño"=>array(
        array("pregunta"=>"¿?","usuario1"=>"SI/NO","usuario2"=>"SI/NO","usuario3"=>"SI/NO")
    ),
);/* */

$puntajes = array(
    "usuario1"=>'90',
    "usuario2"=>'30',
    "usuario3"=>'100',
);

include_once __DIR__ .'/../vistas/header.tpl.php';
include_once __DIR__ .'/../vistas/evaluar_empleados.vista.php';
include_once __DIR__ .'/../vistas/footer.tpl.php';