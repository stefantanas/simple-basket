<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Contracts\PriceRuleType;
use App\DI\Container;
use App\Model\Basket;
use App\Repository\ProductCatalog;
use App\Service\PriceRule\BuyXGetYDiscount;
use App\Service\Shipping\TableRatesShippingRule;
use App\Service\BasketService;
use App\Controller\BasketController;
use App\Contracts\BasketServiceInterface;
use App\Contracts\PriceRuleInterface;
use App\Contracts\ProductCatalogInterface;
use App\Contracts\ShippingRuleInterface;
use App\Model\Product;

// Create our container
$container = new Container();

// Bind the product catalog
$container->set(ProductCatalogInterface::class, function ($c) {
    return new ProductCatalog([
        new Product('R01', 'Red Widget', 32.95),
        new Product('G01', 'Green Widget', 24.95),
        new Product('B01', 'Blue Widget', 7.95),
    ]);
});

// Bind the shipping rule
$container->set(ShippingRuleInterface::class, function ($c) {
    return new TableRatesShippingRule();
});

// Bind an offer (the “buy one get second half price” for R01)
$container->set(PriceRuleInterface::class, function ($c) {
    return new BuyXGetYDiscount(
        $c->get(ProductCatalogInterface::class),
        2,
        "R01",
        50,
        PriceRuleType::Percentage
    );
});

// Bind the BasketService
$container->set(BasketServiceInterface::class, function ($c) {
    return new BasketService(
        $c->get(ProductCatalogInterface::class),
        [$c->get(PriceRuleInterface::class)],
        $c->get(ShippingRuleInterface::class),
        new Basket()
    );
});

// Finally, build the controller
$basketController = new BasketController(
    $container->get(BasketServiceInterface::class)
);

// Let's do some test usage:
$basketController->addAction('B01');
$basketController->addAction('B01');
$basketController->addAction('R01');
$basketController->addAction('R01');
$basketController->addAction('R01');

// Get the total and display it
$view = $basketController->totalAction();
$view->renderCli();