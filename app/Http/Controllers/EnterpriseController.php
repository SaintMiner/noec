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

    public function getProducts($enterpriseID) {
        $enterpriseProducts = Enterprise::find($enterpriseID)->products()->get();
        return EnterpriseProducts::collection($enterpriseProducts);
    }
}
