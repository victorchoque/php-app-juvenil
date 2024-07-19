<?php
require_once __DIR__ .'/TuCrud/interfaces/IAction.php';
require_once __DIR__ .'/TuCrud/interfaces/IActionButton.php';

$test = new TuCrud();
$test->executeCustomAction();

$test->newAction(TuCrud::ACTION_CREATE)
    ->setFields(["descripcion"])
    ->onSubmit(function($form){
        unset($form["id"]);
        
        $stmt = DB::insertar("areas",$form);
        if($stmt->rowCount() == 1){
            return true;
        }
        return "Error Desconocido";        
    })
    ->addButton("list","Volver a la Lista",function(){
        return "?";
    })
    ->addButton("save","Guardar",function(){
        return "Guardar";
    })
    ;

