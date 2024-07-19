<?php
include("../modelos/EmpleadoClase.php");
include("../modelos/CargoClase.php");
$titulo = "Registrar Nuevo Empleado";
$id_cargo="";
$cargos_db = new Cargo(0,"");
$cargos = $cargos_db->listarCargoArray();
if(!empty($_POST)){
    //$empleado = $_POST["empleado"];
    //$campos = array("ci","nombre","paterno","materno","direccion","telefono","Fecha_Nacimiento","genero","intereses","id_cargo");
    $empleado_db = new Empleado(0,"","","","","","","","","","","","");

/*
    foreach($campos as $f){
        $data = $_POST[$f];
        if(is_array($data)){
            $data = implode(",",$data);
        }
        $empleado_db->$f = $data;
    } */
    $empleado_db->llenarDatosDeFormulario($_POST);
    if($empleado_db->registrar()){
        ?>
        <script>
            alert("registro exitoso");
            location.href="empleadoLista.php";
        </script>
    <?php
    }else{
?>
        <script>
            alert("no se registro");           
        </script>
<?php

    }
}
require(__DIR__."/../vistas/empleadoRegistroVista.php");