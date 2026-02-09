<?php

namespace App\Container;

/**
 * Простой DI контейнер
 * 
 * @author fakedesyncc
 */
class Container
{
    private array $services = [];
    private array $singletons = [];

    public function set(string $id, callable $factory, bool $singleton = false): void
    {
        $this->services[$id] = [
            'factory' => $factory,
            'singleton' => $singleton
        ];
    }

    /**
     * @return mixed
     */
    public function get(string $id)
    {
        if (isset($this->singletons[$id])) {
            return $this->singletons[$id];
        }

        if (!isset($this->services[$id])) {
            throw new \RuntimeException("Service '{$id}' not found");
        }

        $service = $this->services[$id];
        $instance = $service['factory']($this);

        if ($service['singleton']) {
            $this->singletons[$id] = $instance;
        }

        return $instance;
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]) || isset($this->singletons[$id]);
    }
}
