<?php

trait ServiceTrait
{
    public function __construct($deadline, $runQueue, $cost)
    {
        $this->deadline = $deadline;
        $this->runQueue = $runQueue;
        $this->cost = $cost;
    }

    // GETTERS
    public function getDeadline(): string
    {
        return $this->deadline;
    }
    public function getRunQueue(): string
    {
        return $this->runQueue;
    }
    public function getCost(): float
    {
        return $this->cost;
    }

    //SETTERS
    public function setDeadline(string $value): self
    {
        $this->deadline = $value;

        return $this;
    }
    public function setRunQueue(string $value): self
    {
        $this->runQueue = $value;

        return $this;
    }
    public function setCost(float $value): self
    {
        $this->cost = $value;

        return $this;
    }
}
