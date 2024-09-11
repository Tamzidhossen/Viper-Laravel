<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function category(){
        $categories =  Category::all();
        return view('admin.category.category', compact('categories'));
    }

    function category_store(Request $request){

        $request->validate([
            'category_name'=>['required', 'unique:categories'],
            'category_image'=>['required', 'mimes:png,jpg', 'max:1024'],
        ]);

        $cat_img = $request->category_image;
        $extension =  $cat_img->extension();
        $file_name = uniqid().'.'.$extension;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($cat_img);
        $image->resize(200, 150);
        $image->save(public_path('uploads/category/'.$file_name));

        Category::insert([
            'category_name'=>$request->category_name,
            'category_image'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('category_added', 'New Category Added Successfully');
    }
    function category_edit($category_id){
        $category = Category::find($category_id);
        return view('admin.category.edit', compact('category'));
    }

    function category_update(Request $request, $category_id){
        $category = Category::find($category_id);
        $request->validate([
            'category_name'=>['unique:categories'],
            'category_image'=>['mimes:png,jpg', 'max:1024'],
        ]);

        if($request->category_image != ''){
            $request->validate([
                'category_image'=>['mimes:png,jpg', 'max:1024'],
            ]);

            $delete_from = public_path('uploads/category/'. $category->category_image);
            unlink($delete_from);

            $cat_img = $request->category_image;
            $extension =  $cat_img->extension();
            $file_name = uniqid().'.'.$extension;

            $manager = new ImageManager(new Driver());
            $image = $manager->read($cat_img);
            $image->resize(200, 150);
            $image->save(public_path('uploads/category/'.$file_name));

            Category::find($category_id)->update([
                'category_name'=>$request->category_name,
                'category_image'=>$file_name,
            ]);

            return redirect()->route('category')->with('cat_update', 'Category Updated Successfully');
        }
    }

    function category_delete($category_id){
        Category::find($category_id)->delete();
        return back()->with('cat_del', 'Category Deleted Successfully');
    }

    function trash(){
        $trash_cat = Category::onlyTrashed()->get();
        return view('admin.category.trash', compact('trash_cat'));
    }

    function category_restore($category_id){
        Category::onlyTrashed()->find($category_id)->restore();
        return back()->with('restore', 'Category Restored Successfully');
    }

    function category_hard_delete($category_id){
        $category = Category::onlyTrashed()->find($category_id);

        $delete_from = public_path('uploads/category/'.$category->category_image);
        unlink($delete_from);

        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('pdel', 'Category Permanantly Deleted Successfully');
    }

    function category_check_delete(Request $request){
        foreach($request->category_id as $cat_id){
            Category::find($cat_id)->delete();
        }
        return back()->with('category_del', 'Check Category Deleted');
    }

    function category_check_restore(Request $request){
        if($request->action_btn == 1){
            foreach($request->category_id as $cat_id){
                Category::onlyTrashed()->find($cat_id)->restore();
            }
            return back()->with('restore', 'Category Restored Successfully');
        }else{
            foreach($request->category_id as $cat_id){
                $category = Category::onlyTrashed()->find($cat_id);
                $delete_from = public_path('uploads/category/'.$category->category_image);
                unlink($delete_from);
                
                Category::onlyTrashed()->find($cat_id)->forceDelete();
            }
            return back()->with('del', 'Category permanently Deleted Successfully');
        }
        
    }
}
