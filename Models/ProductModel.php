<?php

namespace Models;

use DTO\CreateRequestProductDTO;

class ProductModel extends DataBaseConnectModel
{

    public function getTableName()
    {
        return 'products';
    }

    public function getAll()
    {
        $pdo = $this->connectToDb();
        $sql = "SELECT * FROM `". $this->getTableName() . "`";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function findByCode($code)
    {
        $pdo = $this->connectToDb();
        $symbol = is_array($code) ? 'IN': '=';
        if (is_array($code)) {
            foreach ($code as $key => $item) {
                $code[$key] = "'$item'";
            }
            $code = "(" .implode(', ', $code). ")";
        } elseif (is_string($code)) {
            $code = "'$code'";
        }
        $sql = "SELECT * FROM `". $this->getTableName() . "` WHERE `CODE` $symbol $code ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function add(CreateRequestProductDTO $productDTO)
    {
        $pdo = $this->connectToDb();
        $tableName = $this->getTableName();
        $sql = "INSERT INTO `$tableName` (`NAME`, `CODE`, `PRICE`, `COLOUR`)
                VALUES ('$productDTO->name', '$productDTO->code', $productDTO->price, '$productDTO->colour')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function multyUpdate($updateCodes)
    {
        $tableName = $this->getTableName();
        $sql = "UPDATE $tableName SET `PRICE` = CASE `CODE` ";
        foreach ($updateCodes as $updateCode) {
            $sql .= "WHEN '" . $updateCode['code'] . "' THEN " . $updateCode['price']. " ";
        }
        $sql .= "ELSE `PRICE` END ";
        foreach (array_keys($updateCodes) as $key => $item) {
            $code[$key] = "'$item'";
        }
        $sql .= "WHERE `CODE` IN (" . implode(', ', $code). ")";

        $pdo = $this->connectToDb();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
}