<?php
include("../modelos/CargoClase.php");


if(!empty($_POST)){
    $cargo = $_POST["cargo"];
    $cargo = new Cargo("",$cargo );
    if($cargo->insert()){
        ?>
        <script>
            alert("registro exitoso");
            location.href="cargoLista.php";
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
require(__DIR__."/../vistas/cargoRegistroVista.php");