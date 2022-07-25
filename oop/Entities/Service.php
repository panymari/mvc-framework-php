<?php

// Abstract class
abstract class Service implements ServiceInterface
{
    protected string $deadline;
    protected string $runQueue;
    protected float $cost;
}

