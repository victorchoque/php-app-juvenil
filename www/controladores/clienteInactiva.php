<?php

include("../modelos/ClienteClase.php");
$id = $_GET["id"];
$cli = new Cliente($id,"","","");
$res = $cli->eliminarCliente();
if($res){
    ?>
    <script>
        alert("Se elimino correctamente");
        location.href="clienteLista.php"
    </script>
<?php
}
else
{
?>
    <script>
        alert("No se elimino, esta implicado en una venta");
        location.href="clienteLista.php"
    </script>

<?php
}