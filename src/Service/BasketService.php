<?php
declare(strict_types=1);

namespace App\Service;

use App\Contracts\BasketServiceInterface;
use App\Contracts\PriceRuleInterface;
use App\Contracts\ProductCatalogInterface;
use App\Contracts\ShippingRuleInterface;
use App\Model\Basket;

class BasketService implements BasketServiceInterface
{
    private ProductCatalogInterface $catalog;
    /** @var PriceRuleInterface[] */
    private array $priceRules;
    private ShippingRuleInterface $shippingRule;
    private Basket $basket;

    public function __construct(
        ProductCatalogInterface $catalog,
        array $priceRules,
        ShippingRuleInterface $shippingRule,
        Basket $basket
    ) {
        $this->catalog = $catalog;
        $this->priceRules = $priceRules;
        $this->shippingRule = $shippingRule;
        $this->basket = $basket;
    }

    public function addItem(string $productCode): void
    {
        $this->basket->addItem($productCode);
    }

    /**
     * Calculates all the totals and returns back a final total rounded to two decimal digits
     *
     * @return float
     */
    public function getTotal(): float
    {
        // Calculate raw subtotal
        $rawSubtotal = 0.0;
        foreach ($this->basket->getItems() as $code => $quantity) {
            $product = $this->catalog->getProductByCode($code);
            if ($product) {
                $rawSubtotal += $product->getPrice() * $quantity;
            }
        }

        // Calculate total discount from all price rules (In our case we only have Buy 2 R01 get 50% discount on second)
        $totalDiscount = 0.0;
        foreach ($this->priceRules as $priceRule) {
            $totalDiscount += $priceRule->applyPriceRule($this->basket);
        }

        $subtotalAfterDiscount = $rawSubtotal - $totalDiscount;

        // Calculate shipping
        $shippingCost = $this->shippingRule->calculateShipping($subtotalAfterDiscount);

        // Final total
        $final = $subtotalAfterDiscount + $shippingCost;

        return round($final, 2);
    }
}