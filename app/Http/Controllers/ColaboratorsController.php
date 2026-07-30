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

          $colaborators = User::withTrashed()
                            ->with('userDetail', 'department')
                            ->where('role', '<>', 'admin')
                            ->get();
          return view('colaborators.admin-all-colaborators')->with('colaborators', $colaborators);
    }

    public function showDetails($id)
    {
        Auth::user()->can('admin', 'rh')?: abort(403, 'You are not authorized to access this page');

        //check if id is the same as the logged in user id
        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }
        $colaborator = User::with('userDetail', 'department')
                            ->where('id', $id)
                            ->first();

                            //check if colaborator is null
        if (!$colaborator) {
            abort(404, 'Colaborator not found');
        }
        return view('colaborators.show-details')->with('colaborator', $colaborator);
    }

    public function deleteColaborator($id)
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        //check if id is the same as the logged in user id
        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }
        $colaborator = User::findOrFail($id);
        return view('colaborators.delete-colaborator-confirm')->with('colaborator', $colaborator);
    
        }

        public function deleteColaboratorConfirm($id)
        {
            Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

            //check if id is the same as the logged in user id
            if (Auth::user()->id == $id) {
                return redirect()->route('home');
            }
            $colaborator = User::findOrFail($id);
            $colaborator->delete();
            return redirect()->route('colaborators.all-colaborators');
        }

        public function restoreColaborator($id)
        {
            Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');


            $colaborator = User::withTrashed()->findOrFail($id);
            $colaborator->restore();
            return redirect()->route('colaborators.all-colaborators');
        }
}
