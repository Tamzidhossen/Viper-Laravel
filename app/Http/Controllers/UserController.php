<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Models\Author;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    function add_user(Request $request){
        User::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('add_user', 'New User Added Successfully');
    }
    function edit_profile(){
        return view('admin.user.edit_profile');
    }

    function users(){
        $users = User::all();
        return view('admin.user.users', compact('users'));
    }

    function update_profile(Request $request){
        User::find(Auth::id())->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        return back()->with('profile', 'Profile Update success');
    }
    function update_password(PasswordRequest $request){
        if(Hash::check($request->current_password, Auth::user()->password)){
            user::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('pass', 'Password Chenged');
        }else{
            return back()->with('err', 'Current Password Does not match');
        }
    }

    function update_photo(Request $request){
        $request->validate([
            'photo'=>['required', 'mimes:jpg,png', 'max:1024']
        ]);

        if(Auth::user()->photo !=null){
            $delete = public_path('uploads/user/'.Auth::user()->photo);
            unlink($delete);
        }

        $photo = $request->photo;
        $extension =  $photo->extension();
        $file_name = uniqid().'.'.$extension;
        // echo $file_name;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($photo);
        $image->resize(200, 150);
        $image->save(public_path('uploads/user/'.$file_name));

        User::find(Auth::id())->update([
            'photo'=>$file_name,
        ]);

        return back()->with('photo', 'Photo Updated');
    }

    function user_delete($user_id){
        $user = User::find($user_id);
        if($user->photo != null){
            $delete_from = public_path('uploads/user/'.$user->photo);
            unlink($delete_from);
        }

        User::find($user_id)->delete();
        return back()->with('del', 'User Deleted Successfully');
    }

    function authors(){
        $authors = Author::all();
        return view('admin.user.authors',[
            'authors'=>$authors,
        ]);
    }

    function authors_status($author_id){
        $author = Author::find($author_id);
        if($author->status == 0){
            Author::find($author_id)->update([
                'status'=>1,
            ]);
            return back();
        }else{
            Author::find($author_id)->update([
                'status'=>0,
            ]);
            return back();
        }
    }

    function authors_delete($author_id){
        Author::find($author_id)->delete();
        return back()->with('del','Author Deleted successfully');
    }
}
