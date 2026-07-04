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
     public function editDepartment($id):view
     {
        Auth::user()->can('admin')? :abort(403,'You are not authorized to access this page');

        //check if id  === 1

        if($id === 1){
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);
        return view('department.edit-department', compact('department'));
     }

     public function updateDepartment(Request $request, $id)
     {
        Auth::user()->can('admin')? :abort(403,'You are not authorized to access this page');

        $id = $request->id;

        $request->validate([
            'id'=>'required|integer|exists:departments,id',
            'name'=>'required|string|max:50|min:3|unique:departments,name,'.$id
        ]);

        //check if id  === 1

        if(intval($id) === 1){
            return redirect()->route('departments');
        }


        $department = Department::findOrFail($id);
        $department->update([
            'name'=> $request->name
        ]);

        return redirect()->route('departments');
     }

     public function deleteDepartment($id)
     {
        Auth::user()->can('admin')? :abort(403,'You are not authorized to access this page');

        //check if id  === 1

        if(intval($id) === 1){
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);
       

        return view('department.delete-department-confirm', compact('department'));
     }
}
