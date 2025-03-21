<?php
declare(strict_types=1);

namespace App\Model;

class Basket
{
    /**
     * @var array<string,int> [productCode => quantity]
     */
    private array $items = [];

    /**
     * Increment the quantity of the given product code by one
     *
     * @param string $code
     * @return void
     */
    public function addItem(string $code): void
    {
        if (!isset($this->items[$code])) {
            $this->items[$code] = 0;
        }
        $this->items[$code]++;
    }

    /**
     * Get the current items in the basket
     *
     * @return array<string,int>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}