<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Popular;
use App\Models\post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    function index(){
        $tags=Tag::all();
        $categories = Category::all();
        $posts = post::where('status', 1)->paginate(3);
        $sliders = post::where('status', 1)->latest()->take(3)->get();
        $popular_posts = Popular::where('total_read', '>', 4)->get();

        return view('frontend.index',[
            'categories'=>$categories,
            'tags'=> $tags,
            'posts'=> $posts,
            'sliders'=> $sliders,
            'popular_posts'=> $popular_posts,
        ]);
    }

    function author_login_page(){
        return view('frontend.author.login');
    }

    function author_register_page(){
        return view('frontend.author.signup');
    }

    function post_details($slug){
        $post = post::where('slug', $slug)->first();

        if(Popular::where('post_id', $post->id)->exists()){
            Popular::where('post_id', $post->id)->increment('total_read', 1);
        }else{
            Popular::insert([
                'post_id'=>$post->id,
                'total_read'=>1,
            ]);
        }

        $comments = Comment::with('replies')->where('post_id', $post->id)->whereNull('parent_id')->get();
        return view('frontend.post_details', [
            'post'=>$post,
            'comments'=>$comments,
        ]);
    }

    function author_post($author_id){
        $author = Author::find($author_id);
        $posts = post::where('author_id', $author_id)->where('status', 1)->get();
        return view('frontend.author_post',[
            'author'=>$author,
            'posts'=>$posts,
        ]);
    }

    function category_post($category_id){
        $category = Category::find($category_id);
        $posts = post::where('category_id', $category_id)->get();
        return view('frontend.category_post', [
            'category'=>$category,
            'posts'=>$posts,
        ]);
    }

    function search(Request $request){
        $data = $request->all();

        $search_posts = post::where(function ($q) use ($data){
            if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $q->where('title', 'like', '%' . $data['q'] . '%');
                    $q->orWhere('desp', 'like', '%' . $data['q'] . '%');
                });
            }
        })->paginate(2);

        $tags = Tag::all();
        $categories = Category::all();
        $popular_posts = Popular::where('total_read', '>', 4)->get();
        
        return view('frontend.search', [
            'search_posts'=>$search_posts,
            'tags'=>$tags,
            'categories'=>$categories,
            'popular_posts'=>$popular_posts,
        ]);
    }

    function tag_post($tag_id){
        $all = '';
        foreach(post::all() as $post){
            $after_explode = explode(',', $post->tags);
            if(in_array($tag_id, $after_explode)){
                $all .= $post->id.',';
            }
        }
        $explode2 = explode(',', $all);
        $tag_post = post::find($explode2);
        $tag = Tag::find($tag_id);

        return view('frontend.tag_post', [
            'tag_post'=>$tag_post,
            'tag'=>$tag,
        ]);
    }

    function comment_store(Request $request){
        Comment::insert([
            'author_id'=>Auth::guard('author')->id(),
            'post_id'=>$request->post_id,
            'comments'=>$request->comments,
            'parent_id'=>$request->parent_id,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
}
