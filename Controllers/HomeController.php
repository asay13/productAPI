<?php

namespace Controllers;

use Models\GreetingModel;

class HomeController extends AbstractController
{
    public function index()
    {
        //Создаем модель и получаем данные
        $model = new GreetingModel();
        $greeting = $model->getGreeting();
        //Передаем данные в представление
        include dirname(__DIR__) . '/Views/home.php';
    }
}