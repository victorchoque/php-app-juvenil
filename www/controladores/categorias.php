<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

//$categoria = DB::query("SELECT * FROM categoria");

//require __DIR__.'/../vistas/categoria_lista_vista.php';

include_once __DIR__ .'/../vistas/header.tpl.php';

$crud= new CRUD("🕺 categoria","categorias","id");
$crud->setGlobalFields(function($f){
    //id, empresa, contacto, mail, telefono, direccion, logo
    $f->id->setVisible(false);

    //$f->empresa("Empresa");
    //$f->contacto("contacto");
    //$f->mail("Correo");
    //$f->telefono("telefono");
    //$f->direccion("Direccion");    
    //$f->logo->setType(CRUD_types::IMAGE);
    $f->titulo("Titulo o Nombre");
    $f->plantilla_caracteristicas->setName("Caracteristicas")->setType(CRUD_types::JSON_SCHEMA);
    $f->html_card("Plantilla Card en Catalogo");
    $f->html_body("Plantilla Html en Producto ");        
});
$crud->canCreate()
    // ->onUpload(function($file){
        
    //     //$_POST["imagen"] = $algo["imagen"]["name"]."-archivo.jpg";
        
    //     //var_dump($algo);die();
    //     $_POST["logo"] = $file["logo"]["name"];
    //     return move_uploaded_file($file["logo"]["tmp_name"], __DIR__ . '/../imagenes/' .$file["logo"]["name"]);
    // })    
    ->onSubmit(function($form){
        unset($form["id"]);
        
        $stmt = DB::insertar("categorias",$form);
        if($stmt->rowCount() == 1){
            return true;
        }        
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->setData(function($id){

        $row =  DB::obtenerQuery("SELECT * FROM categorias WHERE id=:id",['id'=> $id]);
        if($row["logo"]){
            $row["logo"] = "../imagenes/".$row["logo"];

        }
        return $row;
    }) 
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("categorias",$form,'id');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList()
    //->setFields(["descripcion"])
    
    ->setData(function(){
        $stmt = DB::query("SELECT * FROM categorias");
        $data = $stmt->fetchAll();
        foreach($data as & $row){
            $row["logo"] = "<img src='".URL_BASE ."/imagenes/". $row["logo"]."' style='max-width:60px; max-height:60px' />";
        }
        return $data;
        
    });
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("categorias","id=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
$crud->show();
if(!isset($_GET["_ACTION"]) || $_GET["_ACTION"] == "list"){
    echo "<a class='btn btn-primary' href='categoriaes_reporte.php'> GENERAR REPORTE </a>";
}


include_once __DIR__ .'/../vistas/footer.tpl.php';