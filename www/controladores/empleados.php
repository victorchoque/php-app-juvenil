<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

//$empleados = DB::query("SELECT * FROM empleados");

//require __DIR__.'/../vistas/empleados_lista_vista.php';

include_once __DIR__ .'/../vistas/header.tpl.php';

$crud= new CRUD("👨🏽‍💻 Empleados","empleados","id");
$crud->setGlobalFields(function($f){
    $f->id->setVisible(false);
    $f->paterno("Paterno");
    $f->materno("Materno");
    $f->nombres("Nombres");
    $f->sid_titulos
            ->setName("Grado o Titulo")
            ->setOptions( DB::listaSeleccion('titulos','sid','descripcion','ORDER BY sid ASC')  );

    $f->id_areas
        ->setName("Area")
        ->setOptions( DB::listaSeleccion('areas','id','descripcion','ORDER BY id ASC')  );

    $f->id_cargos
        ->setName("Cargo")
        ->setOptions( DB::listaSeleccion('cargos','id','descripcion','ORDER BY id ASC')  );
});
$crud->canCreate()    
    ->onSubmit(function($form){
        unset($form["id"]);
        
        $stmt = DB::insertar("empleados",$form);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->render(function($id){
        return DB::obtenerQuery("SELECT * FROM empleados WHERE id=:id",['id'=> $id]);
    })
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("empleados",$form,'id');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList()
    ->setFields(["id","nombres","area","cargo"])
    ->render(function(){
        $sql = <<<SQL
    SELECT 
        e.id,
        CONCAT(e.sid_titulos,' ',e.paterno,' ',e.materno,' ',e.nombres) AS nombres,            
        a.descripcion AS area,
        c.descripcion AS cargo
    FROM empleados AS e
    LEFT JOIN titulos AS t ON t.sid   = e.sid_titulos
    LEFT JOIN areas   AS a ON a.id    = e.id_areas
    LEFT JOIN cargos  AS c ON c.id    = e.id_cargos
SQL;
        //$stmt = DB::query("SELECT * FROM empleados");
        $stmt = DB::query($sql);
        return $stmt->fetchAll();
    });
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("empleados","id=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
$crud->show();


include_once __DIR__ .'/../vistas/footer.tpl.php';