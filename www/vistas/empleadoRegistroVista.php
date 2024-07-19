<?php require __DIR__ . '/header.tpl.php';?>
<h1><?=$titulo;?></h1>
<form method="post">
<table align="center">
    <tr>
        <td>cargo</td>
        <td>
            <select name="id_cargo" class="form-control">
<?php foreach($cargos as $k => $v){
    if(@$id_cargo == $k){
        echo "<option value='$k' selected>$v</option>";
    }else{
        echo "<option value='$k'>$v</option>";   
    }

}
    
    
    ?>

            </select>
        </td>
    </tr>
    <tr>
        <td>Carnet de identidad</td>
        <td>
            <input name="ci" type="number" value="<?=@$ci?>" class="form-control">
        </td>
    </tr>
    <tr>
        <td>nombre</td>
        <td>
            <input name="nombre" value="<?=@$nombre?>" class="form-control">
        </td>
    </tr>
    <tr>
        <td>paterno</td>
        <td>
            <input name="paterno" value="<?=@$paterno?>" class="form-control">
        </td>
    </tr>
    <tr>
        <td>materno</td>
        <td>
            <input name="materno" value="<?=@$materno?>" class="form-control">
        </td>
    </tr>
    <tr>
        <td>direccion</td>
        <td>
            <input name="direccion" value="<?=@$direccion?>" class="form-control">
        </td>
    </tr>
    <tr>
        <td>telefono</td>
        <td>
            <input name="telefono" type="number" value="<?=@$telefono?>" class="form-control">
        </td>
    </tr>
    <tr>
        <td>fecha de nacimiento</td>
        <td>
            <input name="Fecha_Nacimiento" type="date" value="<?=@$Fecha_Nacimiento?>" class="form-control">
        </td>
    </tr>
    <tr>
        <td>GENERO</td>
        <td>
<?php $generos = array("f"=>"femenino" , "m" =>"masculino");
    foreach($generos as $k=>$v){
        echo "<label>";
        if(@$genero == $k){
            echo "<input name='genero' type='radio' value='".$k."'  checked>";
        }else{
            echo "<input name='genero' type='radio' value='".$k."' >";
        }        
        echo " $v</label> | ";
    }
?>

            
        </td>
    </tr>
    <tr>
        <td>Intereses</td>
        <td>
<?php

$_interes = array("Estudia"=>"Estudia","Deporte"=>"Deporte","Trabaja"=>"Trabaja");
$interes_tmp =  isset($intereses)? explode(",",$intereses):array();
$_intereses_elegidos = array();
foreach($interes_tmp as $int){
    $_intereses_elegidos[$int] = $int;
}

foreach($_interes as $k=>$v){
    echo "<label>";
    if(isset($_intereses_elegidos[$k])){
        echo "<input name='intereses[]' type='checkbox' value='".@$k."'  checked>";
    }else{
        echo "<input name='intereses[]' type='checkbox' value='".@$k."' >";
    }        
    echo " $v</label> | ";
}

?>
        </td>
    </tr>

    <tr>
    <td colspan="2">
        <button type="submit"> GUARDAR </button>
    </td>
    </tr>
</table>
</form>
<hr>
<br>


<?php require __DIR__ . '/footer.tpl.php';?>