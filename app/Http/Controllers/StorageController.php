<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Storage;
use App\Product;
use App\Http\Resources\StorageProducts as StorageProducts;
use App\Http\Resources\StorageFullInfo as StorageInfo;

class StorageController extends Controller
{
    public function index() {
        return StorageInfo::collection(Storage::all());
    }

    public function show($id) {
        return StorageInfo::collection([Storage::find($id)])->first();
    }

    public function store(Request $request) {
        $this->validate($request, [
            "title" => "required|min:3|max:255",
            "location" => "required|min:3|max:255",
            "palete_capacity" => "required|numeric|regex:/^[1-9]\d*$/",
            "class" => "required|in:A,B,C,D"
        ]);
           Storage::create($request->all());
        return response("created", 201);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            "title" => "required|min:3|max:255",
            "location" => "required|min:3|max:255",
            "palete_capacity" => "required|numeric|regex:/^[1-9]\d*$/",
            "class" => "required|in:A,B,C,D"
        ]);
        $storage = Storage::find($id);
        $storage->update($request->all());
        return response("updated", 201);
    }

    public function addPalletes(Request $request, $id) {
        $this->validate($request, [
            "palleteCount" => "required|numeric|not_in:0"
        ]);
        
        $storage = Storage::find($id);
        foreach($request->productsID as $productID) {
            $pallete_amount = $storage->products()->find($productID)->pivot->palete_amount;
            if ($pallete_amount < abs($request->palleteCount) && $request->palleteCount < 0 ) {
                $pallete_amount = abs($request->palleteCount);
            }
            $storage->products()->updateExistingPivot($productID, ["palete_amount" => $pallete_amount+$request->palleteCount]);
        }

        return response("Action done", 201);
    }

    public function getProducts($storageID) {
        $storageProducts = Storage::find($storageID)->products()->get();
        return StorageProducts::collection($storageProducts);
    }

    public function getNotIncludedProduct($storageID) {
        $includedProductsID = Storage::find($storageID)->products()->get()->pluck("id");
        $notIncludedProducts = Product::whereNotIn("id", $includedProductsID)->get();
        return $notIncludedProducts;
    }
    
    public function addProductToStorage(Request $request) {
        $storage = Storage::find($request->storage);
        $storage->products()->attach($request->products);
        return response("added", 201);
    }

    public function removeProductFromStorage(Request $request) {
        $storage = Storage::find($request->storage);
        $storage->products()->detach($request->products);
        return $request;
    }
}
