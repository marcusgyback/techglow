<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Pricefile\AbstractModels;

use Illuminate\Database\Eloquent\Model;

/**
* Class AbstractBBShipping
* @package App\Models\Pricefile\AbstractModels
*
* @property bigInteger $id
* @property string $reference
* @property double $cost
* @property bigInteger $carrierId
* @property string $carrierName
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
*/ 
abstract class AbstractBBShipping extends Model
{
    /**  
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'bbshippings';
    
    /**  
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reference' => 'string',
        'cost' => 'double',
        'carrierId' => 'integer',
        'carrierName' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    /**  
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'reference',
        'cost',
        'carrierId',
        'carrierName'
    ];
}