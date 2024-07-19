<?php
 include("Conexion.php");
class Cliente{
    private $id;
    private $nit;
    private $razon;
    private $estado;
    public function __construct($i,$n,$r,$e){
        $this->id = $i;
        $this->nit = $n;
        $this->razon = $r;
        $this->estado = $e;
    }
    public function getNit(){
        return $this->nit;
    }
    public function getRazonsocial(){
        return $this->razon;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function clienteObtiene(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    SELECT 
        *
    FROM cliente
    WHERE id_cliente= {$this->id}
SQL
);
        
        if($sql){

            $row = mysqli_fetch_assoc($sql);
            $this->nit = $row["NIT_CI"];
            $this->razon = $row["razonsocial"];
            $this->estado = $row["estado"];
            
        }
        
        return $sql;

    }
    public function actualizarCliente($nit,$razon,$estado){
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    UPDATE `cliente`
    SET
        `razonsocial` = '{$razon}',
        `NIT_CI` = '{$nit}',
        `estado` = '{$estado}'
    WHERE `id_cliente` = {$this->id};

SQL
);
        return $sql;
    }
    public function actualizarEstado($estado){
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    UPDATE `cliente`
    SET
        `estado` = '{$estado}'
    WHERE `id_cliente` = {$this->id};
SQL
);
        return $sql;
    }
    public function grabarCliente(){
       
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    INSERT INTO cliente(nit_ci,razonsocial,estado)
    VALUES ( '$this->nit', '$this->razon','$this->estado' )    
SQL
);
        return $sql;
    }
    public function listarCliente(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    SELECT 
        *
    FROM cliente
    WHERE estado='Activo'
SQL
);
        return $sql;
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
    public function listarClienteBuscar($criterio){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    SELECT 
        *
    FROM cliente
    WHERE estado='Activo'
        AND ( nit_ci LIKE '%$criterio%' OR razonsocial LIKE '%$criterio%' )
SQL
);
        return $sql;
    }
    public function listarClienteInactivo(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    SELECT 
        *
    FROM cliente
    WHERE estado='Inactivo'
SQL
);
        return $sql;
    }
    public function eliminarCliente(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    UPDATE cliente
        SET        
        estado = 'Inactivo'
        WHERE id_cliente = "$this->id"

SQL
);
        return $sql;

    }
    public function activarCliente(){
        //include("Conexion.php");
        $db = new Conexion();
        $sql =  $db->query(<<<SQL
    UPDATE cliente
        SET        
        estado = 'Activo'
        WHERE id_cliente = "$this->id"

SQL
);
        return $sql;

    }

}