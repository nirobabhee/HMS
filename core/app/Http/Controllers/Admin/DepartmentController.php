<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments       = request()->segments();
        $departments    = $this->filterDepartments();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;


        return view('admin.department.index', compact('pageTitle', 'departments', 'emptyMessage'));
    }
    protected function filterDepartments()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Departments';
        $this->emptyMessage = 'No ' . request()->search . ' departments found';
        $departments        = Department::query();

        if (request()->search) {
            $search           = request()->search;
            $departments      = $departments->where('name', 'like', "%$search%");
            $this->pageTitle  = "Search Result for '$search'";
        }
        return $departments->latest()->paginate(getPaginate());
    }
    protected function validation($request, $id = 0)
    {
        $request->validate(
            [
                'name'        => 'required|string|max:40|unique:departments,name,' . $id,
                'description' => 'required|string',
                'icon'        => 'required',
            ]
        );
    }
    public function store(Request $request)
    {
        $this->validation($request);
        $department              = new Department();
        $department->name        = $request->name;
        $department->description = $request->description;
        $department->icon        = $request->icon;
        $department->save();
        $notify[] = ['success', 'New departments created successfully'];
        return redirect()->route('admin.department.index')->withNotify($notify);
    }
    public function update(Request $request, $id)
    {

        $this->validation($request, $id);
        $department              = Department::findOrFail($id);
        $department->name        = $request->name;
        $department->description = $request->description;
        $department->icon        = $request->icon;
        $department->status      = $request->status ? 1 : 0;
        $department->save();
        $notify[] = ['success', 'Department updated successfully'];
        return redirect()->route('admin.department.index')->withNotify($notify);
    }
}
