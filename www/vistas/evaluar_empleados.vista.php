
<h1>EVALUACION TRIMESTRAL DEL PERSONAL DE LA U.E.P.N.H.P.</h1>
<h2>Nombre Completo Empleado:<?=$data["empleado"]?></h2>
<h2>Cargo:<?=$data["empleado_cargo"]?></h2>
<h2>Area:<?=$data["empleado_area"]?></h2>

<h3>cuestionario de <?=$data["formulario"]?></h3>
<form method="post">
<table class="table">
    <thead>
    <tr>
            <th></th>          
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr> 
        <tr valign="top">
            <th colspan=4 style="text-align:right">usuario3</th> 
            <th class="text-success" rowspan=4 style="border-right:2px solid gray">|</th>
        </tr> 
        <tr valign="top">
            <th colspan=3 style="text-align:right">usuario2</th>
            <th class="text-success" rowspan=3 style="border-right:2px solid gray"> |</th>
        </tr> 
        <tr valign="middle">
            <th colspan=2 style="text-align:right">usuario1</th>
            <th class="text-success" rowspan=2 style="border-right:2px solid gray">|</th>
        </tr>        
        <tr>
            <th>criterio</th>
            <th>preguntas</th>
            <!--
            <th>usuario2</th>
            <th>usuario3</th>  -->          
        </tr>
    </thead>
    <tbody>
        <?php foreach($secciones as $titulo => $seccion): ?>
            <?php 
                $contar = 0;
                foreach($seccion as $info): 
                $contar++;
                ?>        
        <tr>
            <?php if($contar==1):?> <td rowspan="<?=count($seccion)?>"><?=$titulo?></td> <?php endif;?>
            <td><?=$info['pregunta']?></td>
            <td><?=$info['usuario1']?></td>
            <td><?=$info['usuario2']?></td>
            <td><?=$info['usuario3']?></td>            
        </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
    <thead>
        <tr>
            <td colspan=2> Puntajes Subtotales:</td>
            <td><input type="number" placeholder="0" required></td>
            <td><?=$puntajes["usuario2"]?></td>
            <td><?=$puntajes["usuario3"]?></td>
        </tr>
        <tr>
            <td colspan=2> </td>
            <td>
                <button class='btn btn-success'>GUARDAR</button>    

            </td>
            
        </tr>
    </thead>    
</table>
            </form>