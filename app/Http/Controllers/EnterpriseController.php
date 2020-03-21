<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enterprise;
use App\Product;
use App\Http\Resources\EnterpriseProducts as EnterpriseProducts;
use App\Http\Resources\EnterpriseStorages as EnterpriseStorages;

use App\Http\Resources\StorageFullInfo as StorageInfo;

class EnterpriseController extends Controller
{
    public function index() {
        return Enterprise::all();
    }

    public function store(Request $request) {
        // return $request->regNumber;
        $this->validate($request, [
            "title" => "required|min:3|max:255",
            "location" => "required|min:3|max:255",
            "registration_number" => "required|digits:11|numeric|unique:enterprises"
        ]);
        
        $enterprise = Enterprise::create($request->all());
        $enterprise->storages()->sync($request->storages);
        return response("created", 201);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            "title" => "required|min:3|max:255",
            "location" => "required|min:3|max:255",
            "registration_number" => "required|digits:11|numeric"
        ]);
        
        $enterprise = Enterprise::find($id);
        if ($request->registration_number != $enterprise->registration_number) {
            $this->validate($request, [
                "registration_number" => "required|digits:11|numeric|unique:enterprises",
            ]);
        }
        $enterprise->storages()->sync($request->storages);
        $enterprise->update($request->all());
        return response("updated", 201);
    }

    public function getNotIncludedProducts($enterpriseID) {
        $enterprise = Enterprise::find($enterpriseID);
        $enterpriseStorages = $enterprise->storages()->get();
        $enterpriseStoragesProducts = [];
        foreach($enterpriseStorages as $storage) {
            foreach ($storage->products()->get()->pluck("id") as $product) {
                array_push($enterpriseStoragesProducts, $product);
            }
        }
        
        $enterpriseStoragesProducts = array_values(array_unique($enterpriseStoragesProducts));
        $enterpriseProductsIDs = $enterprise->products()->get()->pluck("id");
        $notIncludedProducts = Product::whereNotIn("id", $enterpriseProductsIDs)->get();
        foreach ($notIncludedProducts as $product) {
            if (in_array($product->id, $enterpriseStoragesProducts)) {
                $product->included = true;
            } else {
                $product->included = false;
            }
        }
        return $notIncludedProducts;
    }

    public function getProducts($enterpriseID) {
        $enterpriseProducts = Enterprise::find($enterpriseID)->products()->get();
        return EnterpriseProducts::collection($enterpriseProducts);
    }

    public function getStorages($enterpriseID) {
        $enterpriseStorages = Enterprise::find($enterpriseID)->storages()->get();
        return EnterpriseStorages::collection($enterpriseStorages);
    }

    public function isRegNumberFree($registration_number) {
        return ["isFree" => count(Enterprise::where("registration_number","=", $registration_number)->get())];
    }

    public function attachProducts(Request $request) {
        $enterprise = Enterprise::find($request->enterpriseID);
        $enterprise->products()->attach($request->products);
        return $enterprise;
    }
}
