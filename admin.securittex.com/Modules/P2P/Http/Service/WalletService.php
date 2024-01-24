<?php
namespace Modules\P2P\Http\Service;

use App\Model\Wallet;
use Modules\P2P\Entities\P2PWallet;
use Modules\P2P\Jobs\WalletBalanceTransfer;

class WalletService
{
    public function getWalletList($userId, $paginate = null)
    {
        try {
            create_coin_wallet_p2p($userId);
            $wallets = P2PWallet::
            join('coins','coins.id', '=', 'p2p_wallets.coin_id')
            ->join('p_coin_settings','p_coin_settings.coin_type', '=', 'coins.coin_type')
            ->where(['p2p_wallets.user_id'=> $userId, 'p2p_wallets.type'=> PERSONAL_WALLET, 'coins.status' => STATUS_ACTIVE, 'p_coin_settings.trade_status' => STATUS_ACTIVE])
            ->orderBy('p2p_wallets.created_at', 'DESC')
            ->select('p2p_wallets.*','p_coin_settings.trade_status')
            ->paginate($paginate ?? 10);
            if (isset($wallets[0])) {
                foreach ($wallets as $wallet) {
                    $wallet->total_balance_usd = get_coin_usd_value($wallet->total, $wallet->coin_type);
                    $wallet->coin_icon = empty($wallet->coin_icon) ? '' : show_image_path($wallet->coin_icon,'coin/');
                }
            }
            return responseData(true, __("Wallet get successfully"),$wallets);
        } catch (\Exception $e) {
            storeException('getWalletList', $e->getMessage());            
            return responseData(false, __("Something went wrong"));
        }
    }

    public function walletDetails($request)
    {
        try {
            $userId = authUserId_p2p();
            create_coin_wallet_p2p($userId);
            if($wallet = Wallet::where(['coin_type' => $request->coin_type, 'user_id' => $userId])->first())
            return responseData(true, __("Wallet get successfully"),[ 'wallet' => $wallet]);
            return responseData(false, __("Wallet not found"));
        } catch (\Exception $e) {
            storeException('getWalletList', $e->getMessage());            
            return responseData(false, __("Something went wrong"));
        }
    }

    public function walletBlanceTransfer($userId, $request)
    {
        try {
            if($request->type == WALLET_BALANCE_TRANSFER_RECEIVE)
            {
                $wallet = Wallet::where(["user_id" => $userId, "coin_type" => $request->coin])->first();
                if($wallet){
                    if($wallet->balance >= $request->amount){
                        WalletBalanceTransfer::dispatch($wallet, $request->amount, $request->type, $request->coin, $userId);
                        return responseData(true,__("Balance transferd successfully"));
                    }
                    return responseData(false,__("Your fund wallet do not have sufficient balance"));
                }
                return responseData(false,__("Fund Wallet not found"));
            }
            if($request->type == WALLET_BALANCE_TRANSFER_SEND)
            {
                $wallet = P2PWallet::where(["user_id" => $userId, "coin_type" => $request->coin])->first();
                if($wallet){
                    if($wallet->balance >= $request->amount){
                        WalletBalanceTransfer::dispatch($wallet, $request->amount, $request->type, $request->coin, $userId);
                        return responseData(true,__("Balance transferd successfully"));
                    }
                    return responseData(false,__("Your P2P Wallet do not have sufficient balance"));
                }
                return responseData(false,__("P2P Wallet not found"));
            }
            return responseData(false, __("Wallet Balance transfer successfully"));
        } catch (\Exception $e) {
            storeException('walletBlanceTransfer', $e->getMessage());            
            return responseData(false, __("Something went wrong"));
        }
    }
}