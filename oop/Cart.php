<?php

//Users of your catalog should have the ability to select any product and service,
//read information about them and calculate total cost of selected items.
//Users should not be able to select any service if they didn't select any product.
//But if they select products, you should advise them to select appropriate service.


class Cart
{
    protected array $products = [];
    protected array $services = [];

    public function __construct()
    {
        $this->products = [];
        $this->services = [];
    }

    public function getServiceInfo(Services $services): string
    {
        return json_encode([
            'deadline' => $services->getDeadline(),
            'runQueue' => $services->getRunQueue(),
            'cost' => $services->getCost(),
        ]);
    }

    public function getProductInfo(Products $products): string
    {
        return json_encode([
            'name' => $products->getName(),
            'manufactures' => $products->getManufactures(),
            'date' => $products->getDate(),
            'cost' => $products->getCost(),
        ]);
    }

    public function addProduct(Products $product): array|int
    {
        array_push($this->products, $product);
        if (!$this->services) {
            echo"<script language='javascript'>setTimeout(() => alert('Please, select appropriate service.'), 2000)</script>";
        }

        return $this->products ?? 0;
    }

    public function addService(Services $service): array|int
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
        foreach ($this->products as $product) {
            array_push($costOfServices, $product->getCost());
        }

        $allCosts = array_merge($costOfProducts, $costOfServices);

        return array_reduce($allCosts, function ($carry, $item) {
            $carry += $item;

            return $carry;
        });
    }
}
