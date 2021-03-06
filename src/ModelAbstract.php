<?php namespace KlarnaCore;
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

use KlarnaCore\Contracts\Model;
use KlarnaCore\Traits\Arrayable;
use KlarnaCore\Traits\PropertyOverload;

/**
 * Class ModelAbstract
 *
 * @package KlarnaCore
 */
abstract class ModelAbstract implements Model
{
    use Arrayable;
    use PropertyOverload;

    /**
     * ModelAbstract constructor.
     *
     * @param array $data
     */
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
