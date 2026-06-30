<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {

        Auth::user()->can('admin')? :abort(403,'You are not authorized to access this page');

        $departments = Department::all();
        return view('department.departments', compact('departments'));
    }
}
