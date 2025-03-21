<?php
declare(strict_types=1);

namespace App\Service\PriceRule;

use App\Contracts\PriceRuleInterface;
use App\Model\Basket;
use App\Contracts\ProductCatalogInterface;
use App\Contracts\PriceRuleType;

class BuyXGetYDiscount implements PriceRuleInterface
{
    private ProductCatalogInterface $catalog;
    private int $xAmount;
    private string $productCode;
    private float $discountAmount;
    private PriceRuleType $type;

    public function __construct(
        ProductCatalogInterface $catalog,
        int $xAmount,
        string $productCode,
        float $discountAmount,
        PriceRuleType $type
    ) {
        $this->catalog = $catalog;
        $this->xAmount = $xAmount;
        $this->productCode = $productCode;
        $this->discountAmount = $discountAmount;
        $this->type = $type;
    }

    /**
     * Applies a discount to items in the basket based on the current price rule configuration
     *
     * @param Basket $basket
     * @return float
     */
    public function applyPriceRule(Basket $basket): float
    {
        $items = $basket->getItems();
        if (!isset($items[$this->productCode])) {
            return 0.0;
        }

        $count = $items[$this->productCode];
        $product = $this->catalog->getProductByCode($this->productCode);
        if (!$product) {
            return 0.0;
        }

        if ($this->xAmount) {
            if ($this->type === PriceRuleType::FixedAmount) {
                $pairs = intdiv($count, $this->xAmount);
                $totalDiscount = $pairs * $this->discountAmount;
                return round($totalDiscount > 0 ? $totalDiscount : 0.0, 2);
            } elseif ($this->type === PriceRuleType::Percentage) {
                $pairs = intdiv($count, $this->xAmount);
                $discountPerPair = round($product->getPrice() * ($this->discountAmount / 100), 2);

                return $pairs * $discountPerPair;
            }
        }
        return 0.0;
    }
}