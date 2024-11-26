<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Product\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Class AbstractAttributeGroup
* @package App\Models\Product\AbstractModels
*
* @property bigInteger $id
* @property string $class_type
* @property json $name
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
* @property \Illuminate\Database\Eloquent\Collection $attribute
*/ 
abstract class AbstractAttributeGroup extends Model
{
    use SoftDeletes;
    
    /**  
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'attribute_groups';
    
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
        'deleted_at' => 'datetime'
    ];
    
    /**  
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'class_type',
        'name'
    ];
    
    public function attribute()
    {
        return $this->hasMany('\App\Models\Product\Attribute', 'attribute_group_id', 'id');
    }
}
