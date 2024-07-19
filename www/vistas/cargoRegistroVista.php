<?php require __DIR__ . '/header.tpl.php';?>
<form method="post">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="row gutters">
                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="inputName">Cargo</label>
                            <input required type="text" class="form-control" id="inputName" placeholder="cargo" name="cargo" value="<?=@$cargo?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <button class="btn btn-success">GUARDAR</button>
    <a href="cargoLista.php" class="btn btn-danger">Cancelar</a>

</form>

<?php require __DIR__ . '/footer.tpl.php';?>