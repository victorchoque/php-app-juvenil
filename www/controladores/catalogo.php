<?php
require __DIR__ ."/../todo.php";      
require __DIR__ .'/privado.php';
$stmt = DB::listar("producto","*");
$lista =  $stmt->fetchAll(PDO::FETCH_ASSOC);
include_once __DIR__ .'/../vistas/header.tpl.php';
include_once __DIR__ .'/../vistas/catalogo.tpl.php';
include_once __DIR__ .'/../vistas/footer.tpl.php';