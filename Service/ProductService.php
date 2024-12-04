<?php

namespace Service;
use DTO\CreateRequestProductDTO;
use Models\ProductModel;

class ProductService
{
    public  ProductModel $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }
    public function getProducts()
    {
        $result = $this->model->getAll();

        return $this->prepareResponse($result);
    }

    public function findByCode(string $code)
    {
        $result = $this->model->findByCode($code);
        return current($this->prepareResponse($result));
    }

    public function createProduct(CreateRequestProductDTO $productDTO)
    {
        $arProduct = $this->model-> findByCode($productDTO->code);
        if (!empty($arProduct)) {
            throw new \Exception('Продукт с таким кодом уже существует');
        }
        $this->model->add($productDTO);
        return 'ok';

    }

    public function updatePrices(array $arPrices)
    {
        $arCodes = [];
        foreach ($arPrices as $arPrice) {
            $arCodes[] = $arPrice['code'];
        }
        if (!empty($arCodes)) {
            $arProduct = $this->model->findByCode($arCodes);
            if (empty($arProduct)) {
                throw new \Exception('Продуктов с заданными кодами не существует');
            }
            $updateCodes = [];
            foreach ($arPrices as $arPrice) {
                foreach ($arProduct as $item) {
                    if ($item['CODE'] == $arPrice['code']) {
                        $updateCodes[$arPrice['code']] = $arPrice;
                    }
                }
            }
            if (!empty($updateCodes)) {
                $this->model->multyUpdate($updateCodes);
                return array_keys($updateCodes);
            }
        }
    }

    private function prepareResponse(array $products)
    {

        $result = [];
        foreach ($products as $product) {
            $result [] = [
                'id' => $product['ID'],
                'product_code' => $product['CODE'],
                'product_name' => $product['NAME'],
                'price' => $product['PRICE'],
                'colour' => $product['COLOUR'],
            ];
        }
        return $result;
    }
}