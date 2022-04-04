<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receptionist;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReceptionistController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments       = request()->segments();
        $receptionists        = $this->filterReceptionists();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        return view('admin.receptionist.index', compact('pageTitle', 'receptionists', 'emptyMessage'));
    }
    protected function filterReceptionists()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Receptionists';
        $this->emptyMessage = 'No ' . request()->search . ' receptionists found';
        $receptionists            = Receptionist::query();


        if (request()->search) {
            $search         = request()->search;
            $receptionists        = $receptionists->where('name', 'like', "%$search%")->orWhere('email','like',"%$search%")->orWhere('mobile', 'like', "%$search%");
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $receptionists->latest()->paginate(getPaginate());
    }

    public function create()
    {
        $pageTitle   = 'Add New Receptionist';
        return view('admin.receptionist.create', compact('pageTitle'));
    }
    public function edit($id)
    {
        $pageTitle   = 'Edit Receptionist';
        $receptionist = Receptionist::where('id', $id)->firstOrfail();
        return view('admin.receptionist.edit', compact('pageTitle','receptionist'));
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $receptionist = new Receptionist();
        $this->saveReceptionist($receptionist, $request);
        $notify[] = ['success', 'Receptionist added successfully'];
        return redirect()->route('admin.receptionist.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validation($request, $id, 'nullable');
        $receptionist = Receptionist::findOrFail($id);
        $this->saveReceptionist($receptionist, $request);
        $notify[] = ['success', 'Receptionist updated successfully'];
        return back()->withNotify($notify);
    }


    protected function validation($request, $id = 0, $imgValidation = 'nullable')
    {

        $validationRule = [
            'name'          => 'required|string|max:40',
            'username'      => 'required|string|max:40|unique:receptionists,username,' . $id,
            'email'         => 'required|email|string|unique:receptionists,email,' . $id,
            'mobile'        => 'required|numeric',
            'phone'         => 'nullable|numeric',
            'address'       => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'image'         => [$imgValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ];

        if (!$id) {
            $validationRule['password'] = 'required|min:4';
        } else {
            $validationRule['password'] = 'nullable|min:4';
        }
        $request->validate($validationRule);
    }

    protected function saveReceptionist($receptionist, $request)
    {
        if ($request->hasFile('image')) {
            $location       = imagePath()['profile']['receptionist']['path'];
            $size           = imagePath()['profile']['receptionist']['size'];
            $filename       = uploadImage($request->image, $location, $size, $receptionist->image);
            $receptionist->image   = $filename;
        }

        $receptionist->name          = $request->name;
        $receptionist->username      = $request->username;
        $receptionist->email         = $request->email;
        $receptionist->password      = bcrypt($request->password);
        $receptionist->phone         = $request->phone;
        $receptionist->mobile        = $request->mobile;
        $receptionist->blood_group   = $request->blood_group;
        $receptionist->date_of_birth = Carbon::parse($request->date);
        $receptionist->address       = $request->address;
        $receptionist->save();
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $receptionist = Receptionist::findOrFail($request->id);
        $receptionist->status = 1;
        $receptionist->save();
        $notify[] = ['success', $receptionist->name . ' has been activated'];
        return redirect()->route('admin.receptionist.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $receptionist = Receptionist::findOrFail($request->id);
        $receptionist->status = 0;
        $receptionist->save();
        $notify[] = ['success', $receptionist->name . ' has been disabled'];
        return redirect()->route('admin.receptionist.index')->withNotify($notify);
    }

    public function details(Request $request, $id, $slug)
    {
        $pageTitle = 'Receptionist Details';
        $receptionist     = Receptionist::where('id', $id)->where('username', $slug)->firstOrFail();
        return view('admin.receptionist.details', compact('pageTitle', 'receptionist'));
    }
}
