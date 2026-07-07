<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;

class RhUserController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        $colaborators = User::where('role', 'rh')->get();
        return view('colaborators.rh-users', compact('colaborators'));
    }

    public function newColaborator()
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        // get all departments
        $departments = Department::all();


        return view('colaborators.add-rh-user', compact('departments'));
    }

    public function createRhColaborator(Request $request)
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'department' => 'required|exists:departments,id',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'rh';
        $user->password = Hash::make('password123');
        $user->department_id = $request->department;
        $user->permissions = '';
        $user->save();

        return redirect()->route('colaborators.rh-users')->with('success', 'Colaborator created successfully.');
    }
}
