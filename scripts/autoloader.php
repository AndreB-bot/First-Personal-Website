<?php
spl_autoload_register(function ($class_name) {
    
    if($class_name === 'PHPMailer') {
        $class_name = strtolower($class_name);         
    }
    require_once('../classes/class.'.$class_name . '.php');
});