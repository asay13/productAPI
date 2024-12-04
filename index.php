<?php
include 'core.php';
use Controllers\HomeController;
try {
    $controller = new HomeController();
    $controller->index();
} catch (\Throwable $e) {
    echo $e->getMessage();
}