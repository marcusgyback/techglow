<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Order\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Class AbstractPaymentProvider
* @package App\Models\Order\AbstractModels
*
* @property bigInteger $id
* @property boolean $active
* @property string $name
* @property boolean $web
* @property boolean $staff
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
* @property \Illuminate\Database\Eloquent\Collection $orders
*/ 
abstract class AbstractPaymentProvider extends Model
{
    use SoftDeletes;
    
    /**  
     * The model's default values for attributes.
     * 
     * @var array
     */
    protected $attributes = [
        'active' => false,
        'web' => false,
        'staff' => true
    ];
    
    /**  
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
        'name' => 'string',
        'web' => 'boolean',
        'staff' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    /**  
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['name'];
    
    public function orders()
    {
        return $this->hasMany('\App\Models\Order\Order', 'payment_provider_id', 'id');
    }
}
