<?php


// Abstract class
abstract class Products
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

trait ProductTrait
{
    public function __construct($name, $manufactures, $date, $cost)
    {
        $this->name = $name;
        $this->manufactures = $manufactures;
        $this->date = $date;
        $this->cost = $cost;
    }

    // GETTERS
    public function getName(): string
    {
        return $this->name;
    }
    public function getManufactures(): string
    {
        return $this->manufactures;
    }
    public function getDate(): string
    {
        return $this->date;
    }
    public function getCost(): float
    {
        return $this->cost;
    }

    // SETTERS
    public function setName(string $value): self
    {
        $this->name = $value;

        return $this;
    }
    public function setManufactures(string $value): self
    {
        $this->manufactures = $value;

        return $this;
    }
    public function setDate(string $value): self
    {
        $this->date = $value;

        return $this;
    }
    public function setCost(float $value): self
    {
        $this->cost = $value;

        return $this;
    }
}
