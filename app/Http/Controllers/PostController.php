<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class PostController extends Controller
{
    function add_post(){
        $categories = Category::all();
        $tags = Tag::all();
        return view('frontend.author.add_post', [
            'categories'=>$categories,
            'tags'=>$tags,
        ]);
    }

    function post_store(Request $request){
        $slug = Str::lower(str_replace(' ', '-', $request->title)).'-'.random_int(10000, 200000);
        // return $slug;


        //Preview
        $preview = $request->preview;
        $extension =  $preview->extension();
        $preview_name = uniqid().'.'.$extension;
        // return $preview_name;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($preview);
        $image->resize(1000, 600);
        $image->save(public_path('uploads/post/preview/'.$preview_name));

        //Thumnail
        $thumnail = $request->thumnail;
        $extension =  $thumnail->extension();
        $thumnail_name = uniqid().'.'.$extension;
        // return $thumnail_name;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($thumnail);
        $image->resize(300, 200);
        $image->save(public_path('uploads/post/thumnail/'.$thumnail_name));

        post::insert([
            'author_id'=>Auth::guard('author')->id(),
            'category_id'=>$request->category_id,
            'read_time'=>$request->read_time,
            'title'=>$request->title,
            'slug'=>Str::lower(str_replace(' ', '-', $request->title)).'-'.random_int(10000, 200000),
            'desp'=>$request->desp,
            'tags'=>implode(',',$request->tag_id),
            'preview'=>$preview_name,
            'thumnail'=>$thumnail_name,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
    function my_post(){
        $posts = post::where('author_id', Auth::guard('author')->id())->paginate(2);
        return view('frontend.author.my_post', [
            'posts'=>$posts,
        ]);
    }

    function my_post_status($post_id){
        $post = post::find($post_id);
        if($post->status == 1){
            post::find($post_id)->update([
                'status'=>0,
            ]);
            return back();
            // return $post->status;
        }
        else{
            post::find($post_id)->update([
                'status'=>1,
            ]);
            return back();
        }
    }
    
    function my_post_delete($post_id){
        $post = post::find($post_id);
        //preview
        $delete_from = public_path('uploads/post/preview/'. $post->preview);
        unlink($delete_from);
        //thumnail
        $delete_from2 = public_path('uploads/post/thumnail/'. $post->thumnail);
        unlink($delete_from2);

        $post->delete();
        return back();
    }

}
