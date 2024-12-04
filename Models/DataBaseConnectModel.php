<?php

namespace Models;

abstract class DataBaseConnectModel
{
    protected string $user = 'root';
    protected string $password = 'root';
    protected string $db = 'db';
    protected string $host = 'localhost';
    protected int $port = 8889;

    protected function connectToDb()
    {
        try {
            $pdo = new \PDO(
                "mysql:host=$this->host;dbname=$this->db;port=$this->port",
                $this->user,
                $this->password
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }catch (\Throwable $exception) {
            die('Ошибка подключения: ' . $exception->getMessage());
        }
    }
}