<?php
require __DIR__.'/todo.php';

require __DIR__ .'/servicios/auth.php';
logout();
header("location: index.php");
die();