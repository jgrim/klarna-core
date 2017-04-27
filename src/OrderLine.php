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

/**
 * Class OrderLine
 *
 * @property string $type
 * @property string $reference
 * @property string $name
 * @property int    $quantity
 * @property string $quantity_unit
 * @property int    $unit_price
 * @property int    $tax_rate
 * @property int    $total_amount
 * @property int    $total_discount_amount
 * @property int    $total_tax_amount
 * @property string $merchant_data
 * @property string $product_url
 * @property string $image_url
 *
 * @package KlarnaCore
 */
class OrderLine extends ModelAbstract
{
    const TYPE_PHYSICAL     = 'physical';
    const TYPE_DISCOUNT     = 'discount';
    const TYPE_SHIPPING_FEE = 'shipping_fee';
    const TYPE_SALES_TAX    = 'sales_tax';
    const TYPE_DIGITAL      = 'digital';
    const TYPE_GIFT_CARD    = 'gift_card';
    const TYPE_STORE_CREDIT = 'store_credit';
    const TYPE_SURCHARGE    = 'surcharge';

    /**
     * @param mixed $quantity
     *
     * @return OrderLine
     */
    public function setQuantityAttribute($quantity)
    {
        $this->quantity = (int)$quantity;

        return $this;
    }
}
