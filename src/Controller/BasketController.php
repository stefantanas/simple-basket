<?php
declare(strict_types=1);

namespace App\Controller;

use App\Contracts\BasketServiceInterface;
use App\View\BasketView;

class BasketController
{
    private BasketServiceInterface $basketService;

    public function __construct(BasketServiceInterface $basketService)
    {
        $this->basketService = $basketService;
    }

    /**
     * Add a product to the basket
     *
     * @param string $productCode
     * @return void
     */
    public function addAction(string $productCode): void
    {
        $this->basketService->addItem($productCode);
    }

    /**
     * Calculates the totals and returns BasketView for rendering
     *
     * @return BasketView
     */
    public function totalAction(): BasketView
    {
        $total = $this->basketService->getTotal();
        return new BasketView($total);
    }
}