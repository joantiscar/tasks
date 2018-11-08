<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreTag;
use App\Http\Requests\UpdateTag;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    //
    public function show(Request $request, Tag $tag) // Route Model Binding
    {

        return $tag;

//        return Tag::findOrFail($request->tags);
    }
    public function destroy(Request $request, Tag $tag) // Route Model Binding
    {
        $tag->delete();

//        return Tag::findOrFail($request->tags);
    }



    public function update(UpdateTag $request, Tag $tag) // Route Model Binding
    {
        $tag->name = $request->name;
        $tag->description = $request->description;
        $tag->color = $request->color;
        $tag->save();




//        return Tag::findOrFail($request->tags);
    }
    public function store(StoreTag $request) // Route Model Binding
    {
//        Tag::create();

//          $request->validate([
//            'name' => 'required',
//        ]);


        $tag = new Tag();
        $tag->name = $request->name;
        $tag->description = $request->description;
        $tag->color = $request->color;
        $tag->save();
        return $tag;
//        return Tag::findOrFail($request->tags);
    }
    public function index(Request $request)
    {
        return Tag::orderBy('created_at','desc')->get();
    }
}
