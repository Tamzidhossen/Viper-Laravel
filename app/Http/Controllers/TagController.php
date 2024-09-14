<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function tags(){
        $tags = Tag::all();
        return view('admin.tag.tag',[
            'tags'=>$tags,
        ]);
    }

    function tags_store(Request $request){
        Tag::insert([
            'tag_name' => $request->tag_name,
            'created_at' => Carbon::now(),
        ]);

        return back();
    }

    function tags_delete($tag_id){
        Tag::find($tag_id)->delete();
        return back();
    }
}
