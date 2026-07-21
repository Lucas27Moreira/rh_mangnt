<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ConfirmAccountController extends Controller
{
    public function confirmAccount($token)
    {
       // check if the token is valid and confirm the account
       $user = User::where('confirmation_token', $token)->first();

       if(!$user) {
           abort(403, 'Invalid confirmation token.');
       }

       return view('auth.confirm-account', compact('user'));
    }

    public function confirmAccountSubmit(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('confirmation_token', $request->token)->first();

        if (!$user) {
            abort(403, 'Invalid confirmation token.');
        }

        $user->update([
            'password' => bcrypt($request->password),
            'confirmation_token' => null,
        ]);

        return redirect()->route('login')->with('status', 'Account confirmed successfully.');
    }
}
