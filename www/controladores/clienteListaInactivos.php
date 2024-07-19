<?php
include("../modelos/ClienteClase.php");
$cli = new Cliente("","","","");
$res = $cli->listarClienteInactivo();
$titulo = "Clientes Inactivos";
include("../vistas/clienteListaVista.php");