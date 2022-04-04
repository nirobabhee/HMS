<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assistant;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments     = request()->segments();
        $assistants   = $this->filterAssistant();
        $pageTitle    = $this->pageTitle;
        $emptyMessage = $this->emptyMessage;

        return view('admin.doctor_assistant.index', compact('pageTitle', 'assistants', 'emptyMessage'));
    }
    protected function filterAssistant()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Doctor Assistants ';
        $this->emptyMessage = 'No ' . request()->search . ' doctor assistant found';
        $assistants         = Assistant::query();

        if (request()->search) {
            $search             = request()->search;
            $assistants   = $assistants->where('name', 'like', "%$search%")->orWhere('mobile', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $assistants->latest()->paginate(getPaginate());
    }

    public function create()
    {
        $pageTitle   = 'Add Doctor Assistant';
        return view('admin.doctor_assistant.create', compact('pageTitle'));
    }
    public function edit($id)
    {
        $pageTitle   = 'Edit Doctor Assistant';
        $assistant = Assistant::where('id', $id)->firstOrfail();
        return view('admin.doctor_assistant.edit', compact('pageTitle', 'assistant'));
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $assistant = new Assistant();
        $this->saveAssistant($assistant, $request);
        $notify[] = ['success', 'Assistant added successfully'];
        return redirect()->route('admin.doctor.assistant.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validation($request, $id, 'nullable');
        $assistant = Assistant::findOrFail($id);
        $this->saveAssistant($assistant, $request);
        $notify[] = ['success', 'Doctor Assistant updated successfully'];
        return back()->withNotify($notify);
    }


    protected function validation($request, $id = 0, $imgValidation = 'nullable')
    {
        $request->validate([
            'name'          => 'required|string|max:40',
            'email'         => 'required|email|string|unique:assistants,email,' . $id,
            'mobile'        => 'required|numeric|unique:assistants,mobile,' . $id,
            'address'       => 'nullable|string|max:500',
            'blood_group'   => 'required',
            'date'          => 'nullable|date',
            'image'         => [$imgValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
    }

    protected function saveAssistant($assistant, $request)
    {
        if ($request->hasFile('image')) {
            $location       = imagePath()['profile']['doctor_assistant']['path'];
            $size           = imagePath()['profile']['doctor_assistant']['size'];
            $filename       = uploadImage($request->image, $location, $size, $assistant->image);
            $assistant->image  = $filename;
        }
        $assistant->name          = $request->name;
        $assistant->email         = $request->email;
        $assistant->mobile        = $request->mobile;
        $assistant->blood_group   = $request->blood_group;
        $assistant->date_of_birth = Carbon::parse($request->date);
        $assistant->address       = $request->address;
        $assistant->save();
    }


    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $assistant = Assistant::findOrFail($request->id);
        $assistant->status = 1;
        $assistant->save();
        $notify[] = ['success', $assistant->name . ' has been activated'];
        return redirect()->route('admin.doctor.assistant.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $assistant = Assistant::findOrFail($request->id);
        $assistant->status = 0;
        $assistant->save();
        $notify[] = ['success', $assistant->name . ' has been disabled'];
        return redirect()->route('admin.doctor.assistant.index')->withNotify($notify);
    }
}
