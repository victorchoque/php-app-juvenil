<?php
class Conexion extends mysqli{

    public function __construct(){
        //parent::__construct("localhost","root","","juvenil");
        parent::__construct("127.0.0.1","root","mysql","juvenil");

    }
}