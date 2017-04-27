<?php
/**
 * Copyright 2017 Jason Grim
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    KlarnaCore
 * @author     Jason Grim <me@jasongrim.com>
 */

namespace KlarnaCore\Traits;

use ArrayIterator;
use KlarnaCore\ModelAbstract;

/**
 * Class Collection
 *
 * @package KlarnaCore\Traits
 */
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
