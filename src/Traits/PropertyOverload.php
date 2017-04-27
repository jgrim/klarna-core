<?php
/**
 * Enter description here...
 *
 * @category
 * @package
 * @author     Jason Grim <jason.grim@klarna.com>
 */

namespace KlarnaCore\Traits;

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
