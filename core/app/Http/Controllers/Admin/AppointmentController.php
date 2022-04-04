<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    protected $pageTitle;
    protected $emptyMessage;

    public function index()
    {
        $segments       = request()->segments();
        $appointments      = $this->filterAppointments();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        return view('admin.appointment.index', compact('pageTitle', 'appointments', 'emptyMessage'));
    }
    public function assign($assign_by)
    {
        $segments       = request()->segments();
        $appointments   = $this->filterAppointments($assign_by);
        if($assign_by == 1){
            $pageTitle      ='Admin '. $this->pageTitle ;
        }elseif($assign_by == 2){
            $pageTitle      ='Doctor '. $this->pageTitle ;
        }elseif($assign_by == 3){
            $pageTitle      ='Receptionist '. $this->pageTitle ;
        }
        $emptyMessage   = $this->emptyMessage;
        return view('admin.appointment.index', compact('pageTitle', 'appointments', 'emptyMessage'));
    }
    protected function filterAppointments($assign_by=null)
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Appointments';
        $this->emptyMessage = 'No ' . request()->search . ' appointment found';
        $appointments            = Appointment::query();
        if (request()->search) {
            $search         = request()->search;
            $appointments   = $appointments->where('appointment_no', 'like', "%$search%")->orWhere('priority', 'like', "%$search%")->orWhere('booking_date', 'like', "%$search%")->orWhere(function ($q) use ($search) {
                $q->whereHas('doctor', function ($doctor) use ($search) {
                    $doctor->where('name', 'like', "%$search%");
                });
            })->orWhere(function ($q) use ($search) {
                $q->whereHas('user', function ($patient) use ($search) {
                    $patient->where('username', 'like', "%$search%");
                });
            })->orWhere(function ($q) use ($search) {
                $q->whereHas('department', function ($department) use ($search) {
                    $department->where('name', 'like', "%$search%");
                });
            });
            $this->pageTitle    = "Search Result for '$search'";
        }
        if ($assign_by) {
            return $appointments->where('assign_by', $assign_by)->with('department', 'doctor', 'user','schedule', 'slot')->latest()->paginate(getPaginate());
        }

        return $appointments->with('department', 'doctor', 'user','schedule', 'slot')->latest()->paginate(getPaginate());
    }


    public function create()
    {
        $pageTitle   = 'Add Appointment';
        $users       = User::where('status', 1)->latest()->get();
        $departments = Department::with('doctors')->whereHas('doctors', function ($doctors) {
                        $doctors->where('status', 1);
                    })->where('status', 1)->latest()->get();
                    $doctors    = Doctor::with('schedules')->whereHas('schedules', function ($schedules) {
                        $schedules->where('status', 1);
                    })->where('status', 1)->latest()->get();
        $schedules = Schedule::with('slot')->where('status', 1)->where('available_date', '>=', Carbon::now())->latest()->get();
        return view('admin.appointment.create', compact('pageTitle', 'users', 'departments', 'doctors', 'schedules'));
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $checklimit        = Schedule::with('slot')->where('doctor_id', $request->doctor_id)->where('available_date', $request->available_date)->firstOrFail();
        $todaysAppointment = Appointment::where('doctor_id', $checklimit->doctor_id)->where('booking_date', $checklimit->available_date)->get();
        $checkSerial       = $todaysAppointment->count();
        foreach ($todaysAppointment as $value) {
            if($value->user_id == $request->user_id && $value->doctor_id == $request->doctor_id && $value->doctor_id == $request->available_date){
                $notify[] = ['error', 'You alreary appointed the doctor with schedule'];
                return redirect()->back()->withNotify($notify);
            }
        }

        if($checkSerial ==  $checklimit->serial_limit || $checkSerial >  $checklimit->serial_limit){
            $notify[] = ['error', 'Doctor serial limit had exceeded'];
            return redirect()->back()->withNotify($notify);
        }
        $appointment                   = new Appointment();
        $appointment->appointment_no   = 'APN'.mt_rand(100000, 9999999);
        $appointment->user_id          = $request->user_id;
        $appointment->department_id    = $request->department_id;
        $appointment->doctor_id        = $request->doctor_id;
        $appointment->slot_id          = $request->slot_id;
        $appointment->booking_date     = $request->available_date;
        $appointment->fee              = $request->fee;
        $appointment->serial_no        = $checkSerial + 1;
        $appointment->priority         = $request->priority;
        $appointment->disease_details  = $request->disease_details;
        $appointment->assign_by        = 1; //Admin
        $appointment->save();
        $general = GeneralSetting::first();
        $patient = User::findOrFail($appointment->user_id);
        $doctor = Doctor::findOrFail($appointment->doctor_id);
        notify($patient, 'APPOINTMENT_CONFIRMATION', [
            'appointment_no' => $appointment->appointment_no,
            'booking_date' => $appointment->booking_date,
            'serial_no' => $appointment->serial_no,
            'doctor_name' => $doctor->name,
            'doctor_fee' => ''.$doctor->fee.' '.$general->cur_text.'',
            'appointment_slot' => ''.$checklimit->slot->from_time.' - '.$checklimit->slot->to_time.'',
        ]);
        $notify[] = ['success', 'New appointment created successfully'];
        return redirect()->route('admin.appointment.index')->withNotify($notify);
    }
    protected function validation($request)
    {
        $request->validate(
            [
                'user_id'            => 'required|integer',
                'department_id'      => 'required|integer',
                'doctor_id'          => 'required|integer',
                'slot_id'            => 'required|integer',
                'available_date'     => 'required|date',
                'fee'                => 'required',
                'priority'           => 'required',
                'live_consultant'    => 'nullable|integer',
                'disease_details'    => 'nullable|string',
            ]
        );
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $appointment = Appointment::findOrFail($request->id);
        $appointment->status = 1;
        $appointment->save();
        $notify[] = ['success', $appointment->appointment_no . ' has been activated'];
        return redirect()->route('admin.appointment.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $appointment = Appointment::findOrFail($request->id);
        $appointment->status = 0;
        $appointment->save();
        $notify[] = ['success', $appointment->appointment_no . ' has been disabled'];
        return redirect()->route('admin.appointment.index')->withNotify($notify);
    }
}
