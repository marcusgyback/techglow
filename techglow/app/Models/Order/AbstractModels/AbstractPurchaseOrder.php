<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Order\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Class AbstractPurchaseOrder
* @package App\Models\Order\AbstractModels
*
* @property bigInteger $id
* @property string $accounting_number
* @property string $supplier_number
* @property bigInteger $order_id
* @property bigInteger $supplier_id
* @property \Carbon\Carbon $cancelled_at
* @property \Carbon\Carbon $accounting_at
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
* @property \App\Models\Order\Order|null $order
* @property \App\Models\Product\Supplier|null $supplier
*/ 
abstract class AbstractPurchaseOrder extends Model
{
    use SoftDeletes;
    
    /**  
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'accounting_number' => 'string',
        'supplier_number' => 'string',
        'order_id' => 'integer',
        'supplier_id' => 'integer',
        'cancelled_at' => 'datetime',
        'accounting_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    public function order()
    {
        return $this->belongsTo('\App\Models\Order\Order', 'order_id', 'id');
    }
    
    public function supplier()
    {
        return $this->belongsTo('\App\Models\Product\Supplier', 'supplier_id', 'id');
    }
}
