<?php
require_once "Conexion.php";
class Empleado{
    private $id_empleado;
    private $ci;
    private $nombre;
    private $paterno;
    private $materno;
    private $direccion;
    private $telefono;
    private $Fecha_Nacimiento;
    private $genero;
    private $intereses;
    private $id_cargo; 

    private $_fields = array(//"id_empleado", //autoincremental, este dato no va en los UPDATE e INSERT
    "ci","nombre","paterno","materno","direccion","telefono","Fecha_Nacimiento","genero","intereses","id_cargo");
    public function __construct($id_empleado,
    $ci,
    $nombre,
    $paterno,
    $materno,
    $direccion,
    $telefono,
    $Fecha_Nacimiento,
    $genero,
    $intereses,
    $id_cargo ){
        $this->id_empleado = $id_empleado;
        $this->ci = $ci;
        $this->nombre = $nombre;
        $this->paterno = $paterno;
        $this->materno = $materno;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->Fecha_Nacimiento = $Fecha_Nacimiento;
        $this->genero = $genero;
        $this->intereses = $intereses;
        $this->id_cargo = $id_cargo; 
    }
    public function llenarDatosDeFormulario($post_or_get){
        $that = &$this;
        foreach($this->_fields as $f){
            $data = $post_or_get[$f];
            if(is_array($data)){
                $data = implode(",",$data);
            }
            //var_dump($f);
            $this->$f = $data;
        }
        return $this;
    }
    public function loadFromPost(){
        $that = &$this;
        foreach($this->_fields as $f){
            $that->$f = $_POST[$f];
        }
        return $this;
    }
    public function registrar(){
        //include("Conexion.php");
        $db = new Conexion();
        $tmp_fields = implode(",",$this->_fields);
        $tmp_values_array = [];
        foreach($this->_fields as $f){
            $tmp_values_array[] = $this->$f;
        }
        $tmp_values = implode("','",$tmp_values_array);
        $sql =  $db->query(<<<SQL
        
INSERT INTO empleado
    ($tmp_fields)
VALUES
    ('$tmp_values');

SQL
);

        return $sql;
    }
    public function actualizar(){
        //include("Conexion.php");
        $db = new Conexion();
        $tmp_fields = implode(",",$this->_fields);
        $tmp_values_array = [];
        foreach($this->_fields as $f){
            $tmp_values_array[] = "$f='".($this->$f)."'";
        }
        $tmp_fields = implode(", ",$tmp_values_array);
        $sql =  $db->query(<<<SQL

UPDATE empleado SET
    $tmp_fields
WHERE id_empleado = $this->id_empleado
    

SQL
);

        return $sql;


        /*
        
        
        UPDATE `juvenil`.`empleado`
SET
`id_empleado` = <{id_empleado: }>,
`ci` = <{ci: }>,
`nombre` = <{nombre: }>,
`paterno` = <{paterno: }>,
`materno` = <{materno: }>,
`direccion` = <{direccion: }>,
`telefono` = <{telefono: }>,
`Fecha_Nacimiento` = <{Fecha_Nacimiento: }>,
`genero` = <{genero: }>,
`intereses` = <{intereses: }>,
`id_cargo` = <{id_cargo: }>
WHERE `id_empleado` = <{expr}>;

        */
    }


    public function lista(){
        $db = new Conexion();
        $sql =  $db->query(<<<SQL

        SELECT * FROM empleado

SQL
);
        return $sql;
    }
    public function obtener($id){
        $db = new Conexion();
        $sql =  $db->query(<<<SQL

        SELECT * FROM empleado WHERE id_empleado=$id
SQL
);
        if($sql){
            $row = mysqli_fetch_assoc($sql);
            foreach($row as $k => $v){
    
                $this->$k = $v;
            }
            return true;
        }
        return false;

    }
    public function eliminar(){
        $db = new Conexion();
        $sql =  $db->query(<<<SQL

        DELETE FROM empleado WHERE id_empleado={$this->id_empleado}
SQL
);
        return $sql;
    }
    /* GETTERS */
    function get_id_empleado(){
        return $this->id_empleado;
    }
    function get_ci(){
        return $this->ci;
    }
    function get_nombre(){
        return $this->nombre;
    }
    function get_paterno(){
        return $this->paterno;
    }
    function get_materno(){
        return $this->materno;
    }
    function get_direccion(){
        return $this->direccion;
    }
    function get_telefono(){
        return $this->telefono;
    }
    function get_Fecha_Nacimiento(){
        return $this->Fecha_Nacimiento;
    }
    function get_genero(){
        return $this->genero;
    }
    function get_intereses(){
        return $this->intereses;
    }
    function get_id_cargo(){
        return $this->id_cargo; 
    }
}
