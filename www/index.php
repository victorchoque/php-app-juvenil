<?php
require __DIR__ . '/paginas/header.tpl.php';

if(isset($_GET["paginas"])){
    $anti_hack = preg_replace("/[^a-zA-Z0-9]/", "", $_GET["paginas"]);
    $tpl = __DIR__ . '/paginas/publico/'.$anti_hack.'.tpl.php';
    if(file_exists($tpl)){
        require $tpl;
    }else{
        echo "<H1 style='color:red'> La Pagina '". $_GET["paginas"] ."' no fue encontrada  </H1>";
    }
    
}else{
    require __DIR__ . '/paginas/publico/portada.tpl.php';
}



require __DIR__ . '/paginas/footer.tpl.php';