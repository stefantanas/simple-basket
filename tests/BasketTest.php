<?php
declare(strict_types=1);

namespace Tests;

use App\Contracts\BasketServiceInterface;
use App\Contracts\PriceRuleType;
use App\Model\Basket;
use App\Model\Product;
use App\Repository\ProductCatalog;
use App\Service\BasketService;
use App\Service\PriceRule\BuyXGetYDiscount;
use App\Service\Shipping\TableRatesShippingRule;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    private BasketServiceInterface $basketService;

    protected function setUp(): void
    {
        $catalog = new ProductCatalog([
            new Product('R01', 'Red Widget', 32.95),
            new Product('G01', 'Green Widget', 24.95),
            new Product('B01', 'Blue Widget', 7.95),
        ]);

        $offer = new BuyXGetYDiscount(
            $catalog,
            2,
            "R01",
            50,
            PriceRuleType::Percentage
        );
        $shipping = new TableRatesShippingRule();

        $this->basketService = new BasketService($catalog, [$offer], $shipping, new Basket());
    }

    public function testExample1(): void
    {
        // B01, G01 => 37.85
        $this->basketService->addItem('B01');
        $this->basketService->addItem('G01');

        $this->assertEquals(37.85, $this->basketService->getTotal());
    }

    public function testExample2(): void
    {
        // R01, R01 => 54.37
        $this->basketService->addItem('R01');
        $this->basketService->addItem('R01');

        $this->assertEquals(54.37, $this->basketService->getTotal());
    }

    public function testExample3(): void
    {
        // R01, G01 => 60.85
        $this->basketService->addItem('R01');
        $this->basketService->addItem('G01');

        $this->assertEquals(60.85, $this->basketService->getTotal());
    }

    public function testExample4(): void
    {
        // B01, B01, R01, R01, R01 => 98.27
        $this->basketService->addItem('B01');
        $this->basketService->addItem('B01');
        $this->basketService->addItem('R01');
        $this->basketService->addItem('R01');
        $this->basketService->addItem('R01');

        $this->assertEquals(98.27, $this->basketService->getTotal());
    }
}