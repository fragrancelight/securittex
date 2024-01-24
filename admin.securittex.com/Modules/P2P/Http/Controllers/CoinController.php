<?php

namespace Modules\P2P\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\P2P\Http\Service\CoinService;
use Modules\P2P\Http\Requests\CoinSettingRequest;

class CoinController extends BaseController
{
    private $service; 

    public function __construct()
    {
        $this->service = new CoinService();
    }
    public function coinList(Request $request)
    {
        try {
            if($request->ajax())
            {
                $coins = $this->service->getAllActiveCoin();
                if (isset($coins['success']) && !$coins['success'])
                    return $this->sendBackResponse($coins, [], 1);
                return datatables()->of($coins['data'])
                    ->addColumn('name', function ($query) {
                        return $query->name;
                    })
                    ->addColumn('coin_type', function ($query) {
                        return find_coin_type($query->coin_type);
                    })
                    ->addColumn('network', function ($query) {
                        return api_settings($query->network);
                    })
                    ->addColumn('price', function ($query) {
                        return number_format($query->coin_price,2).' USD/ '.find_coin_type($query->coin_type);
                    })
                    ->addColumn('action', function ($query) {
                        return ActionButtonForList_p2p($query->id, 'p2pCoinEdit','',['id'=>['coin_type' => $query->coin_type],'delete'=>false]);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            storeException('coinList p2p',$e->getMessage());
        }
        $data['title'] = __("Coin List");
        return view('p2p::coin.list',$data);
    }

    public function coinEdit($coin_type)
    {
        $data = [];
        try {
            $data['title'] = __("Coin Setting");
            $data['coin_type'] = $coin_type;
            $response = $this->service->getCoinDetailsByType($coin_type);
            if ($response['success']) $data['setting'] = $response['data'];
        } catch (\Exception $e) {
            storeException('coinEditProcess', $e->getMessage());
        }
        return view('p2p::coin.edit', $data);
    }

    public function coinEditProcess(CoinSettingRequest $request)
    {
        try {
            $response = $this->service->saveCoinSetting($request);
            return $this->sendBackResponse($response,['route' => 'p2pCoinList']);
        } catch (\Exception $e) {
            storeException('coinEditProcess', $e->getMessage());
            return responseData(false,__("Something went wrong"));
        }
    }
}
