<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enterprise;
use App\Http\Resources\EnterpriseProducts as EnterpriseProducts;
use App\Http\Resources\EnterpriseStorages as EnterpriseStorages;

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
            "registration_number" => "required|digits:11|numeric|unique:enterprises"
        ]);
        
        $enterprise = Enterprise::find($id);
        if ($request->registration_number != $enterprise->registration_number) {

        }
        $enterprise->storages()->sync($request->storages);
        $enterprise->update($request->all());
        return response("updated", 201);
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
}
