<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

//$cargos = DB::query("SELECT * FROM cargos");

//require __DIR__.'/../vistas/cargos_lista_vista.php';

include_once __DIR__ .'/../vistas/header.tpl.php';

$crud= new CRUD("💼 Cargos","cargos","id");
$crud->setGlobalFields(function($f){
    $f->id->setVisible(false);
    $f->descripcion("Descripcion");
});
$crud->canCreate()    
    ->onSubmit(function($form){
        unset($form["id"]);
        
        $stmt = DB::insertar("cargos",$form);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->render(function($id){
        return DB::obtenerQuery("SELECT * FROM cargos WHERE id=:id",['id'=> $id]);
    })
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("cargos",$form,'id');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList()
    ->setFields(["descripcion"])
    ->render(function(){
        $stmt = DB::query("SELECT * FROM cargos");
        return $stmt->fetchAll();
    });
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("cargos","id=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
$crud->show();


include_once __DIR__ .'/../vistas/footer.tpl.php';