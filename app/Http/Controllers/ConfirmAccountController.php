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
}
