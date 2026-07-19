<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmAccountEmail;

class RhUserController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        $colaborators = User::with('userDetail')->where('role', 'rh')->get();
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
            'select_department' => 'required|exists:departments,id',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ]);

        // check if the department id == 2
        if ($request->select_department != 2) {
           return redirect()->route('home');
        }

        $token = Str::random(60);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->role = 'rh';
        $user->department_id = $request->select_department;
        $user->permissions = '["rh"]';
        $user->save();

        // save user details
        $user->userDetail()->create([
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'admission_date' => $request->admission_date,
        ]);

        // send confirmation email
        Mail::to($user->email)->send(new ConfirmAccountEmail(route('confirm-account',  $token)));


        // $user->password = Hash::make('password123');
        // $user->address = $request->address;
        // $user->zip_code = $request->zip_code;
        // $user->city = $request->city;
        // $user->phone = $request->phone;
        // $user->salary = $request->salary;

        return redirect()->route('colaborators.rh-users')->with('success', 'Colaborator created successfully.');
    }

    public function editRhColaborator($id)
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        $colaborator = User::with('userDetail')->where('role', 'rh')->findOrFail($id);

        return view('colaborators.edit-rh-user', compact('colaborator'));
    }

    public function updateRhColaborator(Request $request)
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        $request->validate([
            'id' => 'required|exists:users,id',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ]);

       $user = User::findOrFail($request->user_id);
       $user->userDetail()->update([
            'salary' => $request->salary,
            'admission_date' => $request->admission_date,
        ]);

        return redirect()->route('colaborators.rh-users')->with('success', 'Colaborator updated successfully.');
    }

    public function deleteRhColaborator($id)
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        $colaborator = User::findOrFail($id);

        return view('colaborators.delete-rh-user', compact('colaborator'));
    }

    public function deleteRhColaboratorConfirm($id)
    {
        Auth::user()->can('admin')?: abort(403, 'You are not authorized to access this page');

        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('colaborators.rh-users')->with('success', 'Colaborator deleted successfully.');
    }
}
