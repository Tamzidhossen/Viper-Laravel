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
            $author = PassReset::create([
                'author_id'=>$author_info->id,
                'token'=>uniqid(),
            ]);

            Notification::send($author_info, new PassResetNotification($author));

        } else {
            return back()->with('wrong', 'Email Dose Not Exist');
        }
    }
}
