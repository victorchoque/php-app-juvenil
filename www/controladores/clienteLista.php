<?php
include("../modelos/ClienteClase.php");
$cli = new Cliente("","","","");
$res = $cli->listarCliente();
$titulo = "Clientes ACTIVOS";
include("../vistas/clienteListaVista.php");