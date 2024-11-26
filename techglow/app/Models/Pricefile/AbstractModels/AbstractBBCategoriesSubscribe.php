<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Pricefile\AbstractModels;

use Illuminate\Database\Eloquent\Model;

/**
* Class AbstractBBCategoriesSubscribe
* @package App\Models\Pricefile\AbstractModels
*
* @property bigInteger $id
* @property string $categorie
* @property boolean $follow
* @property boolean $block
* @property boolean $recursive
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
*/ 
abstract class AbstractBBCategoriesSubscribe extends Model
{
    /**  
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'bbcategories_subscribe';
    
    /**  
     * The model's default values for attributes.
     * 
     * @var array
     */
    protected $attributes = [
        'follow' => true,
        'block' => false,
        'recursive' => false
    ];
    
    /**  
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'categorie' => 'string',
        'follow' => 'boolean',
        'block' => 'boolean',
        'recursive' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    /**  
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'categorie',
        'follow',
        'block',
        'recursive'
    ];
}
