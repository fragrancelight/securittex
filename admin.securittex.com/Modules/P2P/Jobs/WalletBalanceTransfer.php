<?php

namespace Modules\P2P\Jobs;

use App\Model\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Modules\P2P\Entities\P2PWallet;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Console\Migrations\RollbackCommand;

class WalletBalanceTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private $wallet,
        private $amount,
        private $type,
        private $coin,
        private $user_id,
    ){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            DB::beginTransaction();
            if($this->type == WALLET_BALANCE_TRANSFER_RECEIVE)
            {
                $reciverWallet = P2PWallet::where(["user_id" => $this->user_id, "coin_type" => $this->coin])->first();
                if($reciverWallet){
                    $reciverWallet->increment("balance", $this->amount);
                    $this->wallet->decrement("balance", $this->amount);
                    DB::commit();
                    return;
                }else{
                    storeException("Balance transfer", "Receiver Wallet not found");
                    return;
                }
            }
            if($this->type == WALLET_BALANCE_TRANSFER_SEND)
            {
                $reciverWallet = Wallet::where(["user_id" => $this->user_id, "coin_type" => $this->coin])->first();
                if($reciverWallet){
                    $reciverWallet->increment("balance", $this->amount);
                    $this->wallet->decrement("balance", $this->amount);
                    DB::commit();
                    return;
                }else{
                    storeException("Balance transfer", "Receiver Wallet not found");
                    return;
                }
            }
            storeException("Balance transfer", "Transfer type not found");
        }catch(\Exception $e){
            DB::rollback();
            storeException("Balance transfer error", $e->getMessage());
        }
    }
}
