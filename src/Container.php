<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */

namespace Ailixter\Puzzle;

use Ailixter\Puzzle\Container\Exception;
use Ailixter\Puzzle\Container\NotFoundException;
use Psr\Container\ContainerInterface;

/**
 * @author AII (Alexey Ilyin)
 */
class Container implements ContainerInterface
{
    private $registry = [];

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException("'$id' is not found");
        }
        $item = $this->registry[$id];
        if (\is_callable($item)) {
            // allow additional arguments for Container::get
            $args = \func_get_args();
            $args[0] = $this;
            return $item(...$args);
        }
        return $item;
    }

    public function has($id)
    {
        return isset($this->registry[$id]);
    }

    public function add($id, $item)
    {
        if ($this->has($id)) {
            throw new Exception("'$id' is set"); // ???
        }
        return $this->set($id, $item);
    }

    protected function set($id, $item)
    {
        $this->registry[$id] = $item;
        return $this;
    }
}
