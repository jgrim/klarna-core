<?php
/**
 * Enter description here...
 *
 * @category
 * @package
 * @author     Jason Grim <jason.grim@klarna.com>
 */

namespace KlarnaCore\Traits;

use ArrayIterator;
use KlarnaCore\ModelAbstract;

trait Collection
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @param ModelAbstract $item
     *
     * @return $this
     */
    public function addItem(ModelAbstract $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}
