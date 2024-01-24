<?php
namespace Modules\P2P\Http\Service;

use App\Model\CurrencyList;
use Modules\P2P\Entities\PCurrencySetting;
use Modules\P2P\Http\Repository\CurrencyRepository;


class CurrencyService
{
    private $repo;

    public function __construct() {
        $this->repo = new CurrencyRepository();
    }

    public function getAllActiveCurrency()
    {
        try {
            if(!PCurrencySetting::exists())
            {
                $currencys = CurrencyList::where("status", STATUS_ACTIVE)->get();
                foreach($currencys as $currency)
                {
                    $data = [
                        "code" => $currency->code,
                        "minimum_price" => 1,
                        "maximum_price" => 100,
                        "trade_status" => STATUS_ACTIVE
                    ];
                    $this->saveCurrencySetting((Object)$data);
                }
            }
            $data = [
                'where' => ['status',STATUS_ACTIVE],
                'get' => []
            ];
            return $this->repo->getModelData(CurrencyList::class, $data);
        } catch (\Exception $e) {
            storeException('getAllActiveCoin', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }

    public function getCurrencyDetailsByCode($code)
    {
        try {
            return $this->repo->getCurrencyDetailsByCode($code);
        } catch (\Exception $e) {
            storeException('getCurrencyDetailsByCode', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }
    
    public function saveCurrencySetting($request)
    {
        try {
            return $this->repo->saveCurrencySetting($request);
        } catch (\Exception $e) {
            storeException('saveCurrencySetting', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }
}