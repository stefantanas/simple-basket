<?php

namespace App\Contracts;

interface BasketServiceInterface
{
    /**
     * Add product to basket
     *
     * @param string $productCode
     * @return void
     */
    public function addItem(string $productCode): void;

    /**
     * Get basket total
     *
     * @return float
     */
    public function getTotal(): float;
}