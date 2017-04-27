<?php namespace KlarnaCore;

use KlarnaCore\Contracts\Model;
use KlarnaCore\Traits\Arrayable;
use KlarnaCore\Traits\PropertyOverload;

abstract class ModelAbstract implements Model
{
    use Arrayable;
    use PropertyOverload;

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
