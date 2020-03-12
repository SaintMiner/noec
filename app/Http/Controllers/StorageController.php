<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Storage;
use App\Product;
use App\Http\Resources\StorageProducts as StorageProducts;

class StorageController extends Controller
{
    public function index() {
        return Storage::all();
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
        $storage = Storage::find($id);
        $palete_amount = $storage->products()->find($request->productID)->pivot->palete_amount;
        $storage->products()->updateExistingPivot($request->productID, ["palete_amount" => $palete_amount+$request->palleteCount]);
        // $storage->products()->where("product_id", $request->productID)->get();
        
        // return $storage->products()->where("product_id", $request->productID)->get();

        return response("added", 201);
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
}
