<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;

class RhUserController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        $colaborators = User::where('role', 'rh')->get();
        return view('colaborators.rh-users', compact('colaborators'));
    }
}
