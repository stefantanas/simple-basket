<?php
declare(strict_types=1);

namespace App\Repository;

use App\Contracts\ProductCatalogInterface;
use App\Model\Product;

class ProductCatalog implements ProductCatalogInterface
{
    /** @var Product[] */
    private array $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Returns a product by product code from the catalog
     *
     * @param string $code
     * @return Product|null
     */
    public function getProductByCode(string $code): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->getCode() === $code) {
                return $product;
            }
        }
        return null;
    }
}