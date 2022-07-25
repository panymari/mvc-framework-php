<?php

interface ServiceInterface
{
    // getters
    public function getDeadline(): string;
    public function getRunQueue(): string;
    public function getCost(): float;

    // setters
    public function setDeadline(string $value);
    public function setRunQueue(string $value);
    public function setCost(float $value);
}