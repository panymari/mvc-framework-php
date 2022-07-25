<?php

interface ProductInterface
{
    // getters
    public function getName(): string;
    public function getManufactures(): string;
    public function getDate(): string;
    public function getCost(): float;

    //setters
    public function setName(string $value);
    public function setManufactures(string $value);
    public function setDate(string $value);
    public function setCost(float $value);
}