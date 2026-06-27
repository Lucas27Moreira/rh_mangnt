<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index():View
    {
       return view('user.profile');
    }

    public function updatePassword(Request $request)
    {
        // form validation
        $request->validate([
            'current_password' => 'required|min:8|max:16',
            'new_password' => 'required|min:8|max:16|different:current_password',
            'new_password_confitmation' => 'required|same:new_password',
        ]);

        $user = auth()->user();

        // check if the current password is correct
        if(!password_verify($request->current_password, $user->password))
        {
            return redirect()->back()->width('error','current password is incorrect');
        }

        //updatepassword in database
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->width('success','Password updated successfully.');
    }
}
