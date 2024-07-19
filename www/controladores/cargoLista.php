<?php

include("../modelos/CargoClase.php");
$cli = new Cargo(0,"");
$res = $cli->listarCargo();
$titulo = "Cargo Lista";
include("../vistas/cargoListaVista.php");