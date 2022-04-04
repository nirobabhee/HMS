<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accountant;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AccountantController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments       = request()->segments();
        $accountants        = $this->filterAccountants();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        return view('admin.accountant.index', compact('pageTitle', 'accountants', 'emptyMessage'));
    }
    protected function filterAccountants()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Accountants';
        $this->emptyMessage = 'No ' . request()->search . ' accountants found';
        $accountants            = Accountant::query();


        if (request()->search) {
            $search         = request()->search;
            $accountants        = $accountants->where('name', 'like', "%$search%")->orWhere('email','like',"%$search%")->orWhere('mobile', 'like', "%$search%");
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $accountants->latest()->paginate(getPaginate());
    }

    public function create()
    {
        $pageTitle   = 'Add New Accountant';
        return view('admin.accountant.create', compact('pageTitle'));
    }
    public function edit($id)
    {
        $pageTitle   = 'Edit Accountant';
        $accountant = Accountant::where('id', $id)->firstOrfail();
        return view('admin.accountant.edit', compact('pageTitle','accountant'));
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $accountant = new Accountant();
        $this->saveAccountant($accountant, $request);
        $notify[] = ['success', 'Accountant added successfully'];
        return redirect()->route('admin.accountant.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validation($request, $id, 'nullable');
        $accountant = Accountant::findOrFail($id);
        $this->saveAccountant($accountant, $request);
        $notify[] = ['success', 'Accountant updated successfully'];
        return back()->withNotify($notify);
    }


    protected function validation($request, $id = 0, $imgValidation = 'nullable')
    {

        $validationRule = [
            'name'          => 'required|string|max:40',
            'username'      => 'required|string|max:40|unique:accountants,username,' . $id,
            'email'         => 'required|email|string|unique:accountants,email,' . $id,
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

    protected function saveAccountant($accountant, $request)
    {
        if ($request->hasFile('image')) {
            $location       = imagePath()['profile']['accountant']['path'];
            $size           = imagePath()['profile']['accountant']['size'];
            $filename       = uploadImage($request->image, $location, $size, $accountant->image);
            $accountant->image   = $filename;
        }

        $accountant->name          = $request->name;
        $accountant->username      = $request->username;
        $accountant->email         = $request->email;
        $accountant->password      = bcrypt($request->password);
        $accountant->phone         = $request->phone;
        $accountant->mobile        = $request->mobile;
        $accountant->blood_group   = $request->blood_group;
        $accountant->date_of_birth = Carbon::parse($request->date);
        $accountant->address       = $request->address;
        $accountant->save();
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $accountant = Accountant::findOrFail($request->id);
        $accountant->status = 1;
        $accountant->save();
        $notify[] = ['success', $accountant->name . ' has been activated'];
        return redirect()->route('admin.accountant.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $accountant = Accountant::findOrFail($request->id);
        $accountant->status = 0;
        $accountant->save();
        $notify[] = ['success', $accountant->name . ' has been disabled'];
        return redirect()->route('admin.accountant.index')->withNotify($notify);
    }

    public function details(Request $request, $id, $slug)
    {
        $pageTitle = 'Accountant Details';
        $accountant     = Accountant::where('id', $id)->where('username', $slug)->firstOrFail();
        return view('admin.accountant.details', compact('pageTitle', 'accountant'));
    }
}
