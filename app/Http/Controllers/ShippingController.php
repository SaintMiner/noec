<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Shipping;

class ShippingController extends Controller
{
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
}
