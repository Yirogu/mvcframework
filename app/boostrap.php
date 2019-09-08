<?php
//load Config
require_once 'config/config.php';
require_once 'config/pass.php';
// Autoload Core Libraries
spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
});