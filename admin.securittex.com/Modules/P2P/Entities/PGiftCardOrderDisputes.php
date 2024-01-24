<?php

namespace Modules\P2P\Entities;

use Illuminate\Database\Eloquent\Model;

class PGiftCardOrderDisputes extends Model
{
    protected $fillable = [
        'uid',
        'gift_card_order_id',
        'user_id',
        'reported_user',
        'reason_heading',
        'details',
        'image',
        'status',
        'updated_by',
        'assigned_admin',
        'expired_at'
    ];

}
