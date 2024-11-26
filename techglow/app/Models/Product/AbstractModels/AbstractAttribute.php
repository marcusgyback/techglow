<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Product\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Class AbstractAttribute
* @package App\Models\Product\AbstractModels
*
* @property bigInteger $id
* @property string $class_type
* @property json $name
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
* @property bigInteger $attribute_type_id
* @property bigInteger $attribute_group_id
* @property bigInteger $product_id
* @property \App\Models\Product\AttributeType|null $attributeType
* @property \App\Models\Product\AttributeGroup|null $attributeGroup
* @property \App\Models\Product\Product|null $product
*/ 
abstract class AbstractAttribute extends Model
{
    use SoftDeletes;
    
    /**  
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'attributes';
    
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
        'class_type' => 'string',
        'name' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'attribute_type_id' => 'integer',
        'attribute_group_id' => 'integer',
        'product_id' => 'integer'
    ];
    
    /**  
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'class_type',
        'name',
        'attribute_type_id',
        'attribute_group_id'
    ];
    
    public function attributeType()
    {
        return $this->belongsTo('\App\Models\Product\AttributeType', 'attribute_type_id', 'id');
    }
    
    public function attributeGroup()
    {
        return $this->belongsTo('\App\Models\Product\AttributeGroup', 'attribute_group_id', 'id');
    }
    
    public function product()
    {
        return $this->belongsTo('\App\Models\Product\Product', 'product_id', 'id');
    }
}