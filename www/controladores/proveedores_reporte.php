<?php 
require __DIR__ .'/../todo.php';
require __DIR__. "/../librerias/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$cli = new Proveedor();
$res = $cli->listarProveedor();

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
<h1>lista de  Productos</h1>
<table class="table" style="width:100%" width=100 border=1 cellspacing=0>
        <thead>
            <tr>
                <th scope="col"> Id</th>
                <th scope="col"> Empresa</th>
                <th>contacto</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Logo</th>

            </tr>
        </thead>
        <tbody>
HTML;

//id_proveedor, empresa, contacto, mail, telefono, direccion, logo
foreach($res as $row):
    $img = URL_BASE .'imagenes/'.$row["logo"];
    //echo $img;
    //die();
    $html.= <<<HTML

    <tr>
    <td scope="col"> {$row['id_proveedor']} </td>
    <td scope="col"> {$row['empresa']}</td>
    <td> {$row['contacto']}</td>
    <td> {$row['mail']}</td>
    <td> {$row['telefono']}</td>
    <td> {$row['direccion']}</td>
    <td><img src='{$img}' width=100></td>
    </tr>
HTML;
endforeach;


$html.= '</tbody></table></body></html>';

return $html;
}

