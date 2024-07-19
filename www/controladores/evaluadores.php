<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

require __DIR__.'/../vistas/header.tpl.php';



$crud= new CRUD("👥 &raquo; 👨🏽‍💻 Evaluadores","evaluadores","id");
$crud->setGlobalFields(function($f){
    $f->id->setVisible(false);
    $f->id_formularios
        ->setName("Formulario A Evaluar")
        ->setOptions( DB::listaSeleccion('formularios','id','titulo','ORDER BY id ASC')  );
    $f->id_empleados
        ->setName("Empleado A ser Evaluado")
        ->setOptions( DB::listaSeleccion('empleados','id','CONCAT(sid_titulos," ",paterno," ",materno," ",nombres) AS nombres','ORDER BY paterno ASC')  );
    $rawQuery = <<<SQL
    SELECT 
        u.id,
        CONCAT(e.sid_titulos,' ',e.paterno,' ',e.materno,' ',e.nombres, " - ",a.descripcion,"|",c.descripcion) AS detalle            
    FROM usuarios AS u
    INNER JOIN empleados AS e ON u.id_empleados=e.id
    LEFT JOIN areas AS a ON e.id_areas=a.id
    LEFT JOIN cargos AS c ON e.id_cargos=c.id
    WHERE u.permisos LIKE '%evaluador%'
    ORDER BY paterno ASC
SQL;
    $f->id_usuarios
        ->setName("Evaluador")
        ->setOptions( DB::listaSeleccionRaw($rawQuery)  );    
});
$crud->canCreate()    
    ->onSubmit(function($form){
        unset($form["id"]);
        
        $stmt = DB::insertar("evaluadores",$form);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->render(function($id){

        return DB::obtenerQuery("SELECT * FROM evaluadores WHERE id=:id",['id'=> $id]);
    })
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("evaluadores",$form,'id');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList()
    ->setFields(["id","formulario","empleado","evaluador"])
    ->render(function(){
    $query = <<<SQL
    SELECT 
        ev.id,
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
    ORDER BY e.id ASC
;
SQL;
        //$stmt = DB::query("SELECT * FROM evaluadores");
        $stmt = DB::query($query);
        return $stmt->fetchAll();
    });
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("evaluadores","id=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
$crud->show();



//Para Mostrar los GRafos Correctamente

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
ORDER BY e.id ASC
;
SQL;
$stmt = DB::query($consulta);
$rows = $stmt->fetchAll();
// $usuarios = array();
// $formularios = array();
// $empleados = array();
// $nodes_json_array = array();

// foreach($rows as $row){
//     $nodes_json_array[] = '{ id: 1, label: "node\none", shape: "box", color: "#97C2FC" }';
// }
// NODES '{ id: 1, label: "node\none", shape: "box", color: "#97C2FC" },'
// EDGES '{ from: 2, to: 4, color: { inherit: "to" } },'

include_once __DIR__ .'/../vistas/evaluadores_lista_vista.php';
require __DIR__.'/../vistas/footer.tpl.php';