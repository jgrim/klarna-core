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

use KlarnaCore\Traits\Arrayable;
use KlarnaCore\Traits\PropertyOverload;

/**
 * Class Transaction
 *
 * @property string              $purchase_country
 * @property string              $purchase_currency
 * @property string              $locale
 * @property string              $merchant_reference1
 * @property string              $merchant_reference2
 * @property array|Address       $billing_address
 * @property array|Address       $shipping_address
 * @property array|Customer      $customer
 * @property array|Options       $options
 * @property array|MerchantUrls  $merchant_urls
 * @property array|ModelAbstract $shipping_options
 * @property array|ModelAbstract $external_checkouts
 * @property array|ModelAbstract $external_payment_methods
 *
 * @package KlarnaCore
 */
class Transaction
{
    use Arrayable;
    use PropertyOverload;

    /**
     * @var ItemCollection
     */
    protected $orderLine;

    /**
     * @var float
     */
    protected $orderAmount;

    /**
     * @var float
     */
    protected $orderTaxAmount;

    /**
     * Transaction constructor.
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->data      = $data;
        $this->orderLine = new ItemCollection();
    }

    /**
     * @return array
     */
    public function getTransactionItems()
    {
        $transactionItems = $this->data;

        array_walk($transactionItems, function (&$value, $key) {
            if ($value instanceof ModelAbstract) {
                $value = $value->toArray();
            }
        });

        return $transactionItems;
    }

    /**
     * @param OrderLine $item
     *
     * @return $this
     */
    public function addOrderLine(OrderLine $item)
    {
        $this->orderAmount += $item->total_amount;

        if (OrderLine::TYPE_SALES_TAX == $item->type) {
            $this->orderTaxAmount = $item->total_amount;
        } else {
            $this->orderTaxAmount += $item->total_tax_amount;
        }

        $this->orderLine->addItem($item);

        return $this;
    }

    /**
     * Remove item
     *
     * @param mixed $reference
     *
     * @return $this
     */
    public function removeOrderLine($reference)
    {
        if (isset($this->orderLine[$reference])) {
            $this->orderAmount    -= $this->orderLine[$reference]->total_amount;
            $this->orderTaxAmount -= $this->orderLine[$reference]->total_tax_amount;
            unset($this->orderLine[$reference]);
        }

        return $this;
    }

    /**
     * @return ItemCollection
     */
    public function getOrderLines()
    {
        return $this->orderLine;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->getTransactionItems(), array(
            'order_lines'      => $this->getOrderLines()->toArray(),
            'order_amount'     => $this->orderAmount,
            'order_tax_amount' => $this->orderTaxAmount,
        ));
    }
}
