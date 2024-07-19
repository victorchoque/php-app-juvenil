<?php
include("../modelos/CargoClase.php");

$id = $_GET["id"];
$cargo_db = new Cargo($id,"");
$cargo_db->cargoObtiene();
$id_cargo = $cargo_db->getId();
$cargo = $cargo_db->getCargo();

if(!empty($_POST)){
    $cargo = $_POST["cargo"];
    //$cli = new Cargo($id,$cli->getNit(),$cli->getRazonsocial(),$cli->getEstado());
    if($cargo_db->actualizarCargo($cargo )){
        ?>
        <script>
            alert("actualizacion exitoso");
            location.href="cargoLista.php";
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
require(__DIR__."/../vistas/cargoRegistroVista.php");