<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Shipping;
use App\Storage;
use App\Enterprise;
use App\Http\Resources\Shippings as Shippings;

class ShippingController extends Controller
{
    public function index() {
        return Shippings::collection(Shipping::all());
    }

    public function store(Request $request) {
        $this->validate($request, [
            "storageID" => "required|numeric",
            "palleteCount" => "required|numeric",
            "type" => "required|in:Replenish Storage,Replenish Enterprise",
            "products" => "required"
        ]);
        $shippingData = [
            "enterprise_id" => NULL,
            "storage_id" => $request->storageID,
            "type" => $request->type,
            "status" => "In progress",
        ];
        $shipping = Shipping::create($shippingData);
        $shipping->products()->attach($request->products, ["pallete_count" => $request->palleteCount]);
        return $shipping;
    }

    public function acceptShipping($shipping_id) {
        $shipping = Shipping::find($shipping_id);
        if ($shipping->type == "Replenish Storage" && $shipping->status == "In progress") {
            $storage = Storage::find($shipping->storage_id);
            $shipping_products = $shipping->products()->get();
            foreach($shipping_products as $product) {
                $updating_product = $storage->products()->find($product->id);
                $storage->products()->updateExistingPivot($updating_product->id, ["palete_amount" => $updating_product->pivot->palete_amount+$product->pivot->pallete_count]);
            }
            $shipping->status = "Completed";
            $shipping->update();
        } elseif($shipping->type == "Replenish Enterprise") {
            $storage = Storage::find($shipping->storage_id);
            $enterprise = Enterprise::find($shipping->enterprise_id);
        }
        return "accepted";
    }

    public function cancelShipping($shipping_id) {
        $shipping = Shipping::find($shipping_id);
    }
}

