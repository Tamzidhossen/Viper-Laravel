<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\PassReset;
use App\Notifications\PassResetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PassResetController extends Controller
{
    function pass_reset(){
        return view('frontend.author.pass_reset');
    }

    function pass_reset_sent(Request $request){
        $author_info = Author::where('email', $request->email)->first();
        if(Author::where('email', $request->email)->exists()){
            if(PassReset::where('author_id', $author_info->id)->exists()){
                PassReset::where('author_id', $author_info->id)->delete();
            }
            $author = PassReset::create([
                'author_id'=>$author_info->id,
                'token'=>uniqid(),
            ]);

            Notification::send($author_info, new PassResetNotification($author));
            return back()->with('success', "We have sent you a password reset link to $request->email");
        } else {
            return back()->with('wrong', 'Email Dose Not Exist');
        }
    }

    function pass_reset_form($token){
        if(PassReset::where('token', $token)->exists()){
            return view('frontend.author.pass_reset_form', [
                'token'=>$token,
            ]);
        } else {
            return redirect()->route('pass.reset')->with('link', 'Invalid Password Reset Link');
        }
        
    }

    function pass_reset_update(Request $request, $token){
        $author = PassReset::where('token', $token)->first();
        if(PassReset::where('token', $token)->exists()){
            Author::find($author->author_id)->update([
                'password'=>bcrypt($request->password),
            ]);

            PassReset::where('token', $token)->delete();

            return redirect()->route('author.login.page')->with('reset', 'Password Reset Successfull');
        } else {
            return redirect()->route('pass.reset')->with('link', 'Invalid Password Reset Link');
        }
    }
}
