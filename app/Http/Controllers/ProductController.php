<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return Product::all();
    }

    public function store(Request $request) {
        $this->validate($request, [
            "name" => "required|min:3|max:256",
            "price" => "required|numeric",
            "amount_per_palete" => "required|numeric",
        ]);

        Product::create($request->all());
        return response("created", 201);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            "name" => "required|min:3|max:256",
            "price" => "required|numeric",
            "amount_per_palete" => "required|numeric",
        ]);
        $product = Product::find($id);
        $product->update($request->all());
        return response("updated", 201);
    }

    public function destroy($id) {
        $product = Product::find($id);
        $product->delete();
    }
}
