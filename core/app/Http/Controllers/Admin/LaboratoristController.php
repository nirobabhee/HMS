<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laboratorist;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaboratoristController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments       = request()->segments();
        $laboratorists        = $this->filterLaboratorists();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        return view('admin.laboratorist.index', compact('pageTitle', 'laboratorists', 'emptyMessage'));
    }
    protected function filterLaboratorists()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Laboratorists';
        $this->emptyMessage = 'No ' . request()->search . ' laboratorists found';
        $laboratorists            = Laboratorist::query();


        if (request()->search) {
            $search         = request()->search;
            $laboratorists        = $laboratorists->where('name', 'like', "%$search%")->orWhere('email','like',"%$search%")->orWhere('mobile', 'like', "%$search%");
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $laboratorists->latest()->paginate(getPaginate());
    }

    public function create()
    {
        $pageTitle   = 'Add New Laboratorist';
        return view('admin.laboratorist.create', compact('pageTitle'));
    }
    public function edit($id)
    {
        $pageTitle   = 'Edit Laboratorist';
        $laboratorist = Laboratorist::where('id', $id)->firstOrfail();
        return view('admin.laboratorist.edit', compact('pageTitle','laboratorist'));
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $laboratorist = new Laboratorist();
        $this->saveLaboratorist($laboratorist, $request);
        $notify[] = ['success', 'Laboratorist added successfully'];
        return redirect()->route('admin.laboratorist.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validation($request, $id, 'nullable');
        $laboratorist = Laboratorist::findOrFail($id);
        $this->saveLaboratorist($laboratorist, $request);
        $notify[] = ['success', 'Laboratorist updated successfully'];
        return back()->withNotify($notify);
    }


    protected function validation($request, $id = 0, $imgValidation = 'nullable')
    {

        $validationRule = [
            'name'          => 'required|string|max:40',
            'username'      => 'required|string|max:40|unique:laboratorists,username,' . $id,
            'email'         => 'required|email|string|unique:laboratorists,email,' . $id,
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

    protected function saveLaboratorist($laboratorist, $request)
    {
        if ($request->hasFile('image')) {
            $location       = imagePath()['profile']['laboratorist']['path'];
            $size           = imagePath()['profile']['laboratorist']['size'];
            $filename       = uploadImage($request->image, $location, $size, $laboratorist->image);
            $laboratorist->image   = $filename;
        }

        $laboratorist->name          = $request->name;
        $laboratorist->username      = $request->username;
        $laboratorist->email         = $request->email;
        $laboratorist->password      = bcrypt($request->password);
        $laboratorist->phone         = $request->phone;
        $laboratorist->mobile        = $request->mobile;
        $laboratorist->blood_group   = $request->blood_group;
        $laboratorist->date_of_birth = Carbon::parse($request->date);
        $laboratorist->address       = $request->address;
        $laboratorist->save();
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $laboratorist = Laboratorist::findOrFail($request->id);
        $laboratorist->status = 1;
        $laboratorist->save();
        $notify[] = ['success', $laboratorist->name . ' has been activated'];
        return redirect()->route('admin.laboratorist.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $laboratorist = Laboratorist::findOrFail($request->id);
        $laboratorist->status = 0;
        $laboratorist->save();
        $notify[] = ['success', $laboratorist->name . ' has been disabled'];
        return redirect()->route('admin.laboratorist.index')->withNotify($notify);
    }

    public function details(Request $request, $id, $slug)
    {
        $pageTitle = 'Laboratorist Details';
        $laboratorist     = Laboratorist::where('id', $id)->where('username', $slug)->firstOrFail();
        return view('admin.laboratorist.details', compact('pageTitle', 'laboratorist'));
    }
}

