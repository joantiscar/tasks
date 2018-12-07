<?php

namespace App\Http\Controllers;


use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{


    public function index()
    {
        $tags = map_collection(Tag::all());
        return view('tags',['tags' => $tags]);
    }
    //
    public function store(Request $request)
    {

//        dd($request->name);

        // Request::

        Tag::create([

            'name'=>$request->name,
            'description'=> $request->description,
            'color'=> $request->color

        ]);
        //Retornar a /tags
        return redirect('/tags');
    }

    public function delete(Request $request)
    {
        $tag = Tag::findorfail($request->id);
        $tag->delete();

        return redirect('/tags');
    }
    public function update(Request $request)
    {
        // Models -> Eloquent -> ORM (HIVERNATE De Java) Object Relation Model




        $tag = Tag::findorfail($request->id);
        $tag->name = $request->name;
        $tag->description = $request->description;
        $tag->color = $request->color;
        $tag->save();


//        if ($tag->description == true){
//            $tag->description = false;
//        }else{
//            $tag->description = true;
//        }
//
//        $tag->save();

        return redirect('/tags');


    }

    public function edit(Request $request)
    {

    }
}
