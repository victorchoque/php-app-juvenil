<?php

include("../modelos/empleadoClase.php");
$id = $_GET["id"];
$empleado_db = new Empleado($id,"","","","","","","","","","","","");
$res = $empleado_db->eliminar();
if($res){
    ?>
    <script>
        alert("Se elimino correctamente al Empleado con id '$id'");
        location.href="empleadoLista.php"
    </script>
<?php
}
else
{
?>
    <script>
        alert("No se elimino por algun error");
        location.href="empleadoLista.php"
    </script>

<?php
}