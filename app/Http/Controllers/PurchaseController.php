<?php
namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Services\Interfaces\IPurchase;
use Illuminate\Http\Request;
use App\Http\Resources\PurchaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseController extends Controller {
    private IPurchase $purchaseService;
    public function __construct(IPurchase $purchaseService) {
        $this->purchaseService = $purchaseService;
    }

    public function index(): JsonResource {
        $purchases = $this->purchaseService->getPurchases();
        return PurchaseResource::collection($purchases);
    }

    public function store(PurchaseRequest $purchaseRequest): JsonResource {
        $purchases = $this->purchaseService->addPurchase($purchaseRequest->validated());
        return PurchaseResource::collection($purchases);
    }
}
