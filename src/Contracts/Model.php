<?php namespace KlarnaCore\Contracts;

interface Model
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function toJson();

    /**
     * @return string
     */
    public function __toString();
}
