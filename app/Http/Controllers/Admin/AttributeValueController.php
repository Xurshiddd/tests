<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AttributeValue;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeValueController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('attribute_values')
            ->leftJoin('products', 'attribute_values.product_id', '=', 'products.id')
            ->select('attribute_values.*', 'products.name as p_name')
            ->get();
//        dd($data);
        return view('admin.attribute-values.index', compact('data'));
    }
    public function create()
    {
        $attributeValue = new AttributeValue();
        return view('admin.attribute-values.create', compact('attributeValue'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'values.*' => 'required'
        ]);

        foreach ($request->values as $value) {
            if ($value instanceof \Illuminate\Http\UploadedFile) {
                $path = $this->uploadImage($value,'attribute_values' );
                AttributeValue::create([
                    'product_id' => $request->product_id,
                    'value' => $path,
                    'type' => 'file',
                ]);
            } elseif (is_string($value) && substr($value, 0, 1) == '#') {
                AttributeValue::create([
                    'product_id' => $request->product_id,
                    'value' => $value,
                    'type' => 'color',
                ]);
            } elseif (is_string($value)) {
                AttributeValue::create([
                    'product_id' => $request->product_id,
                    'value' => $value,
                    'type' => 'text',
                ]);
            }
        }
        return redirect()->route('attribute-values.index')->with('success', 'Attribute value created successfully.');
    }


    public function edit(AttributeValue $attributeValue)
    {
        return view('admin.attribute-values.create', compact('attributeValue'));
    }
    // do not work
    public function show(AttributeValue $attributeValue)
    {
        return view('admin.attribute-values.show', compact('attributeValue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttributeValue $attributeValue)
    {
        $attributeValue::update([
            'product_id' => $request->product_id,
            'attribute_value' => $request->attribute_value
        ]);
        return redirect()->route('attribute-values.index')->with('success', 'Attribute Value updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = AttributeValue::find($id);
        if ($data->type == 'file'){
            $this->deleteImage($data->value);
        }
        $data->delete();
        return redirect()->route('attribute-values.index')->with('success', 'Attribute Value deleted successfully');
    }
}
