<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ["enterprise_id", "discount"];

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot("product_count", "selling_price");
    }

    public function enterprise() {
        return $this->belongsTo(Enterprise::class);
    }

    public function getTotalCost() {
        $products = $this->products;
        $total = 0;
        foreach($products as $product) {
            $total += $product->pivot->selling_price*$product->pivot->product_count;
        }
        return $total;
    }
}
