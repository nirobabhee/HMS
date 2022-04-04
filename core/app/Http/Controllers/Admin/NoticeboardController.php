<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\Noticeboard;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoticeboardController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments     = request()->segments();
        $noticeboards  = $this->filterNoticeboard();
        $pageTitle    = $this->pageTitle;
        $emptyMessage = $this->emptyMessage;

        return view('admin.noticeboard.index', compact('pageTitle', 'noticeboards', 'emptyMessage'));
    }
    protected function filterNoticeboard()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Noticeboard';
        $this->emptyMessage = 'No ' . request()->search . ' notic found';
        $noticeboards        = Noticeboard::query();

        if (request()->search) {
            $search          = request()->search;
            $noticeboards     = $noticeboards->where('title', 'like', "%$search%")->orWhere('start_date', 'like', "%$search%")->orWhere('end_date', 'like', "%$search%");
            $this->pageTitle = "Search Noticeboard Result for '$search'";
        }
        return $noticeboards->latest()->paginate(getPaginate());
    }

    public function create(){
        $pageTitle    = 'Add Noticeboard';
        return view('admin.noticeboard.create', compact('pageTitle'));
    }
    protected function validation($request, $id = 0)
    {
        $request->validate(
            [
                'title'      => 'required|string|max:255|unique:noticeboards,title,'.$id,
                'start_date' => 'required|date|after_or_equal:today',
                'end_date'   => 'required|date|after_or_equal:start_date',
                'description'=> 'required|string',
            ]
        );
    }
    public function store(Request $request)
    {
        $this->validation($request);
        $noticeboard              = new Noticeboard();
        $noticeboard->title       = $request->title;
        $noticeboard->start_date  = Carbon::parse($request->start_date)->format('Y-m-d');
        $noticeboard->end_date    = Carbon::parse($request->end_date)->format('Y-m-d');
        $noticeboard->description = $request->description;
        $noticeboard->save();
        $notify[] = ['success', 'New notice created successfully'];
        return redirect()->route('admin.noticeboard.index')->withNotify($notify);
    }
    public function update(Request $request, $id)
    {
        $this->validation($request, $id);
        $noticeboard              = Noticeboard::findOrFail($id);
        $noticeboard->title       = $request->title;
        $noticeboard->start_date  = Carbon::parse($request->start_date)->format('Y-m-d');
        $noticeboard->end_date    = Carbon::parse($request->end_date)->format('Y-m-d');
        $noticeboard->description = $request->description;
        $noticeboard->status      = $request->status =='on' ? 1 : 0;
        $noticeboard->save();
        $notify[] = ['success', 'Noticeboard updated successfully'];
        return redirect()->route('admin.noticeboard.index')->withNotify($notify);
    }
    public function delete(Request $request){
        $request->validate(['id' => 'required|integer']);
        Noticeboard::findOrFail($request->id)->delete();
        $notify[] = ['success', 'Notice deleted successfully'];
        return redirect()->route('admin.noticeboard.index')->withNotify($notify);

    }

    public function generatePDF(Request $request, $id)
    {
        $pageTitle = 'Noticeboard List';
        $webSiteInfo = Frontend::where('data_keys', 'site.data')->first();
        $noticeboard = Noticeboard::with('user','doctor')->where('id', $id)->firstOrFail();

        return view('admin.prescription.pdf', compact('pageTitle', 'prescription', 'siteInfo'));

        $pdf = PDF::loadView('admin.prescription.pdf', compact('pageTitle', 'prescription', 'siteInfo'));
        return $pdf->download('noticeboard-'.Carbon::now().'.pdf');
    }
}
