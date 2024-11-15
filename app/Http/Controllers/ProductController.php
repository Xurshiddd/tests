<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function show($slug)
    {
        $data['product'] = DB::table('products')->where('slug', $slug)->first();
        $data['product_galleries'] = DB::table('product_galleries')->where('product_id', $data['product']->id)->get();
        $data['product_brands'] = DB::table('product_brands')
            ->rightJoin('products', 'product_brands.id', '=','products.brand_id')
            ->where('products.id', $data['product']->id)->first();
        $data['product_categories'] = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.id', $data['product']->id)->first();
        $data['product_tags'] = DB::table('products')
            ->join('product_tags', 'products.id', '=', 'product_tags.product_id')
            ->join('tags', 'product_tags.tag_id', '=', 'tags.id')
            ->select('tags.*')
            ->where('product_id', $data['product']->id)->get();
        $data['attributes'] = DB::table('attribute_values')->where('product_id', $data['product']->id)->get();
//        dd($data);
        return view('front.productshow', $data);
    }
}
