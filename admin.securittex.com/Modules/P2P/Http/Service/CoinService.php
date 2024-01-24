<?php
namespace Modules\P2P\Http\Service;

use App\Model\Coin;
use Modules\P2P\Entities\PCoinSetting;
use Modules\P2P\Http\Repository\CoinRepository;

class CoinService
{
    private $repo;

    public function __construct() {
        $this->repo = new CoinRepository();
    }

    public function getAllActiveCoin()
    {
        try {
            if(!PCoinSetting::exists())
            {
                $coins = Coin::where("status", STATUS_ACTIVE)->get();
                foreach($coins as $coin)
                {
                    $data = [
                        "coin_type" => $coin->coin_type,
                        "minimum_price" => 1,
                        "maximum_price" => 100,
                        "trade_status" => STATUS_ACTIVE
                    ];
                    $this->saveCoinSetting((Object)$data);
                }
            }
            $data = [
                'where' => ['status',STATUS_ACTIVE],
                'get' => []
            ];
            return $this->repo->getModelData(Coin::class, $data);
        } catch (\Exception $e) {
            storeException('getAllActiveCoin', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }

    public function getCoinDetailsByType($type)
    {
        try {
            return $this->repo->getCoinDetailsByType($type);
        } catch (\Exception $e) {
            storeException('getCoinDetailsByType', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }
    
    public function saveCoinSetting($request)
    {
        try {
            return $this->repo->saveCoinSetting($request);
        } catch (\Exception $e) {
            storeException('saveCoinSetting', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }
}