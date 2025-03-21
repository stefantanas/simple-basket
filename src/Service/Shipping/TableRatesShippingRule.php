<?php
declare(strict_types=1);

namespace App\Service\Shipping;

use App\Contracts\ShippingRuleInterface;

class TableRatesShippingRule implements ShippingRuleInterface
{
    /**
     * @var array<int, array<string, float|null>>
     *
     * Each array item represents a tier:
     * - 'min'  => minimum order subtotal for this tier
     * - 'max'  => maximum order subtotal (null means "no upper bound")
     * - 'rate' => shipping cost for this tier
     */
    private array $tiers = [
        ['min' => 0,   'max' => 50,  'rate' => 4.95],
        ['min' => 50,  'max' => 90,  'rate' => 2.95],
        ['min' => 90,  'max' => null,'rate' => 0.0],
    ];

    /**
     * Allow injecting custom tiers if needed
     */
    public function __construct(array $tiers = [])
    {
        if (!empty($tiers)) {
            $this->tiers = $tiers;
        }
    }

    /**
     * Calculates shipping based on the configured tiered rates.
     *
     * @param float $subtotal
     * @return float
     */
    public function calculateShipping(float $subtotal): float
    {
        foreach ($this->tiers as $tier) {
            $min = $tier['min'];
            $max = $tier['max'];
            $rate = $tier['rate'];

            if ($subtotal >= $min && ($max === null || $subtotal < $max)) {
                return $rate;
            }
        }
        return 0.0;
    }
}