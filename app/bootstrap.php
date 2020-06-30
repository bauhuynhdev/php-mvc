<?php

require_once 'config/config.php';

spl_autoload_register(function ($className) {
    require_once 'core/' . $className . '.php';
    print_r($className);
});

$app = new App();
