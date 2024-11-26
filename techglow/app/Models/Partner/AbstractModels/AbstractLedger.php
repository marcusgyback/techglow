<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Partner\AbstractModels;

use Illuminate\Database\Eloquent\Model;

/**
* Class AbstractLedger
* @package App\Models\Partner\AbstractModels
*
* @property bigInteger $id
* @property bigInteger $partner_id
* @property string $number
* @property bigInteger $snapshot_sum
* @property bigInteger $snapshot_id
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \App\Models\Partner\Partner|null $partner
* @property \Illuminate\Database\Eloquent\Collection $transactions
*/ 
abstract class AbstractLedger extends Model
{
    /**  
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ledger';
    
    /**  
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'partner_id' => 'integer',
        'number' => 'string',
        'snapshot_sum' => 'integer',
        'snapshot_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    public function partner()
    {
        return $this->belongsTo('\App\Models\Partner\Partner', 'partner_id', 'id');
    }
    
    public function transactions()
    {
        return $this->hasMany('\App\Models\Partner\Transactions', 'ledger_id', 'id');
    }
}
