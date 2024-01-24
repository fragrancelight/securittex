<?php

namespace Modules\P2P\Jobs;

use App\Model\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Modules\P2P\Entities\PGiftCardOrder;

class GiftCardReleaseDisputeOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $dispute_details)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $dispute_details = $this->dispute_details;
            if($dispute_details->status == STATUS_DEACTIVE)
            {
                $order_details = PGiftCardOrder::find($dispute_details->gift_card_order_id);
                if(isset($order_details)){

                    if($order_details->payment_currency_type == PAYMENT_CURRENCY_CRYPTO)
                    {
                        $userWallet = Wallet::where('user_id', $order_details->buyer_id)
                                ->where('coin_type', $order_details->currency_type)
                                ->where('status', STATUS_ACTIVE)
                                ->first();
                        if(isset($userWallet))
                        {
                            $userWallet->balance += $order_details->price;
                            $userWallet->save();
                            
                        }else{
                            storeException('GiftCardReleaseDisputeOrderJob', __('Wallet not found!'));
                        }
                    }
                    
                    $order_details->update(['status' => TRADE_STATUS_RELEASED_BY_ADMIN]);
                    $dispute_details->update(['status' => STATUS_ACCEPTED]);

                    storeException('GiftCardReleaseDisputeOrderJob', __('Order is released successfully'));
                }else{
                    storeException('GiftCardReleaseDisputeOrderJob', __('Order not found'));
                }
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            storeException('GiftCardReleaseDisputeOrderJob ex', $e->getMessage());
        }
    }
}
