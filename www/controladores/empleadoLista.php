<?php

include("../modelos/EmpleadoClase.php");
$empleado = new Empleado(0,"","","","","","","","","","","","");
$res = $empleado->lista();
$titulo = "Empleado Lista";
include("../vistas/empleadoListaVista.php");