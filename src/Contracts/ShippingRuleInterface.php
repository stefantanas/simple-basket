<?php

namespace App\Contracts;

interface ShippingRuleInterface
{
    /**
     * Calculates the shipping rate based on basket subtotal
     *
     * @param float $subtotal
     * @return float
     */
    public function calculateShipping(float $subtotal): float;
}