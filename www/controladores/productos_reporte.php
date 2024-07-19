<?php 
require __DIR__ .'/../todo.php';
require __DIR__. "/../librerias/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$cli = new Producto();
$res = $cli->listarProducto();

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
                <th scope="col"> nombreproducto</th>
                <th>descripcion</th>
                <th>estado</th>
                <th>precio</th>
                <th>stock</th>
                <th>tipo</th>
                <th>
                    imagen</th>
            </tr>
        </thead>
        <tbody>
HTML;


foreach($res as $row):
    $img = URL_BASE .'imagenes/'.$row["imagen"];
    //echo $img;
    //die();
    $html.= <<<HTML

    <tr>
    <td scope="col"> {$row['id']} </td>
    <td scope="col"> {$row['nombreproducto']}</td>
    <td> {$row['descripcion']}</td>
    <td> {$row['estado']}</td>
    <td> {$row['precio']}</td>
    <td> {$row['stock']}</td>
    <td> {$row['tipo']}</td>
    <td><img src='{$img}' width=100></td>
    </tr>
HTML;
endforeach;


$html.= '</tbody></table></body></html>';

return $html;
}

