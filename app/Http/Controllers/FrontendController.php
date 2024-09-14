<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function index(){
        $categories = Category::all();

        return view('frontend.index',[
            'categories'=>$categories,
        ]);
    }
}
