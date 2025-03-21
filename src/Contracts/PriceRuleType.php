<?php

namespace App\Contracts;

/**
 * Enum to differentiate between fixed amount discounts and percentage discounts
 */
enum PriceRuleType
{
    case FixedAmount;
    case Percentage;
}
