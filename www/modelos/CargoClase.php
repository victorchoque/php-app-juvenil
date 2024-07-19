<?php
require_once "Conexion.php";
class Cargo{
    private $id;
    private $cargo;
    public function __construct($id,$cargo){
        $this->id = $id;
        $this->cargo = $cargo;
    }
    public function getId(){

       return $this->id; 
    }
    public function getCargo(){

        return $this->cargo; 
     }
    public function listarCargo(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    SELECT 
        *
    FROM cargo
SQL
);
        return $sql;
    }

    public function listarCargoArray(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    SELECT 
        id_cargo,cargo
    FROM cargo
SQL
);
    $retornar = array();
    while($row = mysqli_fetch_assoc($sql)):
        $retornar[$row["id_cargo"]] = $row["cargo"];
    endwhile;
        return $retornar;
    }

    public function insert(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
INSERT INTO cargo
    (cargo)
VALUES
    ('$this->cargo');

SQL
);

        return $sql;
    }

    public function cargoObtiene(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    SELECT 
        *
    FROM cargo
    WHERE id_cargo= {$this->id}

SQL
);

        

        if($sql){

            $row = mysqli_fetch_assoc($sql);
            $this->id = $row["id_cargo"];
            $this->cargo = $row["cargo"];    
            
        }

        return $sql;
    }
    public function actualizarCargo($cargo_nuevo){

        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    UPDATE `cargo`
    SET
        `cargo` = '{$cargo_nuevo}'
    WHERE `id_cargo` = {$this->id};
SQL
);
        return $sql;
    }
}