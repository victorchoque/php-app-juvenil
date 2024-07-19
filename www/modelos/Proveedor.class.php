<?php
require_once __DIR__ . '/../todo.php';
class Proveedor{
    public function listarProveedor(){
        $stmt = DB::query("SELECT * FROM proveedor");
        return $stmt->fetchAll();
    }
}