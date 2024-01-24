<?php

namespace Modules\P2P\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\P2P\Http\Service\WalletService;
use Modules\P2P\Http\Requests\WalletDetailsRequest;
use Modules\P2P\Http\Requests\Api\UserBlanceTransfer;

class WalletController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new WalletService();
    }

    public function walletList(Request $request)
    {
        try {
            $id = authUserId_p2p();
            $response = $this->service->getWalletList($id, $request->per_page ?? null);
            return response()->json($response);
        } catch (\Exception $e) {
            storeException('walletList p2p', $e->getMessage());
            return response()->json(responseData(false, __("Something went wrong")));
        }
    }

    public function walletBlanceTransfer(UserBlanceTransfer $request)
    {
        try {
            $response = $this->service->walletBlanceTransfer(Auth::id(),$request);
        } catch (\Exception $e) {
            storeException('walletList', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' => []];
        }
        return response()->json($response);
    }

    public function walletDetails(WalletDetailsRequest $request)
    {
        try {
            $response = $this->service->walletDetails($request);
        } catch (\Exception $e) {
            storeException('walletList', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' => []];
        }
        return response()->json($response);
    }
}
