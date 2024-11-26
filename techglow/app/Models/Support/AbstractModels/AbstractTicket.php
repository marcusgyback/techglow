<?php
/**
 * Model object generated by: Skipper (http://www.skipper18.com)
 * Do not modify this file manually.
 */

namespace App\Models\Support\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Class AbstractTicket
* @package App\Models\Support\AbstractModels
*
* @property bigInteger $id
* @property string $email
* @property text $question
* @property text $answer
* @property bigInteger $answer_by
* @property \Carbon\Carbon $answer_at
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
* @property \App\Models\User|null $user
*/ 
abstract class AbstractTicket extends Model
{
    use SoftDeletes;
    
    /**  
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tickets';
    
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
        'email' => 'string',
        'question' => 'string',
        'answer' => 'string',
        'answer_by' => 'integer',
        'answer_at' => 'datetime',
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
        'email',
        'question',
        'answer',
        'answer_at',
        'created_at'
    ];
    
    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'answer_by', 'id');
    }
}
