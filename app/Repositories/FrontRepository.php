<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FrontRepository extends Controller
{
    public function getPage($page = null)
    {
        $limit = 4;
        if($page != null){
            $data = DB::table('products')->limit($limit)->offset(($page-1)*$limit)->get();
        }else {
            $data = DB::table('products')->limit($limit)->get();
        }
        return response()->json($data);
    }
}
