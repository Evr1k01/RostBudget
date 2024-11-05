<?php
namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Services\Interfaces\IPurchase;
use App\Http\Resources\PurchaseResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller {
    private IPurchase $purchaseService;
    public function __construct(IPurchase $purchaseService) {
        $this->purchaseService = $purchaseService;
    }

    public function index(): JsonResource {
        $currentUser = Auth::user();
        $purchases = $this->purchaseService->getPurchases($currentUser);
        return PurchaseResource::collection($purchases);
    }

    public function store(PurchaseRequest $purchaseRequest): JsonResource|JsonResponse {
        $result = $this->purchaseService->addPurchase($purchaseRequest->validated());
        if (is_null($result)) {
            return response()->json('Ошибка при создании новой записи', 500);
        }
        return PurchaseResource::collection($result);
    }

    public function update(PurchaseRequest $purchaseRequest, Purchase $purchase): JsonResource|JsonResponse {
        $result = $this->purchaseService->updatePurchase($purchase->id, $purchaseRequest->validated());
        if (is_null($result)) {
            return response()->json('Ошибка при обновлении записи', 500);
        }
        return PurchaseResource::collection($result);
    }

    public function destroy(Purchase $purchase): JsonResponse {
        Purchase::destroy($purchase->id);
        return response()->json(null, 204);
    }
}
