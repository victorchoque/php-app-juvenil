<?php
require_once __DIR__ . '/../todo.php';
class Producto{
    public function listarProducto(){
        $stmt = DB::query("SELECT * FROM producto");
        return $stmt->fetchAll();
    }
}