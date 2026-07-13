<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Verifica se o usuário autenticado é admin.
     */
    private function authorizeAdmin(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'You are not authorized to access this page');
        }
    }

    public function index(): View
    {
        $this->authorizeAdmin();

        $departments = Department::all();
        return view('department.departments', compact('departments'));
    }

    public function newDepartment(): View
    {
        $this->authorizeAdmin();

        return view('department.add-department');
    }

    public function createDepartment(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:50|unique:departments',
        ]);

        Department::create([
            'name' => $request->name,
        ]);

        return redirect()->route('departments');
    }

    public function editDepartment($id): View|RedirectResponse
    {
        $this->authorizeAdmin();

        $id = (int) $id;

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.edit-department', compact('department'));
    }

    public function updateDepartment(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $id = (int) $request->input('id');

        $request->validate([
            'id'   => 'required|integer|exists:departments,id',
            'name' => 'required|string|max:50|min:3|unique:departments,name,' . $id,
        ]);

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->name,
        ]);

        return redirect()->route('departments');
    }

    public function deleteDepartment($id): View|RedirectResponse
    {
        $this->authorizeAdmin();

        $id = (int) $id;

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.delete-department-confirm', compact('department'));
    }

    public function deleteDepartmentConfirm($id): RedirectResponse
    {
        $this->authorizeAdmin();

        $id = (int) $id;

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('departments');
    }

    private function isDepartmentBlocked($id)
    {
        return in_array(intval($id), [1, 2]);
    }
}
