<?php

class Cart
{
    protected array $products = [];
    protected array $services = [];

    public function __construct()
    {
        $this->products = [];
        $this->services = [];
    }

    public function getServiceInfo(Service $services): string
    {
        return json_encode([
            'deadline' => $services->getDeadline(),
            'runQueue' => $services->getRunQueue(),
            'cost' => $services->getCost(),
        ]);
    }

    public function getProductInfo(Product $products): string
    {
        return json_encode([
            'name' => $products->getName(),
            'manufactures' => $products->getManufactures(),
            'date' => $products->getDate(),
            'cost' => $products->getCost(),
        ]);
    }

    public function addProduct(Product $product): array|int
    {
        array_push($this->products, $product);
        if (!$this->services) {
            echo"<script language='javascript'>setTimeout(() => alert('Please, select appropriate service.'), 2000)</script>";
        }

        return $this->products ?? 0;
    }

    public function addService(Service $service): array|int
    {
        if ($this->products) {
            array_push($this->services, $service);
        } else {
            throw new \InvalidArgumentException('Please, select any product.');
        }

        return $this->services ?? 0;
    }

    public function calculateTotalSum()
    {
        $costOfProducts = [];
        foreach ($this->products as $product) {
            array_push($costOfProducts, $product->getCost());
        }

        $costOfServices = [];
        foreach ($this->services as $service) {
            array_push($costOfServices, $service->getCost());
        }

        $allCosts = array_merge($costOfProducts, $costOfServices);

        return array_sum($allCosts);
    }
}
