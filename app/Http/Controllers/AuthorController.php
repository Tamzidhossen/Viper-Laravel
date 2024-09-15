<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    function author_register(Request $request){
        $request->validate([
            'name'=> 'required',
            'email'=> ['required', 'unique:authors'],
            'password'=> ['required', Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()],
        ]);

        Author::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('author_reg', 'Registration Success Your Account is panding for Approval, you will get confirmation mail when your account will active');
    }

    function author_login(Request $request){
        if(Author::where('email', $request->email)->exists()){
            if(Auth::guard('author')->attempt(['email'=>$request->email, 'password'=>$request->password])){
                if(Auth::guard('author')->user()->status != 1){
                    Auth::guard('author')->logout();
                    return back()->with('msg', 'Your Account is pending for approval!');
                }else{
                    return redirect()->route('index');
                }
            }else{
                return back()->with('pass_wrong', 'Wrong Password');
            }
        }else{
            return back()->with('exist', 'Email Does not Exist!!');
        }
    }

    function author_logout(){
        Auth::guard('author')->logout();
        return redirect('/');
    }

    function author_dashboard(){
        return view('frontend.author.admin');
    }
}
