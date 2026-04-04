<?php

class Container
{
    private array $bindings = [];

    public function set(string $name, callable $resolver): void
    {
        $this->bindings[$name] = $resolver;
    }

    public function get(string $name)
    {
        if (!isset($this->bindings[$name])) {
            throw new Exception("Container: service '$name' not found");
        }

        return $this->bindings[$name]($this);
    }
}