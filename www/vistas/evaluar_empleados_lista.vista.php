
<h1>Lista de usuarios evalaudos</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Evaluador</th>
            <th>Formulario</th>
            <th>Empleado</th>
            
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($rows as $row): ?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['evaluador']?></td>
            <td><?=$row['formulario']?></td>
            <td><?=$row['empleado']?></td>            
            <td>
                <a 
                class="btn btn-primary"
                href="evaluar_empleados.php?por=<?=$row['id_evaluador']?>&formulario=<?=$row['id_formulario']?>&empleado=<?=$row['id_empleado']?>"> ✅ ❎ Evaluar</a>            
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>