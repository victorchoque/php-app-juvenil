<?php
include("../modelos/EmpleadoClase.php");

include("../modelos/CargoClase.php");
$id_cargo="";
$cargos_db = new Cargo(0,"");
$cargos = $cargos_db->listarCargoArray();

$id = $_GET["id"];
$empleado_db = new Empleado($id,"","","","","","","","","","","","");

//$id_empleado = $empleado_db->getId();
//$empleado = $empleado_db->getempleado();

if($empleado_db->obtener($id)){
    $id_empleado = $empleado_db->get_id_empleado();
    $ci = $empleado_db->get_ci();
    $nombre = $empleado_db->get_nombre();
    $paterno = $empleado_db->get_paterno();
    $materno = $empleado_db->get_materno();
    $direccion = $empleado_db->get_direccion();
    $telefono = $empleado_db->get_telefono();
    $Fecha_Nacimiento = $empleado_db->get_Fecha_Nacimiento();
    $genero = $empleado_db->get_genero();
    $intereses = $empleado_db->get_intereses();
    $id_cargo = $empleado_db->get_id_cargo();

    $titulo = "Editar Empleado '$nombre $paterno $materno'";
}else{
    $titulo = "Este Empleado no existe!";
}


if(!empty($_POST)){
    $empleado_db->llenarDatosDeFormulario($_POST);
    //$cli = new empleado($id,$cli->getNit(),$cli->getRazonsocial(),$cli->getEstado());
    if($empleado_db->actualizar()){
        ?>
        <script>
            alert("actualizacion exitoso");
            location.href="empleadoLista.php";
        </script>
    <?php
    }else{
?>
        <script>
            alert("no se actuailizo");           
        </script>
<?php

    }
}
require(__DIR__."/../vistas/empleadoRegistroVista.php");