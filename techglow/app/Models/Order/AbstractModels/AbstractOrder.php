<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Order\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Class AbstractOrder
* @package App\Models\Order\AbstractModels
*
* @property bigInteger $id
* @property enum $order_status
* @property enum $payment_status
* @property string $fortnox_no
* @property string $pin
* @property boolean $credited
* @property string $credited_by
* @property \Carbon\Carbon $credited_at
* @property bigInteger $customer_id
* @property bigInteger $user_id
* @property bigInteger $payment_provider_id
* @property string $payment_provider_ref
* @property string $sellorder_number
* @property enum $send_invoice
* @property boolean $cancelled
* @property \Carbon\Carbon $cancelled_at
* @property string $your_reference
* @property string $our_reference
* @property bigInteger $subtotal
* @property bigInteger $discount
* @property bigInteger $vat
* @property boolean $vat_is_moms
* @property bigInteger $equalization
* @property bigInteger $shipping
* @property bigInteger $total
* @property integer $paid
* @property \Carbon\Carbon $paid_at
* @property string $currency
* @property string $payment_terms
* @property enum $mode_of_delivery
* @property string $comment
* @property \Carbon\Carbon $accounting_at
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
* @property \App\Models\Profile\Customer|null $customer
* @property \App\Models\User|null $user
* @property \App\Models\Order\PaymentProvider|null $paymentProvider
* @property \Illuminate\Database\Eloquent\Collection $purchaseOrders
* @property \Illuminate\Database\Eloquent\Collection $orderBillingAddresses
* @property \Illuminate\Database\Eloquent\Collection $orderShippingAddresses
* @property \Illuminate\Database\Eloquent\Collection $orderRows
*/ 
abstract class AbstractOrder extends Model
{
    use SoftDeletes;
    
    /**  
     * Customize column name for created_at timestamp
     * 
     * @var string
     */
    protected $CREATED_AT = 'created_at';
    
    /**  
     * Customize column name for updated_at timestamp
     * 
     * @var string
     */
    protected $UPDATED_AT = 'updated_at';
    
    /**  
     * The model's default values for attributes.
     * 
     * @var array
     */
    protected $attributes = [
        'order_status' => "offer",
        'payment_status' => "awaiting",
        'credited' => false,
        'send_invoice' => "email",
        'cancelled' => false,
        'our_reference' => '"WEBSHOP"',
        'vat_is_moms' => true,
        'currency' => 'SEK',
        'payment_terms' => '"factoring"',
        'mode_of_delivery' => "post"
    ];
    
    /**  
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_status' => 'string',
        'payment_status' => 'string',
        'fortnox_no' => 'string',
        'pin' => 'string',
        'credited' => 'boolean',
        'credited_by' => 'string',
        'credited_at' => 'datetime',
        'customer_id' => 'integer',
        'user_id' => 'integer',
        'payment_provider_id' => 'integer',
        'payment_provider_ref' => 'string',
        'sellorder_number' => 'string',
        'send_invoice' => 'string',
        'cancelled' => 'boolean',
        'cancelled_at' => 'datetime',
        'your_reference' => 'string',
        'our_reference' => 'string',
        'subtotal' => 'integer',
        'discount' => 'integer',
        'vat' => 'integer',
        'vat_is_moms' => 'boolean',
        'equalization' => 'integer',
        'shipping' => 'integer',
        'total' => 'integer',
        'paid' => 'integer',
        'paid_at' => 'datetime',
        'currency' => 'string',
        'payment_terms' => 'string',
        'mode_of_delivery' => 'string',
        'comment' => 'string',
        'accounting_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    /**  
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'fortnox_no',
        'pin',
        'customer_id',
        'user_id',
        'payment_provider_id',
        'send_invoice',
        'your_reference',
        'our_reference',
        'subtotal',
        'discount',
        'vat',
        'equalization',
        'shipping',
        'total',
        'payment_terms',
        'mode_of_delivery',
        'comment'
    ];
    
    public function customer()
    {
        return $this->belongsTo('\App\Models\Profile\Customer', 'customer_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id', 'id');
    }
    
    public function paymentProvider()
    {
        return $this->belongsTo('\App\Models\Order\PaymentProvider', 'payment_provider_id', 'id');
    }
    
    public function purchaseOrders()
    {
        return $this->hasMany('\App\Models\Order\PurchaseOrder', 'order_id', 'id');
    }
    
    public function orderBillingAddresses()
    {
        return $this->hasMany('\App\Models\Order\OrderBillingAddress', 'order_id', 'id');
    }
    
    public function orderShippingAddresses()
    {
        return $this->hasMany('\App\Models\Order\OrderShippingAddress', 'order_id', 'id');
    }
    
    public function orderRows()
    {
        return $this->hasMany('\App\Models\Order\OrderRow', 'order_id', 'id');
    }
}
