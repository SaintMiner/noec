<?php

namespace App\Http\Controllers;

use App\Enterprise;
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

    public function getUnperfomableProducts($sale_id) {
        $sale = Sale::find($sale_id);
        $sale_products = $sale->products()->get();
        $enterprise = Enterprise::find($sale->enterprise_id);
        
        foreach ($sale_products as $product) {
            $enterprise_product = $enterprise->products()->find($product->id);
            
            $product_count = $enterprise_product->pivot->amount - $product->pivot->product_count;
            if ($product_count < 0) {
                $product->perfomable = false;
            } else {
                $product->perfomable = true;
            }
        }

        return $sale_products;
    }

    public function completeSale($sale_id) {
        $sale = Sale::find($sale_id);
        if ($sale->status == "In progress") {
            $sale_products = $sale->products()->get();
            $enterprise = Enterprise::find($sale->enterprise_id);
            foreach ($sale_products as $product) {
                $enterprise_product = $enterprise->products()->find($product->id);
                $product_count = $enterprise_product->pivot->amount - $product->pivot->product_count;
                if ($product_count < 0) {
                    $enterprise->products()->updateExistingPivot($enterprise_product->id, ["amount" => 0]);
                } else {
                    $enterprise->products()->updateExistingPivot($enterprise_product->id, ["amount" => $product_count]);
                }
            }
            $sale->status = "Completed";
            $sale->update();
            return response("Sale completed successfully!", 200);
        } else {
            return response("Sale must be in progress!", 400);
        }
    }

    public function cancelSale($sale_id) {
        $sale = Sale::find($sale_id);
        if ($sale->status == "In progress") {
            $sale->status = "Canceled";
            $sale->update();
            return response("Sale canceled successfully!", 200);
        } else {
            return response("Sale must be in progress!", 400);
        }
    }
}
