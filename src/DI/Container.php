<?php
declare(strict_types=1);

namespace App\DI;

use Exception;

class Container
{
    private array $bindings = [];

    /**
     * Binds an interface or a class name to a concrete implementation or closure
     *
     * @param string $abstract
     * @param callable|object $concrete
     * @return void
     */
    public function set(string $abstract, callable|object $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Resolves an abstract type to a concrete instance
     *
     * @param string $abstract
     * @return object
     * @throws Exception
     */
    public function get(string $abstract): object
    {
        if (!isset($this->bindings[$abstract])) {
            throw new Exception("No binding found for {$abstract}");
        }

        $concrete = $this->bindings[$abstract];

        // If it's a closure, invoke it
        if (is_callable($concrete)) {
            return $concrete($this);
        }

        // Otherwise assume it's already an object
        return $concrete;
    }
}