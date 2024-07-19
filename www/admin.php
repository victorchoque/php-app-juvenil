<?php
require __DIR__.'/todo.php';
if(isset($_POST["user"]) && isset($_POST["pass"])){
    require __DIR__ .'/servicios/auth.php';
    if(login($_POST["user"],$_POST["pass"])){
        header("location: controladores/productos.php");
        die();
    }else{
        $ERROR = 'Datos de login incorrectos';
    }
}

require __DIR__.'/vistas/login.tpl.php';