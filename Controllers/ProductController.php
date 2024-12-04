<?php

namespace Controllers;
use DTO\CreateRequestProductDTO;
use Service\ProductService;
use Views\JsonResponse;
class ProductController extends AbstractController
{

    public  ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }
    public function getProductsList() :string
    {
        $result = $this->productService->getProducts();
        $response = new JsonResponse();
        return $response->setResponse($result);
    }

    public function getProductByCode() :string
    {
        $response = new JsonResponse();
        $code = htmlspecialchars($_POST['code']);
        if (empty($code) || !$this->checkMethod('POST')) {
            return $response->setResponse(['result' => 'Error!']);
        }
        $result = $this->productService->findByCode($code);
        return $response->setResponse($result);
    }

    public function createProduct() :string
    {
        $response = new JsonResponse();
        try {
            $request = $this->getRequestCreateProduct();
            $result = $this->productService->createProduct($request);
            return $response->setResponse(['status' => $result]);
        } catch ( \Throwable $exception) {
            return $response->setResponse([
                'status' => 'not ok',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function updatePrices()
    {
        $response = new JsonResponse();
        $json = json_decode(file_get_contents('php://input'), true);
        $result = $this->productService->updatePrices($json);
        return $response->setResponse(['status' => 'ok', 'update_codes' => $result]);
    }

    private function getRequestCreateProduct()
    {
        return new CreateRequestProductDTO(
            name: htmlspecialchars($_POST['name']),
            code:  htmlspecialchars($_POST['code']),
            price: htmlspecialchars($_POST['price']),
            colour: htmlspecialchars($_POST['colour'])
        );
    }
}