<?php require __DIR__ . '/header.tpl.php';?>
<h1><?=$titulo;?></h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col"> Id Cargo</th>
                <th scope="col">Cargo</th>

            </tr>
        </thead>
        <tbody>
<?php 

while($row = mysqli_fetch_assoc($res)):?>
    <tr>
        <td><?=$row["id_cargo"]?></td>
        <td><?=$row["cargo"]?></td>
        <td>
            <!-- <a class="btn btn-danger" href="cargoBorra.php?id=<?=$row['id_cargo']?>" onclick="return confirm('Esta Seguro de Eliminar :<?=$row['cargo']?>:')">Eliminar</a> -->
            <a class="btn btn-warning" href="cargoEdita.php?id=<?=$row['id_cargo']?>" >Modifica</a>            
        </td>
    </tr>
<?php endwhile;?>
        </tbody>
    </table>
    <a href="cargoRegistro.php" class="btn btn-primary">
        + Nuevo  Cargo
    </a>
<hr>

<?php require __DIR__ . '/footer.tpl.php';?>