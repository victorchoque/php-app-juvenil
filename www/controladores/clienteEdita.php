<?php
include("../modelos/ClienteClase.php");

$id = $_GET["id"];
$cli = new Cliente($id,"","","");
$cli->clienteObtiene();
$NIT_CI = $cli->getNit();
$razonsocial = $cli->getRazonsocial();
$estado = $cli->getEstado();


if(!empty($_POST)){
    $NIT_CI = $_POST["NIT_CI"];
    $razonsocial = $_POST["razonsocial"];
    $estado =  $_POST["estado"];
    //$cli = new Cliente($id,$cli->getNit(),$cli->getRazonsocial(),$cli->getEstado());
    if($cli->actualizarCliente($NIT_CI,$razonsocial,$estado )){
        ?>
        <script>
            alert("actualizacion exitoso");
            location.href="clienteLista.php";
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
require(__DIR__."/../vistas/clienteEditaVista.php");