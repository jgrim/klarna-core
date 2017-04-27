<?php namespace KlarnaCore;

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
 * @package KlarnaKco
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
