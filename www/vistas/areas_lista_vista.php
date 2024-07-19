<?php require __DIR__.'/header.tpl.php'; ?>
<article>
<?php
    mostrarTabla($areas, 
    array('id' => 'ID', 'nombre' => 'Nombre'), 
    function($row){
        echo "<a href='areas_form.php?id=".$row['id']."'>Editar</a>";
        echo " | ";
        echo "<a href='areas_eliminar.php?id=".$row['id']."'>Eliminar</a>";
    }, array('id'));
?>
</article>
<?php require __DIR__.'/footer.tpl.php'; ?>