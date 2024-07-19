<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

//$producto = DB::query("SELECT * FROM producto");

//require __DIR__.'/../vistas/producto_lista_vista.php';

include_once __DIR__ .'/../vistas/header.tpl.php';

$crud= new CRUD("🗺 Producto","producto","id");
$crud->setPersistGet('id_categoria');
$crud->setGlobalFields(function($f){
    $f->id->setVisible(false);
    $f->id_proveedor
        ->setName("Proveedor ")
        ->setOptions( DB::listaSeleccion('proveedor','id_proveedor','empresa','ORDER BY empresa ASC')  );
        ;
    $f->nombreproducto("Nombre Producto");
    if(isset($_GET["id_categoria"])){
        
            $categoria = DB::obtenerQuery("SELECT * FROM categorias WHERE id=:id",['id'=>$_GET["id_categoria"]]);        
        $f->caracteristicas->setType(CRUD_types::JSON,$categoria["plantilla_caracteristicas"])->setName("Caracteristicas");
        $f->id_categorias->setVisible(false)->setDefaultData($_GET["id_categoria"]);
    }else{
        $f->caracteristicas->setType(CRUD_types::JSON)->setName("Caracteristicas");
    }
    
    $f->estado("estado");
    $f->precio("precio");
    $f->tipo("Tipo");
    $f->stock("stock");
    $f->imagen->setType(CRUD_types::IMAGE);
    $f->descripcion("Descripcion");
});
$crud->canCreate()
->setData(function(){
})
    ->onUpload(function($file){
        
        //$_POST["imagen"] = $algo["imagen"]["name"]."-archivo.jpg";
        
        //var_dump($algo);die();
        $_POST["imagen"] = $file["imagen"]["name"];
        return move_uploaded_file($file["imagen"]["tmp_name"], __DIR__ . '/../imagenes/' .$file["imagen"]["name"]);
    })    
    ->onSubmit(function($form){
        unset($form["id"]);
        
        $stmt = DB::insertar("producto",$form);
        if($stmt->rowCount() == 1){
            return true;
        }        
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->setData(function($id){

        return DB::obtenerQuery("SELECT * FROM producto WHERE id=:id",['id'=> $id]);
    })
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("producto",$form,'id');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList()
    //->setFields(["descripcion"])
    
    ->setData(function(){
        $stmt = DB::query("SELECT * FROM producto");
        $data = $stmt->fetchAll();
        foreach($data as & $row){
            $row["imagen"] = "<img src='".URL_BASE ."/imagenes/". $row["imagen"]."' style='max-width:60px; max-height:60px' />";
        }
        return $data;
        
    });
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("producto","id=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
$crud->show();
echo "<a class='btn btn-primary' href='productos_reporte.php'> GENERAR REPORTE </a>";

include_once __DIR__ .'/../vistas/footer.tpl.php';