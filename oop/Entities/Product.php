<?php


// Abstract class
abstract class Product
{
    protected string $name;
    protected string $manufactures;
    protected string $date;
    protected float $cost;

    // getters
    abstract public function getName(): string;
    abstract public function getManufactures(): string;
    abstract public function getDate(): string;
    abstract public function getCost(): float;

    //setters
    abstract public function setName(string $value);
    abstract public function setManufactures(string $value);
    abstract public function setDate(string $value);
    abstract public function setCost(float $value);
}


