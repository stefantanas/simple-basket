<?php
declare(strict_types=1);

namespace App\View;

class BasketView
{
    private float $total;

    public function __construct(float $total)
    {
        $this->total = $total;
    }

    /**
     * Render the basket total in CLI
     *
     * @return void
     */
    public function renderCli(): void
    {
        echo "Basket total: \$" . number_format($this->total, 2) . PHP_EOL;
    }
}