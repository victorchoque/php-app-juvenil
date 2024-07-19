<?php
require __DIR__. '/constantes.php';
require __DIR__. '/modelos/DB.php';
require __DIR__. '/modelos/Producto.class.php';
require __DIR__. '/modelos/Proveedor.class.php';
//require __DIR__. '/librerias/tuadmin/funciones.php';
require __DIR__. '/librerias/tuadmin/CRUD.php';
$url = sprintf('mysql://%s:%s@%s/%s', DB_USERNAME, DB_PASSWORD, DB_HOSTNAME, DB_NAME);
DB::init($url);
