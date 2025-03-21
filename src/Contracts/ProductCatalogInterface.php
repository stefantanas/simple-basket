<?php

namespace App\Contracts;

use App\Model\Product;

interface ProductCatalogInterface
{
    /**
     * Returns product by product code or null if no product is found
     *
     * @param string $code
     * @return Product|null
     */
    public function getProductByCode(string $code): ?Product;
}