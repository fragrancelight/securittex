<?php

namespace Modules\IcoLaunchpad\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\IcoLaunchpad\Http\Services\IcoService;
use Modules\IcoLaunchpad\Http\Requests\IcoBuyRequest;
use Modules\IcoLaunchpad\Http\Requests\IcoRequest;
use Illuminate\Support\Facades\Auth;
use Modules\IcoLaunchpad\Http\Services\ERC20TokenApiService;

class ICOController extends Controller
{
    private $icoService;
    private $erc20TokenApiService;
    public function __construct()
    {
        $this->icoService = new IcoService();
        $this->erc20TokenApiService = new ERC20TokenApiService();
    }
    public function getActiveICOList(Request $request)
    {
        $extra = [
            'api'=>true,
            'lang_key'=>$request->header('lang') ?? 'en'
        ];
        $per_page = $request->per_page??200;
        $response = $this->icoService->getActiveICOList($per_page, $extra);

        return response()->json($response);
    }

    public function userICOList(Request $request)
    {
        $response = $this->icoService->getUserICOList($request->per_page);

        return response()->json($response);
    }

    public function getICODetails(Request $request)
    {
        $extra = [
            'api'=>true,
            'lang_key'=>$request->header('lang') ?? 'en'
        ];
        
        $response = $this->icoService->findICOTokenByID($request->id, $extra);
        return response()->json($response);
    }

    public function storeUpdateICO(IcoRequest $request)
    {
        $response = $this->icoService->storeUpdateICO($request);
        return response()->json($response);
    }

    public function buyICOToken(IcoBuyRequest $request)
    {
        $response = $this->icoService->buyICOToken($request);
        return response()->json($response);
    }

    public function getAddressDettailsApi(Request $request)
    {
        $requestData = [
            'contract_address' => $request->contract_address,
            'chain_link' => $request->chain_link
        ];
        $response = $this->erc20TokenApiService->checkContractDetails($requestData);

        return response()->json($response);
    }
}
