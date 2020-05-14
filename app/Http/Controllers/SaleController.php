<?php

namespace App\Http\Controllers;

use App\Sale;
use Illuminate\Http\Request;
use App\Http\Resources\Sale as SaleResource;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SaleResource::collection(Sale::all()->sortByDesc("created_at"));
    }

    public function store(Request $request) {
        $this->validate($request, [
            "discount" => "numeric|min:0|max:100",
            "product.*.count" => "numeric|min:1",
            "products.*.sellingPrice" => "numeric|min:1",
        ]);
        
        $sale = Sale::create($request->all());
        forEach($request->products as $product) {
            $sale->products()->attach($product["id"], ["product_count" => $product["count"], "selling_price" => $product["sellingPrice"]]);
        }
        return $request;
    }
}
