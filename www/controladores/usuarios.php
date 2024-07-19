<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

$usuarios = DB::query("SELECT * FROM usuarios");

//require __DIR__.'/../vistas/usuarios_lista_vista.php';

include_once __DIR__ .'/../vistas/header.tpl.php';

$crud= new CRUD("👥 Usuarios","usuarios","id");
$crud->setGlobalFields(function($f){
    $f->id->setVisible(false);
    $f->user("Nombre de Usuario");
    $f->pass("Contraseña");
    $f->id_empleados
            ->setName("Empleado")
            ->setOptions( DB::listaSeleccion('empleados',
            'id','CONCAT(sid_titulos," ",paterno," ",materno," ",nombres) AS nombres',
            'ORDER BY paterno ASC')  );
    $f->permisos
            ->setName("Permisos")                        
            ->setType(CRUD_types::CHECKBOX_MULTIPLE)
            ->setOptions( [
                'admin'=>'Administrador',
                'evaluador'=>'Evaluador',
                'usuario'=>'Usuario'
            ] );
});
$crud->canCreate()    
    ->onSubmit(function($form){
        unset($form["id"]);
        
        $stmt = DB::insertar("usuarios",$form);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->render(function($id){
        return DB::obtenerQuery("SELECT * FROM usuarios WHERE id=:id",['id'=> $id]);
    })
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("usuarios",$form,'id');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList()
    ->setCustomButton("Evaluar Empleados","evaluar_empleados_lista.php?por={id}")
    //->setFields(["descripcion"])
    ->render(function(){
        $stmt = DB::query("SELECT * FROM usuarios");
        return $stmt->fetchAll();
    });
    //No puede borrar usuarios
// $crud->canDelete()
//     ->onSubmit(function($form,$id){
//         $stmt = DB::borrar("usuarios","id=?",[$id]);
//         if($stmt->rowCount() == 1){
//             return true;
//         }
//         return "Error Desconocido"; 
//     });
$crud->show();


include_once __DIR__ .'/../vistas/footer.tpl.php';