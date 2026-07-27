<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ColaboratorsController extends Controller
{
    public function index()
    {
          Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

          $colaborators = User::with('userDetail', 'department')->where('role', '<>', 'admin')->get();
          return view('colaborators.admin-all-colaborators')->with('colaborators', $colaborators);
    }

    public function showDetails($id)
    {
        Auth::user()->can('admin', 'rh')?: abort(403, 'You are not authorized to access this page');

        //check if id is the same as the logged in user id
        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }
        $colaborator = User::with('userDetail', 'department')->where('id', $id)->first();
        return view('colaborators.show-details')->with('colaborator', $colaborator);
    }
}
