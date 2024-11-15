<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $data = Tag::paginate(10);
        return view('admin.tags.index', compact('data'));
    }

    public function create()
    {
        $data = new Tag();
        return view('admin.tags.create', compact('data'));
    }

    public function store(Request $request)
    {
        Tag::create(['name' => $request->name]);
        return redirect()->route('tags.index');
    }

    public function edit($id)
    {
        $data = Tag::find($id);
        return view('admin.tags.create', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $data = Tag::find($id);
        $data->update($request->all());
        return redirect()->route('tags.index');
    }
    public function destroy($id)
    {
        Tag::destroy($id);
        return redirect()->back();
    }
}
