<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RhManagementController extends Controller
{
    public function home()
    {
        Auth::user()->can('rh')?: abort(403, 'You are not authorized to access this page');

        // get all colaborators that are not admin and not rh
        $colaborators = User::withTrashed()
                            ->with('userDetail', 'department')
                            ->where('role', 'colaborator')
                            ->get();
        return view('colaborators.colaborators', compact('colaborators'));
    }
}
