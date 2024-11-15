<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DataRepository extends Controller
{
    public function getProductsAll()
    {
        $data = \DB::table('products');
        return DataTables::of($data)->make(true);
    }

    public function postUpdateProduct(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string',
            'availability' => 'required|string'
        ]);
        try {
            DB::table('products')
                ->where('slug', $validated['slug'])
                ->update(['availability' => $validated['availability']]);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Product availability updated unsuccessfully!']);
        }

        return response()->json(['message' => 'Product availability updated successfully!']);
    }
}
