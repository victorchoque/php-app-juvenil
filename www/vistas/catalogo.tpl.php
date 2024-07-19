<h1>CATALOGO de Productos</h1>
<div class="container">
    <div class="row">
<?php foreach($lista as $prod):  ?>
<div class="col-6 item" >
    <h3><?=$prod["nombreproducto"]?></h3>
    <img src="../imagenes/<?=$prod["imagen"]?>" style="max-width:100px">
    <p>Precio : <strong style="color:red"><?=$prod["precio"]?></strong></p>
    <code><?=$prod["descripcion"]?></code>
</div>
<?php endforeach;?>
</div>
</div>
<style>
    code{
        display:none
    }
    .item:hover code{
        display:block;
        position: absolute;
        top:20px;
        background-color:rgba(255,255,255,0.9);
        padding-top: 30px;
        padding-bottom: 30px;

    }
</style>