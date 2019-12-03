<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use Notifiable;
    
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet_id', 'type', 'transfer', 'type_payment', 'category_id', 'iban', 
        'mb_entity_code', 'mb_payment_reference', 'description', 'source_description', 
        'start_balance', 'end_balance', 'value'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

}
