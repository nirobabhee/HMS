<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments       = request()->segments();
        $doctors        = $this->filterDoctors();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        return view('admin.doctor.index', compact('pageTitle', 'doctors', 'emptyMessage'));
    }
    protected function filterDoctors()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Doctors';
        $this->emptyMessage = 'No ' . request()->search . ' doctors found';
        $doctors            = Doctor::query();


        if (request()->search) {
            $search         = request()->search;
            $doctors        = $doctors->where('name', 'like', "%$search%")->orWhere('designation', 'like', "%$search%")->orWhere(function ($q) use ($search) {
                $q->whereHas('department', function ($department) use ($search) {
                    $department->where('name', 'like', "%$search%");
                });
            });
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $doctors->with('department')->latest()->paginate(getPaginate());
    }

    public function create()
    {
        $pageTitle   = 'Add New Doctor';
        $departments = Department::where('status', 1)->latest()->get();
        return view('admin.doctor.create', compact('pageTitle', 'departments'));
    }
    public function edit($id)
    {
        $pageTitle   = 'Edit Doctor';
        $departments = Department::where('status', 1)->get();
        $doctor = Doctor::where('id', $id)->firstOrfail();
        return view('admin.doctor.edit', compact('pageTitle', 'departments', 'doctor'));
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $doctor = new Doctor();
        $this->saveDoctor($doctor, $request);
        $notify[] = ['success', 'Doctor added successfully'];
        return redirect()->route('admin.doctor.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validation($request, $id, 'nullable');
        $doctor = Doctor::findOrFail($id);
        $this->saveDoctor($doctor, $request);
        $notify[] = ['success', 'Doctor updated successfully'];
        return back()->withNotify($notify);
    }


    protected function validation($request, $id = 0, $imgValidation = 'nullable')
    {

        $validationRule = [
            'name'          => 'required|string|max:40',
            'username'      => 'required|string|max:40|unique:doctors,username,' . $id,
            'email'         => 'required|email|string|unique:doctors,email,' . $id,
            'department'    => 'required',
            'designation'   => 'required|string|max:40',
            'fee'           => 'required|gt:0',
            'address'       => 'nullable|string|max:500',
            'mobile'        => 'required|numeric',
            'phone'         => 'nullable|numeric',
            'date_of_birth' => 'nullable|date',
            'youtube'       => 'nullable|url',
            'facebook'      => 'nullable|url',
            'linkedin'      => 'nullable|url',
            'twitter'       => 'nullable|url',
            'google_plus'   => 'nullable|url',
            'image'         => [$imgValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],

        ];

        if (!$id) {
            $validationRule['password'] = 'required|min:4';
        } else {
            $validationRule['password'] = 'nullable|min:4';
        }
        $request->validate($validationRule);
    }

    protected function saveDoctor($doctor, $request)
    {
        if ($request->hasFile('image')) {
            $location       = imagePath()['profile']['doctor']['path'];
            $size           = imagePath()['profile']['doctor']['size'];
            $filename       = uploadImage($request->image, $location, $size, $doctor->image);
            $doctor->image  = $filename;
        }

        $doctor->name          = $request->name;
        $doctor->username      = $request->username;
        $doctor->email         = $request->email;
        $doctor->password      = bcrypt($request->password);
        $doctor->address       = $request->address;
        $doctor->phone         = $request->phone;
        $doctor->mobile        = $request->mobile;
        $doctor->department_id = $request->department;
        $doctor->designation   = $request->designation;
        $doctor->fee           = $request->fee;
        $doctor->gender        = $request->gender;
        $doctor->blood_group   = $request->blood_group;
        $doctor->date_of_birth = $request->date;

        $socials = [];
        $socials['youtube']      = $request->youtube;
        $socials['facebook']     = $request->facebook;
        $socials['linkedin']     = $request->linkedin;
        $socials['twitter']      = $request->twitter;
        $socials['google_plus']  = $request->google_plus;
        $doctor->social_links    = $socials;
        $doctor->save();
    }


    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $doctor = Doctor::findOrFail($request->id);
        $doctor->status = 1;
        $doctor->save();
        $notify[] = ['success', $doctor->name . ' has been activated'];
        return redirect()->route('admin.doctor.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $doctor = Doctor::findOrFail($request->id);
        $doctor->status = 0;
        $doctor->save();
        $notify[] = ['success', $doctor->name . ' has been disabled'];
        return redirect()->route('admin.doctor.index')->withNotify($notify);
    }

    public function details(Request $request, $id, $slug)
    {
        $pageTitle = 'Doctor Details';
        $doctor = Doctor::where('id', $id)->where('username', $slug)->firstOrFail();
        return view('admin.doctor.details', compact('pageTitle', 'doctor'));
    }
}
