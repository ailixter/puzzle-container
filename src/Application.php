<?php

/*
 * (C) 2019, AII (Alexey Ilyin)
 */

namespace Ailixter\Puzzle;

use Ailixter\Gears\Exceptions\MethodException;

/**
 *
 */
class Application extends Container
{
    public function __get($id)
    {
        return $this->get($id);
    }

    public function __isset($id)
    {
        return $this->has($id);
    }

    public function __set($id, $item)
    {
        $this->add($id, $item);
    }

    public function __call($id, array $args)
    {
        $item = $this->get($id);
        if (!\is_callable($item)) {
            throw MethodException::forCall($this, $id);
        }
        return $item(...$args);
    }
}
