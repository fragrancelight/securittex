<?php

use Modules\IcoLaunchpad\Entities\IcoPhaseInfo;
use Modules\IcoLaunchpad\Entities\TokenBuyHistory;

function getTotalSoldTokenICO()
{
    return TokenBuyHistory::whereIn('status', [STATUS_PENDING, STATUS_SUCCESS])->sum('amount');
}

function getTotalSuppliedTokenICO()
{
    return IcoPhaseInfo::sum('total_token_supply');
}