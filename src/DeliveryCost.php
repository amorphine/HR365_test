<?php

namespace Amorphine\DeliveryTest;

class DeliveryCost
{
    public float $price;
    public string $date;
    public string $error;

    /**
     * @param float $price
     * @param string $date
     * @param string $error
     */
    public function __construct(float $price, string $date, string $error = '')
    {
        $this->price = $price;
        $this->date = $date;
        $this->error = $error;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }
}
