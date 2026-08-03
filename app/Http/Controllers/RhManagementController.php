<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Department;

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

    public function newColaborator()
    {
        Auth::user()->can('rh')?: abort(403, 'You are not authorized to access this page');

        $departments = Department::where('id', '>', 2)->get();

        // if there are no departments, redirect to departments page
        if($departments->count() === 0){
            abort(403, 'You need to create a department before creating a colaborator');
        }

        return view('colaborators.add-colaborator', compact('departments'));
    }
}
