<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

//$empleados = DB::query("SELECT * FROM empleados");

//require __DIR__.'/../vistas/empleados_lista_vista.php';

if(isset($_SESSION["id"]))
    $id_evaluador = $_SESSION["id"];
else
    $id_evaluador = @$_GET['por'] ;

if(!$id_evaluador){
    echo "No se ha especificado un evaluador";
    exit;
}


$consulta = <<<SQL
SELECT 
    ev.id,
    f.id AS id_formulario,
    e.id AS id_empleado,
    u.id AS id_evaluador,
    
    f.titulo AS formulario,    
    CONCAT(e.sid_titulos,' ',e.paterno,' ',e.materno,' ',e.nombres, " - ",a.descripcion,"|",c.descripcion) AS empleado,
    CONCAT(e2.sid_titulos,' ',e2.paterno,' ',e2.materno,' ',e2.nombres) AS evaluador

FROM evaluadores AS ev
LEFT JOIN formularios AS f  ON  f.id  = ev.id_formularios
LEFT JOIN empleados   AS e  ON  e.id  = ev.id_empleados
LEFT JOIN usuarios    AS u  ON  u.id  = ev.id_usuarios
LEFT JOIN empleados   AS e2 ON e2.id  =  u.id_empleados
LEFT JOIN areas       AS a  ON  a.id  =  e.id_areas
LEFT JOIN cargos      AS c  ON  c.id  =  e.id_cargos
WHERE u.id = :id_evaluador
ORDER BY e.id ASC
;
SQL;
$stmt = DB::query($consulta,['id_evaluador'=>$id_evaluador]);
$rows = $stmt->fetchAll();


include_once __DIR__ .'/../vistas/header.tpl.php';
include_once __DIR__ .'/../vistas/evaluar_empleados_lista.vista.php';
include_once __DIR__ .'/../vistas/footer.tpl.php';