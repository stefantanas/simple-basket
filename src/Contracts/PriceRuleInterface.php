<?php

namespace App\Contracts;

use App\Model\Basket;

interface PriceRuleInterface
{
    /**
     * Calculate discount based on the items in basket
     *
     * @param Basket $basket
     * @return float
     */
    public function applyPriceRule(Basket $basket): float;
}
