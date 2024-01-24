<?php

namespace Modules\P2P\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\P2P\Entities\PPaymentMethod;

class PUserPaymentMethod extends Model
{
    protected $fillable =['uid','user_id','username','payment_uid','bank_name',
                          'bank_account_number','account_opening_branch',
                          'transaction_reference','card_number','card_type','mobile_account_number'
                         ];


    public function adminPamyntMethod()
    {
        return $this->hasOne(PPaymentMethod::class,"uid","payment_uid");
    }
}
