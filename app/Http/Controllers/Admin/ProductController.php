<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\ProductGallery;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use ImageUpload;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $products = DB::table('products')
//            ->leftJoin('product_galleries', 'products.id', '=', 'product_galleries.product_id')
//            ->join('categories', 'products.category_id', '=', 'categories.id')
//            ->leftJoin('product_brands', 'products.brand_id', '=', 'product_brands.id')
//            ->leftJoin('product_tags', 'products.id', '=', 'product_tags.product_id')
//            ->join('tags', 'product_tags.tag_id', '=', 'tags.id')
//            ->pluck('slug')
//            ->select('products.*');
//        return DataTables::of($products)->make(true);
//        $products = Product::paginate(15);
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();
        return view('admin.products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|min:4',
            'description' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            'brand_id' => 'nullable|exists:product_brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'gallery' => 'nullable|array',
            'discount' => 'required|integer',
        ]);
        $data = $request->except(['gallery', 'tags', 'photo']);
        $photo = '';
        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                $photo = $this->uploadImage($request->file('photo'), 'products');
            }
            $data['photo'] = $photo;
            $data['stock_quantity'] = $request->discount;
            $data['user_id'] = Auth::user()->id;
            $product = Product::create($data);
            foreach ($request->tags as $tag) {
                DB::table('product_tags')->insert([
                    'product_id' => $product->id,
                    'tag_id' => $tag
                ]);
            }
            foreach ($request->gallery as $gallery) {
                $path = $this->uploadImage($gallery, 'product_gallery');
                ProductGallery::create([
                    'product_id' => $product->id,
                    'name' => $path
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::findBySlug($slug);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
