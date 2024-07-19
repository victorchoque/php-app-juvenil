<?php
require __DIR__ ."/../todo.php"; 
require __DIR__ .'/privado.php';

$id_formularios = $_GET["id_formularios"];
$data = DB::obtenerQuery("SELECT * FROM formularios WHERE id=?",[$id_formularios]);
//var_dump($data);


include_once __DIR__ .'/../vistas/header.tpl.php';
$crud= new CRUD("📋 {$data['titulo']} > ☑️ preguntas","preguntas","id");
$crud->setPersistGet('id_formularios');
$crud->setGlobalFields(function($f) use($data, $id_formularios) {
    $f->id->setVisible(false);
    $f->id_formularios->setVisible(false)->setDefaultData($id_formularios);
    //$f->id_areas_formularios->setVisible(false)->setDefaultData($id_formularios);
    //$f->id_cargos_formularios->setVisible(false)->setDefaultData($id_formularios);
    $secciones = explode(",",$data["secciones"]);
    $f->seccion
        ->setName("Seccion")
        ->setOptions( array_combine($secciones,$secciones) )
        ;
    $f->texto("Texto O Pregunta");
    $f->texto->setDefaultData("¿?");
    $f->posicion
        ->setName("Posicion")
        ->setType(CRUD_types::NUMBER)
        ->setDefaultData(1)
        ;
});

$crud->canCreate()    
    ->onSubmit(function($form) use($id_formularios) {
        unset($form["id"]);
        var_dump($form);
        $stmt = DB::insertar("preguntas",$form);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->render(function($id) use($id_formularios) {
        return DB::obtenerQuery("SELECT * FROM preguntas WHERE id=:id",['id'=> $id]);
    })
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("preguntas",$form,'id');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("preguntas","id=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
$crud->canList()
    ->setFields(["seccion","posicion","texto"])
    ->render(function()use($id_formularios){
        $stmt = DB::query("SELECT * FROM preguntas WHERE id_formularios=? ORDER BY seccion DESC,posicion,id ASC",[$id_formularios]);
        return $stmt->fetchAll();
    })
    ;

$crud->show();

include_once __DIR__ .'/../vistas/footer.tpl.php';