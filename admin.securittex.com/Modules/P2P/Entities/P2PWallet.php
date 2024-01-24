<?php

namespace Modules\P2P\Entities;

use Illuminate\Database\Eloquent\Model;

class P2PWallet extends Model
{
    protected $table = "p2p_wallets";
    protected $fillable = [
        'user_id',
        'name',
        'balance',
        'referral_balance',
        'status',
        'is_primary',
        'coin_type',
        'coin_id',
        'key',
        'type'
    ];
    
}
