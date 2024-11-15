<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductBrand;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;

class ProductBrandController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = ProductBrand::paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand = new ProductBrand();
        return view('admin.brands.create', compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_brands|max:255',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
            'website' => 'nullable|url',
        ]);
//        dd($request->all());
        $path = '';
        if ($request->hasFile('logo_url')) {
            $path = $this->uploadImage($request->file('logo_url'),'brands');
        }
        $data = $request->all();
        $data['logo_url'] = $path;
        ProductBrand::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $brand = ProductBrand::find($id);
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $brand = ProductBrand::find($id);
        return view('admin.brands.create', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $brand = ProductBrand::find($id);
        $path = '';
        if ($request->hasFile('logo_url')) {
            $path = $this->replaceImage($request->file('logo_url'), $brand->logo_url,'brands');
        }
        $data = $request->all();
        $data['logo_url'] = $path;
        $brand->update($data);
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = ProductBrand::find($id);
        $this->deleteImage($data->logo_url);
        $data->delete();
        return redirect()->back();
    }
}
