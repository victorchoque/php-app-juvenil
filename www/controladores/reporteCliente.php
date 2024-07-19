<?php 
include("../modelos/ClienteClase.php");
require __DIR__. "./../dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$cli = new Cliente("","","","");
$res = $cli->listarCliente();

$dompdf =  new Dompdf(array("enable_remote"=>true));
//$dompdf->loadHtml("Hola mindo");
$dompdf->loadHtml(mostrarTabla());
$dompdf->setPaper("LETTER","portrait");
$dompdf->render();

header("Content-type: application/pdf");
header("Content-disposition: inline; filename=documento.pdf");
echo $dompdf->output();

function mostrarTabla(){
global $res;

$html= <<<HTML
<html><head></head><body>
<h1>Reporte Lista Clientes</h1>
<table class="table" style="width:100%" width=100 border-collapse="collapse" border=1 cellspacing=0>
        <thead>
            <tr>
                <th scope="col"> Id Cliente</th>
                <th scope="col"> Nit Ci</th>
                <th scope="col"> Razon Social </th>
                <th scope="col"> Estado </th>

            </tr>
        </thead>
        <tbody>
HTML;


while($row = mysqli_fetch_assoc($res)):
    $html.= <<<HTML

    <tr>
        <td>{$row["id_cliente"]}</td>
        <td>{$row["NIT_CI"]}</td>
        <td>{$row["razonsocial"]}</td>
        <td>{$row["estado"]}</td>

    </tr>
HTML;
endwhile;

$html.= '</tbody></table></body></html>';

return $html;
}

