<?php
require __DIR__.'/../servicios/auth.php';
if(!is_authenticated()){
    header("location: ../index.php");
    die();
}