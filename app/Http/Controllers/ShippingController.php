<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Shipping;
use App\Storage;
use App\Enterprise;
use App\Http\Resources\Shippings as Shippings;

class ShippingController extends Controller
{
    public function index(Request $request) {
        // return $request;
        $condition = [];
        switch ($request->statusFilter) {
            case 1: {
                array_push($condition, ["status", "=", "In progress"]);
                break;
            }

            case 2: {
                array_push($condition, ["status", "=", "Completed"]);
                break;
            }

            case 3: {
                array_push($condition, ["status", "=", "Canceled"]);
                break;
            }
        }
        
        switch ($request->typeFilter) {
            case 1: {
                array_push($condition, ["type", "=", "Replenish Storage"]);
                break;
            }

            case 2: {
                array_push($condition, ["type", "=", "Replenish Enterprise"]);
                break;
            }
        }
        // return Shippings::collection(Shipping::all()->sortByDesc("created_at"));
        return Shippings::collection(Shipping::where($condition)->get()->sortByDesc("created_at"));
    }

    public function store(Request $request) {
        $this->validate($request, [
            "enterpriseID" => "nullable|numeric",
            "storageID" => "required|numeric",
            "palleteCount" => "required|numeric",
            "type" => "required|in:Replenish Storage,Replenish Enterprise",
            "products" => "required"
        ]);
        $shippingData = [
            "enterprise_id" => $request->enterpriseID ? $request->enterpriseID : NULL,
            "storage_id" => $request->storageID,
            "type" => $request->type,
            "status" => "In progress",
        ];
        $shipping = Shipping::create($shippingData);
        $shipping->products()->attach($request->products, ["pallete_count" => $request->palleteCount]);
        return $shipping;
    }

    public function getShippingUnperfomableProducts($shipping_id) {
        $shipping = Shipping::find($shipping_id);
        $shipping_products = $shipping->products()->get();
        if ($shipping->type == "Replenish Enterprise" && $shipping->status == "In progress") {
            $storage = Storage::find($shipping->storage_id);
            foreach($shipping_products as $product) {
                $storage_product = $storage->products()->find($product->id);
                $pallete_count = $storage_product->pivot->palete_amount - $product->pivot->pallete_count;
                if ($pallete_count < 0) {
                    $product->perfomable = false;
                } else {
                    $product->perfomable = true;
                }
            }
        } elseif ($shipping->type == "Replenish Storage" && $shipping->status == "In progress") {
            foreach($shipping_products as $product) {
                $product->perfomable = true;
            }
        }
        return $shipping_products;
    }

    public function completeShipping($shipping_id) {
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
        } elseif ($shipping->type == "Replenish Enterprise" && $shipping->status == "In progress") {
            $storage = Storage::find($shipping->storage_id);
            $enterprise = Enterprise::find($shipping->enterprise_id);
            $shipping_products = $shipping->products()->get();
            // return $shipping_products;
            foreach($shipping_products as $product) {
                $updating_product = $storage->products()->find($product->id);
                $pallete_count = $updating_product->pivot->palete_amount - $product->pivot->pallete_count;
                if ($pallete_count < 0) {
                    continue;
                }
                $storage->products()->updateExistingPivot($updating_product->id, ["palete_amount" => $pallete_count]);

                $updating_product = $enterprise->products()->find($product->id);
                $enterprise->products()->updateExistingPivot($updating_product->id, ["amount" => $updating_product->pivot->amount+$product->pivot->pallete_count*$product->amount_per_palete]);
            }
            $shipping->status = "Completed";
            $shipping->update();
        }
        return "completed";
    }

    public function cancelShipping($shipping_id) {
        $shipping = Shipping::find($shipping_id);
        if ($shipping->type == "Replenish Storage") {
            if ($shipping->status == "In progress") {
                $shipping->status = "Canceled";
                $shipping->update();
            }
        } elseif ($shipping->type == "Replenish Enterprise") {
            if ($shipping->status == "In progress") {
                $shipping->status = "Canceled";
                $shipping->update();
            }
        }
    }
}

