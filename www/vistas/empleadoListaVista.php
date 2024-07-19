<?php require __DIR__ . '/header.tpl.php';
//"ci","nombre","paterno","materno","direccion","telefono","Fecha_Nacimiento","genero","intereses","id_cargo"
?>
<h1><?=$titulo;?></h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col"> Id Empleado</th>
                <th scope="col"> nombre</th>
                <th scope="col"> paterno </th>
                <th scope="col"> materno </th>
                <th scope="col"> direccion</th>
                <th scope="col"> telefono</th>
                <th scope="col"> Fecha_Nacimiento</th>
                <th scope="col"> genero</th>
                <th scope="col"> intereses</th>
                <th scope="col"> id_cargo</th>


            </tr>
        </thead>
        <tbody>
<?php 

while($row = mysqli_fetch_assoc($res)):?>
    <tr>
        <td><?=$row["id_empleado"]?></td>
        <td><?=$row["nombre"]?></td>
        <td><?=$row["paterno"]?></td>
        <td><?=$row["materno"]?></td>
        <td><?=$row["direccion"]?></td>
        <td><?=$row["telefono"]?></td>
        <td><?=$row["Fecha_Nacimiento"]?></td>

        <td><?=$row["genero"]?></td>
        <td><?=$row["intereses"]?></td>
        <td><?=$row["id_cargo"]?></td>
        <td><a class="btn btn-danger" href="empleadoBorra.php?id=<?=$row['id_empleado']?>">Eliminar</a>
            <a class="btn btn-warning" href="empleadoEdita.php?id=<?=$row['id_empleado']?>" >Modifica</a>
            
        </td>
    </tr>
<?php endwhile;?>
        </tbody>
    </table>

    <a href="empleadoRegistro.php" class="btn btn-primary">
        + Nuevo 
    </a>
    <hr>
<?php require __DIR__ . '/footer.tpl.php';?>