<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index()
    {

        Auth::user()->can('admin')? :abort(403,'You are not authorized to access this page');

        $departments = Department::all();
        return view('department.departments', compact('departments'));
    }

     public function newDepartment():view
     {
        return view('department.add-department');
     }

     public function createDepartment(Request $request)
     {
        Auth::user()->can('admin')? :abort(403,'You are not authorized to access this page');

        // form validation
        $request->validate([
            'name'=>'required|string|max:50|unique:departments'
        ]);

        Department::create([
            'name'=> $request->name
        ]);

        return redirect()->route('departments');
     }
}
