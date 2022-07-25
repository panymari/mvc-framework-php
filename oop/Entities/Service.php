<?php

// Abstract class
abstract class Service
{
    protected string $deadline;
    protected string $runQueue;
    protected float $cost;

    // getters
    abstract public function getDeadline(): string;
    abstract public function getRunQueue(): string;
    abstract public function getCost(): float;

    // setters
    abstract public function setDeadline(string $value);
    abstract public function setRunQueue(string $value);
    abstract public function setCost(float $value);
}

