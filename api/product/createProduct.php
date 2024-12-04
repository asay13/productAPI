<?php
include dirname(__DIR__, 2) . '/core.php';
use Controllers\ProductController;
try {
    $controller = new ProductController();
    echo $controller->createProduct();
} catch (\Throwable $e) {
    echo $e->getMessage();
}