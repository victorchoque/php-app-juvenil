<?php
require __DIR__. '/constantes.php';
require __DIR__. '/modelos/DB.php';
require __DIR__. '/modelos/Producto.class.php';
require __DIR__. '/modelos/Proveedor.class.php';
//require __DIR__. '/librerias/tuadmin/funciones.php';
require __DIR__. '/librerias/tuadmin/CRUD.php';
require __DIR__. '/vendor/autoload.php';
//validar json con schema
/* //eejemplo
use Swaggest\JsonSchema\Schema;
$schema = Schema::import(json_decode($schemaJson));
$schema->in($array_del_json); //  Exception: cuando algo no esta bien
*/
$url = sprintf('mysql://%s:%s@%s/%s', DB_USERNAME, DB_PASSWORD, DB_HOSTNAME, DB_NAME);
DB::init($url);
