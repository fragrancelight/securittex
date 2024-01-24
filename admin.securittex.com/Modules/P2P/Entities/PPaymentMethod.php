<?php

namespace Modules\P2P\Entities;

use Illuminate\Database\Eloquent\Model;

class PPaymentMethod extends Model
{
    protected $fillable = ['uid','name','payment_type','country','note','logo','status'];
}
