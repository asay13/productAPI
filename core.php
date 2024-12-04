<?php
function autoload($className)
{
    $file =  __DIR__ . '\\'. $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
    return;
    echo "Класс {$className} не найден!";
}

spl_autoload_register('autoload');