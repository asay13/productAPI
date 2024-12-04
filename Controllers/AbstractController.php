<?php

namespace Controllers;

abstract class AbstractController
{
    public function checkMethod(string $method): bool
    {
        return $_SERVER['REQUEST_METHOD'] == $method;
    }
}