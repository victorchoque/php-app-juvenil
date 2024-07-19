<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

//$titulos = DB::query("SELECT * FROM titulos");

//require __DIR__.'/../vistas/titulos_lista_vista.php';

include_once __DIR__ .'/../vistas/header.tpl.php';

$crud= new CRUD("🎓 Titulos o Grados","titulos","sid");
$crud->setGlobalFields(function($f){
    $f->sid("Grado o Titulo Corto");
    $f->descripcion("Grado o Titulo Completo");
});
$crud->canCreate()    
    ->onSubmit(function($form){                
        $stmt = DB::insertar("titulos",$form);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->render(function($id){
        return DB::obtenerQuery("SELECT * FROM titulos WHERE sid=:id",['id'=> $id]);
    })
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("titulos",$form,'sid');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList()
    //->setFields(["descripcion"])
    ->render(function(){
        $stmt = DB::query("SELECT * FROM titulos");
        return $stmt->fetchAll();
    });
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("titulos","sid=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
$crud->show();


include_once __DIR__ .'/../vistas/footer.tpl.php';