<?php
declare(strict_types=1);

namespace App\Model;

class Product
{
    private string $code;
    private string $name;
    private float $price;

    /**
     * @param string $code
     * @param string $name
     * @param float $price
     */
    public function __construct(string $code, string $name, float $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * Get the product code (SKU)
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Get the product's display name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the product price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}