<?php require __DIR__ . '/header.tpl.php';?>
<h1><?=$titulo;?></h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col"> Id Cliente</th>
                <th scope="col"> Nit Ci</th>
                <th scope="col"> Razon Social </th>
                <th scope="col"> Estado </th>
                <th scope="col"> </th>
            </tr>
        </thead>
        <tbody>
<?php 

while($row = mysqli_fetch_assoc($res)):?>
    <tr>
        <td><?=$row["id_cliente"]?></td>
        <td><?=$row["NIT_CI"]?></td>
        <td><?=$row["razonsocial"]?></td>
        <td><?=$row["estado"]?></td>
        <td><a class="btn btn-danger" href="clienteInactiva.php?id=<?=$row['id_cliente']?>">Eliminar</a>
            <a class="btn btn-warning" href="clienteEdita.php?id=<?=$row['id_cliente']?>" >Modifica</a>
            
        </td>
    </tr>
<?php endwhile;?>
        </tbody>
    </table>

    <a href="clienteRegistroControlador.php" class="btn btn-primary">
        + Nuevo 
    </a>
    <hr>
<?php require __DIR__ . '/footer.tpl.php';?>