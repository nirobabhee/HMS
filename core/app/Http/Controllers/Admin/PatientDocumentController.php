<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Document;
use App\Models\DocumentAttachment;
use App\Models\User;
use Illuminate\Http\Request;

class PatientDocumentController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments       = request()->segments();
        $documents       = $this->filterPatients();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        return view('admin.document.index', compact('pageTitle', 'documents', 'emptyMessage'));
    }
    protected function filterPatients()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Patient Documents';
        $this->emptyMessage = 'No ' . request()->search . ' patient document found';
        $documents           = Document::query();

        if (request()->search) {
            $search     = request()->search;
            $documents  = $documents->where(function ($q) use ($search) {
                $q->whereHas('doctor', function ($doctor) use ($search) {
                    $doctor->where('name', 'like', "%$search%");
                });
            })->orWhere(function ($q) use ($search) {
                $q->whereHas('user', function ($patient) use ($search) {
                    $patient->where('username', 'like', "%$search%");
                });
            });
            $this->pageTitle = "Search Result for '$search'";
        }
        return $documents->with('user', 'doctor', 'admin', 'attachments')->latest()->paginate(getPaginate());
    }



    public function create()
    {
        $pageTitle   = 'Add Patient Documents';
        $users  = User::where('status', 1)->latest()->get();
        $doctors  = Doctor::where('status', 1)->latest()->get();
        return view('admin.document.create', compact('pageTitle', 'users', 'doctors'));
    }

    public function store(Request $request)
    {
        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');

        $request->validate([
            'attachments' => [
                'max:4096',
                function ($attribute, $value,$fail) use ($attachments, $allowedExts) {
                    foreach ($attachments as $attachment) {
                        $ext = strtolower($attachment->getClientOriginalExtension());


                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf, doc, docx files are allowed");
                        }
                        if (($attachment->getSize() / 1000000) > 2) {
                            return $fail("Miximum 2MB file size allowed!");
                        }
                    }
                    if (count($attachments) > 5) {
                        return $fail("Maximum 5 files can be uploaded");
                    }
                }
            ],

            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',

        ]);

        $document = new Document();
        $document->user_id = $request->user_id;
        $document->doctor_id = $request->doctor_id;
        $document->description = $request->description;
        $document->admin_id = auth()->guard('admin')->id();
        $document->save();
        $path = imagePath()['documents']['path'];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $attachment = new DocumentAttachment();
                    $attachment->attachment = uploadFile($file, $path);
                    $attachment->document_id = $document->id;
                    $attachment->save();
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $file];
                    return back()->withNotify($notify)->withInput();
                }
            }
        }
        $notify[] = ['success', 'Documents attached successfully'];
        return redirect()->route('admin.user.documents')->withNotify($notify);
    }


    public function viewAttachments($id)
    {
        $pageTitle   = 'Patient Attachments';
        $emptyMessage   = 'No attachment found';
        $attachments  = DocumentAttachment::where('document_id', $id)->get();
        return view('admin.document.attachment_view', compact('pageTitle', 'attachments', 'emptyMessage'));
    }

    public function download($id)
    {
        $attachment = DocumentAttachment::findOrFail($id);
        $file = $attachment->attachment;
        $path = imagePath()['documents']['path'];
        $full_path = $path . '/' . $file;
        $title = slug($attachment->created_at) . '-' . $file;
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

    public function delete(Request $request)
    {
        $documents = Document::findOrFail($request->id);
        $attachments =   DocumentAttachment::where('document_id', $request->id)->get();
        $path = imagePath()['documents']['path'];

        if ($attachments->count() > 0) {
            foreach ($attachments as $attachment) {
                removeFile($path.'/'.$attachment->attachment);
                $attachment->delete();
            }
        }
        $documents->delete();
        $notify[] = ['success', "Documents delete successfully"];
        return back()->withNotify($notify);
    }
}
