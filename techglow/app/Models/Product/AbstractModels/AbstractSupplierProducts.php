<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Product\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Class AbstractSupplierProducts
* @package App\Models\Product\AbstractModels
*
* @property bigInteger $id
* @property bigInteger $id_api
* @property bigInteger $supplier_id
* @property bigInteger $product_id
* @property \Carbon\Carbon $dateUpdStock
* @property \Carbon\Carbon $dateUpdImages
* @property \Carbon\Carbon $dateUpdDescription
* @property \Carbon\Carbon $dateUpd
* @property text $payload
* @property double $wholesalePrice
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
* @property \App\Models\Product\Supplier|null $supplier
* @property \App\Models\Product\Product|null $product
*/ 
abstract class AbstractSupplierProducts extends Model
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
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'id_api' => 'integer',
        'supplier_id' => 'integer',
        'product_id' => 'integer',
        'dateUpdStock' => 'datetime',
        'dateUpdImages' => 'datetime',
        'dateUpdDescription' => 'datetime',
        'dateUpd' => 'datetime',
        'payload' => 'string',
        'wholesalePrice' => 'double',
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
        'id_api',
        'supplier_id',
        'product_id',
        'dateUpdStock',
        'dateUpdImages',
        'dateUpdDescription',
        'dateUpd',
        'payload',
        'wholesalePrice'
    ];
    
    public function supplier()
    {
        return $this->belongsTo('\App\Models\Product\Supplier', 'supplier_id', 'id');
    }
    
    public function product()
    {
        return $this->belongsTo('\App\Models\Product\Product', 'product_id', 'id');
    }
}
