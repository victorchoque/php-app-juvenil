<?php
include("../modelos/ClienteClase.php");
$cli = new Cliente("","","","");
//$res = $cli->listarCliente();
$titulo = "Clientes Busca";
if(!empty($_POST) && $_POST["buscar"]){
    $res = $cli->listarClienteBuscar($_POST["buscar"]);
    $titulo = $titulo . " '".  $_POST["buscar"] ."'";
}else{
    $res = $cli->listarCliente();
}
include("../vistas/clienteBuscaVista.php");