<?php
include("../modelos/ClienteClase.php");


if(!empty($_POST)){
    $nit = $_POST["NIT_CI"];
    $razon = $_POST["razonsocial"];
    $cli = new Cliente("",$nit,$razon ,"Activo");
    if($cli->grabarCliente()){
        ?>
        <script>
            alert("registro exitoso");
            location.href="clienteLista.php";
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
require(__DIR__."/../vistas/clienteRegistroVista.php");