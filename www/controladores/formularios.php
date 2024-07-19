<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

//$formularios = DB::query("SELECT * FROM formularios");

//require __DIR__.'/../vistas/formularios_lista_vista.php';

include_once __DIR__ .'/../vistas/header.tpl.php';

$crud= new CRUD("📋 Formularios","formularios","id");

$crud->setGlobalFields(function($f){
    $f->id->setVisible(false);
    $f->id_areas
    ->setName("Del Area")
    ->setOptions( DB::listaSeleccion('areas','id','descripcion','ORDER BY id ASC')  );

    $f->id_cargos
        ->setName("Para el Cargo")
        ->setOptions( DB::listaSeleccion('cargos','id','descripcion','ORDER BY id ASC')  );
    
    $f->titulo("Titulo");
    $f->cantidad_evaluaciones
        ->setName("Numero de Evaluaciones por Empleado")
        ->setType(CRUD_types::NUMBER)
        ->setDefaultData(3)
        ;


});
$crud->canCreate()    
    ->onSubmit(function($form){
        unset($form["id"]);
        
        $stmt = DB::insertar("formularios",$form);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->render(function($id){
        return DB::obtenerQuery("SELECT * FROM formularios WHERE id=:id",['id'=> $id]);
    })
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("formularios",$form,'id');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList("Listar")
    ->setFields(["id","area","cargo","titulo","cantidad_preguntas"])
    ->setCustomButton('☑️ Preguntas','preguntas.php?id_formularios={id}')
    ->render(function(){
        //$stmt = DB::query("SELECT * FROM formularios");
        $consultaSql=<<<SQL
    SELECT f.id,
        f.titulo,
        a.descripcion AS area,
        c.descripcion AS cargo,
        COUNT(p.id) AS cantidad_preguntas
    FROM formularios AS f
    LEFT JOIN cargos AS c ON c.id = f.id_cargos
    LEFT JOIN areas AS a ON a.id = f.id_areas
    LEFT JOIN preguntas AS p ON p.id_formularios = f.id
    GROUP BY f.id, f.titulo, a.descripcion, c.descripcion
    ;
SQL;
        $stmt = DB::query($consultaSql);
        return $stmt->fetchAll();
    });
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("formularios","id=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
$crud->show();


include_once __DIR__ .'/../vistas/footer.tpl.php';