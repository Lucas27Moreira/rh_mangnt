<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
       Auth::user()->can('admin')?: abort(403, 'Unauthorized action.');
        return view('home');
    }
}
