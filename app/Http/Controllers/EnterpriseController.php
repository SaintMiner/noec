<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enterprise;
use App\Http\Resources\EnterpriseProducts as EnterpriseProducts;

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
            "regNumber" => "required|digits:11|numeric"
        ]);

        $enterprise = [
            "title" => $request->title,
            "location" => $request->location,
            "registration_number" => $request->regNumber,
        ];


        $ent = Enterprise::create($enterprise);
        $ent->storages()->sync($request->storages);
        
    }

    public function getProducts($enterpriseID) {
        $enterpriseProducts = Enterprise::find($enterpriseID)->products()->get();
        return EnterpriseProducts::collection($enterpriseProducts);
    }
}
