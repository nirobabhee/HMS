<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assistant;
use App\Models\Slot;
use App\Models\Schedule;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;

    public function index()
    {
        $segments       = request()->segments();
        $schedules      = $this->filterSchedules();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        return view('admin.schedule.index', compact('pageTitle', 'schedules', 'emptyMessage'));
    }
    protected function filterSchedules()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Schedules';
        $this->emptyMessage = 'No ' . request()->search . ' schedule found';
        $schedules          = Schedule::query();
        if (request()->search) {
            $search      = request()->search;
            $schedules   = $schedules->where('available_day', 'like', "%$search%")->orWhere('start_time', 'like', "%$search%")->orWhere('end_time', 'like', "%$search%")->orWhere(function ($q) use ($search) {
                $q->whereHas('doctor', function ($doctor) use ($search) {
                    $doctor->where('name', 'like', "%$search%");
                });
            })->orWhere(function ($q) use ( $search){
                $q->whereHas('assistant', function ($assistant) use ($search) {
                    $assistant->where('name', 'like', "%$search%");
                });
            });
            $this->pageTitle  = "Search Result for '$search'";
        }
        return $schedules->with('doctor','assistant', 'slot')->latest()->paginate(getPaginate());
    }

    public function create(){
        $pageTitle    = 'Add Schedule';
        $doctors      = Doctor::where('status', 1)->latest()->get();
        $assistants   = Assistant::where('status', 1)->latest()->get();
        $slots        = Slot::where('status', 1)->get();
        return view('admin.schedule.create', compact('pageTitle','doctors','assistants','slots',));
    }
    public function edit($id){
        $pageTitle    = 'Edit Schedule';
        $doctors      = Doctor::where('status', 1)->latest()->get();
        $assistants   = Assistant::where('status', 1)->latest()->get();
        $slots        = Slot::where('status', 1)->get();
        $schedule     = Schedule::where('id', $id)->firstOrfail();
        return view('admin.schedule.edit', compact('pageTitle','schedule','doctors','assistants','slots',));
    }


    protected function validation($request)
    {
        $request->validate(
            [
                'doctor'             => 'required',
                'assistant'          => 'required_with:doctor',
                'slot'               => 'required|integer',
                'available_date'     => 'required|date|after_or_equal:today',
                'per_patient_time'   => 'required',
                'serial_limit'       => 'required',
                ]
            );
    }
    public function store(Request $request)
    {
        $this->validation($request);

        $schedule                   = new Schedule();
        $schedule->doctor_id        = $request->doctor;
        $schedule->assistant_id     = $request->assistant;
        $schedule->available_date   = Carbon::parse($request->available_date);
        $schedule->slot_id          = $request->slot;
        $schedule->per_patient_time = $request->per_patient_time;
        $schedule->serial_limit     = $request->serial_limit;

        $doctor = Doctor::find($schedule->doctor_id);
        $doctor->assistants()->attach($schedule->assistant_id);

        $schedule->save();
        $notify[] = ['success', 'New schedule created successfully'];
        return redirect()->route('admin.doctor.schedule.index')->withNotify($notify);
    }
    public function update(Request $request, $id)
    {
        $this->validation($request, $id);
        $schedule              = Schedule::findOrFail($id);
        $schedule->doctor_id        = $request->doctor;
        $schedule->assistant_id     = $request->assistant;
        $schedule->available_date   = Carbon::parse($request->available_date);
        $schedule->slot_id          = $request->slot;
        $schedule->per_patient_time = $request->per_patient_time;
        $schedule->serial_limit     = $request->serial_limit;
        $schedule->status           = $request->status ? 1 : 0;

        $doctor = Doctor::find($schedule->doctor_id);
        $doctor->assistants()->attach($schedule->assistant_id);

        $schedule->save();
        $notify[] = ['success', 'Schedule updated successfully'];
        return redirect()->route('admin.doctor.schedule.index')->withNotify($notify);
    }

    public function delete(Request $request)
    {
      $schedule =   Schedule::findOrFail($request->id);
        $doctor = Doctor::find($schedule->doctor_id);
        $doctor->assistants()->detach($request->assistant);
        $schedule->delete();
        $notify[] = ['success', 'Schedule has been deleted.'];
        return redirect()->route('admin.doctor.schedule.index')->withNotify($notify);
    }




    //+++++++++ Slot Mangement ++++++++++//

    public function allSlot()
    {
        $segments       = request()->segments();
        $slots          = $this->filterSlot();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        return view('admin.schedule.slot', compact('pageTitle', 'slots', 'emptyMessage'));
    }
    protected function filterSlot()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Slots';
        $this->emptyMessage = 'No ' . request()->search . ' slot found';
        $slots              = Slot::query();
        if (request()->search) {
            $search            = request()->search;
            $slots             = $slots->where('name', 'like', "%$search%")->orWhere('from_time', 'like', "%$search%")->orWhere('to_time', 'like', "%$search%");
            $this->pageTitle   = "Search Result for '$search'";
        }
        return $slots->latest()->paginate(getPaginate());
    }
    protected function slotValidation($request, $id = 0)
    {
        $request->validate(
            [
                'name'      => 'required|string|max:40|unique:slots,name,'.$id,
                'from_time' => 'required',
                'to_time'   => 'required',
                ]
            );

        }

        public function slotStore(Request $request)
        {
        $this->slotValidation($request);
        $slot = new Slot();
        $slot->name = $request->name;
        $slot->from_time = $request->from_time;
        $slot->to_time = $request->to_time;
        $slot->save();
        $notify[] = ['success', 'New Slot created successfully'];
        return redirect()->route('admin.schedule.slot')->withNotify($notify);
    }
    public function slotUpdate(Request $request, $id)
    {
        $this->slotValidation($request, $id);
        $slot            = Slot::findOrFail($id);
        $slot->name      = $request->name;
        $slot->from_time = $request->from_time;
        $slot->to_time   = $request->to_time;
        $slot->status    = $request->status ? 1 : 0;
        $slot->save();
        $notify[] = ['success', 'Slot updated successfully'];
        return redirect()->route('admin.schedule.slot')->withNotify($notify);
    }

}
