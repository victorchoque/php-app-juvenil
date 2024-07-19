<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';

//$proveedor = DB::query("SELECT * FROM proveedor");

//require __DIR__.'/../vistas/proveedor_lista_vista.php';

include_once __DIR__ .'/../vistas/header.tpl.php';

$crud= new CRUD("🕺 proveedor","proveedor","id_proveedor");
$crud->setGlobalFields(function($f){
    //id_proveedor, empresa, contacto, mail, telefono, direccion, logo
    $f->id_proveedor->setVisible(false);

    $f->empresa("Empresa");
    $f->contacto("contacto");
    $f->mail("Correo");
    $f->telefono("telefono");
    $f->direccion("Direccion");    
    $f->logo->setType(CRUD_types::IMAGE);
});
$crud->canCreate()
    ->onUpload(function($file){
        
        //$_POST["imagen"] = $algo["imagen"]["name"]."-archivo.jpg";
        
        //var_dump($algo);die();
        $_POST["logo"] = $file["logo"]["name"];
        return move_uploaded_file($file["logo"]["tmp_name"], __DIR__ . '/../imagenes/' .$file["imagen"]["name"]);
    })    
    ->onSubmit(function($form){
        unset($form["id_proveedor"]);
        
        $stmt = DB::insertar("proveedor",$form);
        if($stmt->rowCount() == 1){
            return true;
        }        
        return "Error Desconocido";        
    })
    ;
$crud->canUpdate()
    ->setData(function($id){

        //return DB::obtenerQuery("SELECT * FROM proveedor WHERE id_proveedor=:id",['id'=> $id]);
        $row =  DB::obtenerQuery("SELECT * FROM proveedor WHERE id_proveedor=:id_proveedor",['id_proveedor'=> $id]);
        if($row["logo"]){
            $row["logo"] = "../imagenes/".$row["logo"];

        }
        return $row;
    })
    ->onUpload(function($file){
        
        //$_POST["imagen"] = $algo["imagen"]["name"]."-archivo.jpg";
        
        //var_dump($algo);die();
        $_POST["logo"] = $file["logo"]["name"];
        return move_uploaded_file($file["logo"]["tmp_name"], __DIR__ . '/../imagenes/' .$file["logo"]["name"]);
    })  
    ->onSubmit(function($form,$id){        
        $stmt = DB::editar("proveedor",$form,'id_proveedor');
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";      
    })
;
$crud->canList()
    //->setFields(["descripcion"])
    
    ->setData(function(){
        if(isset($_GET["buscar"])){
            $criterio = "%".$_GET["buscar"]."%";

            $stmt = DB::query("SELECT * FROM proveedor WHERE empresa LIKE '$criterio'");
            $data = $stmt->fetchAll();
            foreach($data as & $row){
                $row["logo"] = "<img src='".URL_BASE ."/imagenes/". $row["logo"]."' style='max-width:60px; max-height:60px' />";
            }
            return $data;
        }
        return [];
        
    });
$crud->canDelete()
    ->onSubmit(function($form,$id){
        $stmt = DB::borrar("proveedor","id_proveedor=?",[$id]);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido"; 
    });
echo "<form >
    <input class='form-control' name='buscar' placeholder='criterio de busqueda'><button>Buscar</button>
</form>";

$crud->show();
if(!isset($_GET["_ACTION"]) || $_GET["_ACTION"] == "list"){
    echo "<a class='btn btn-primary' href='proveedores_reporte.php'> GENERAR REPORTE </a>";
}


include_once __DIR__ .'/../vistas/footer.tpl.php';