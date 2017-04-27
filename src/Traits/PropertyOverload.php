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

/**
 * Class PropertyOverload
 *
 * @package KlarnaCore\Traits
 */
trait PropertyOverload
{
    protected $data = array();

    public function __get($name)
    {
        $method = 'get' . $this->studly($name) . 'Attribute';
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }

    public function __set($name, $value)
    {
        $method = 'set' . $this->studly($name) . 'Attribute';
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->data[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    public function __call($method, $args)
    {
        switch (substr($method, 0, 3)) {
            case 'get':
                $key = $this->underscore(substr($method, 3));

                return $this->$key;

            case 'set':
                $key = $this->underscore(substr($method, 3));

                $this->$key = isset($args[0]) ? $args[0] : null;

                return $this;
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function underscore($key)
    {
        return strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $key));
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function studly($key)
    {
        $key = ucwords(str_replace(['-', '_'], ' ', $key));

        return str_replace(' ', '', $key);
    }
}
