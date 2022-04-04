<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CaseStudy;
use App\Models\Doctor;
use App\Models\Frontend;
use App\Models\User;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class PrescriptionController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments       = request()->segments();
        $prescriptions  = $this->filterPrescriptions();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        return view('admin.prescription.index', compact('pageTitle', 'prescriptions', 'emptyMessage'));
    }
    protected function filterPrescriptions()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Prescriptions';
        $this->emptyMessage = 'No ' . request()->search . ' prescription found';
        $prescriptions            = Prescription::query();


        if (request()->search) {
            $search         = request()->search;
            $prescriptions        = $prescriptions->where('visiting_fee', 'like', "%$search%")->orWhere('appointment_no', 'like', "%$search%")->orWhere('type', 'like', "%$search%")->orWhere(function ($q) use ($search) {
                $q->whereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                });
            });
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $prescriptions->with('user','appointment')->latest()->paginate(getPaginate());
    }




    public function create()
    {
        $pageTitle   = 'Add New Prescription';
        $appointmentNo = 'APN'.mt_rand(100000, 9999999);
        $users = User::with('appointment','caseStudy')->where('status', 1)->latest()->get();
        $doctors = Doctor::with('department')->where('status', 1)->latest()->get();
        return view('admin.prescription.create', compact('pageTitle', 'users', 'appointmentNo','doctors'));
    }



    public function store(Request $request)
    {


        $user           = User::findOrFail($request->user_id);
        // dd($user);
        $appointment    = Appointment::where('user_id', $user->id)->first();
        $this->validation($request);
        $prescription   = new Prescription();
        $this->savePrescription($user, $appointment, $prescription, $request);
        $notify[]       = ['success', 'Prescription added successfully'];
        return redirect()->route('admin.prescription.index')->withNotify($notify);
    }




    protected function validation($request)
    {
        $request->validate([
            'doctor_id'        => 'nullable|integer',
            'prime_complain'   => 'required|max:500',
            'type'             => 'required',
            'visiting_fee'     => 'nullable|numeric',
            'patient_note'     => 'nullable|string',
            'medicine_name.*'  => 'sometimes|required',
            'diagnosis.*'      => 'sometimes|required',

        ]);
    }

    protected function savePrescription($user, $appointment, $prescription, $request)
    {

        if(!$appointment){
            $appointment = new Appointment();
            $appointment->appointment_no = $request->appointment_no;
            $appointment->user_id        = $user->id;
            $appointment->doctor_id      = $request->doctor_id;
            $appointment->department_id  = $request->department;
            $appointment->priority       = 3; //very_urgent
            $appointment->fee            = $request->visiting_fee;
            $appointment->assign_by      = 1; //Admin
            $appointment->save();
        }

        $prescription->user_id           = $request->user_id;
        $prescription->doctor_id         = $request->doctor_id ?? $appointment->doctor_id;
        $prescription->appointment_no    = $request->appointment_no;
        $prescription->prime_complain    = $request->prime_complain;
        $prescription->type              = $request->type;



        $medicines = [];
        if ($request->has('medicine_name')) {
            for ($m = 0; $m < count($request->medicine_name); $m++) {

                $arr = [];
                $arr['medicine_name']             =  $request->medicine_name[$m];
                $arr['medicine_type']             = $request->medicine_type[$m];
                $arr['medicine_instruction']      = $request->medicine_instruction[$m];
                $arr['days']                      = $request->days[$m];
                $medicines[$arr['medicine_name']] = $arr;
            }
        }

        $diagnosis = [];
        if ($request->has('diagnosis')) {
            for ($d = 0; $d < count($request->diagnosis); $d++) {

                $arr = [];
                $arr['diagnosis']                        = $request->diagnosis[$d];
                $arr['diagnosis_instruction']            = $request->diagnosis_instruction[$d];
                $diagnosis[$arr['diagnosis']] = $arr;
            }
        }


        $prescription->medicine              = $medicines;
        $prescription->diagnosis              = $diagnosis;
        $prescription->patient_notes          = $request->patient_notes;
        $prescription->visiting_fee           = $request->visiting_fee;
        $prescription->save();
    }

    public function status(Request $request)
    {
        $prescription = Prescription::findOrFail($request->id);
        $prescription->status    = $request->status == 'on' ? 1 : 0;
        $prescription->save();
        $notify[] = ['success', 'Prescription status changed successfully'];
        return back()->withNotify($notify);
    }

    public function details(Request $request, $id, $slug)
    {
        $pageTitle = 'Prescription Details';
        $siteInfo = Frontend::where('data_keys', 'site.data')->first();
        $prescription = Prescription::with('user','doctor')->where('id', $id)->where('appointment_no', $slug)->firstOrFail();
        return view('admin.prescription.details', compact('pageTitle', 'prescription', 'siteInfo'));
    }

    public function generatePDF(Request $request, $id)
    {
        $pageTitle = 'Prescription Details';
        $siteInfo = Frontend::where('data_keys', 'site.data')->first();
        $prescription = Prescription::with('user','doctor')->where('id', $id)->firstOrFail();

        return view('admin.prescription.pdf', compact('pageTitle', 'prescription', 'siteInfo'));

        $pdf = PDF::loadView('admin.prescription.pdf', compact('pageTitle', 'prescription', 'siteInfo'));
        return $pdf->download( $prescription->user->username.'-prescription-'.Carbon::now().'.pdf');
    }




    // --------Case - Study-------//
    public function caseStudies()
    {
        $segments      = request()->segments();
        $caseStudies   = $this->filterCaseStudies();
        $pageTitle     = $this->pageTitle;
        $emptyMessage  = $this->emptyMessage;

        return view('admin.case_study.index', compact('pageTitle', 'caseStudies', 'emptyMessage'));
    }
    protected function filterCaseStudies()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' Case Studies';
        $this->emptyMessage = 'No ' . request()->search . ' case study found';
        $caseStudies        = CaseStudy::query();


        if (request()->search) {
            $search         = request()->search;
            $caseStudies    = $caseStudies->where(function ($q) use ($search) {
                $q->whereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%")->orWhere('firstname','like', "%$search%");
                });
            });
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $caseStudies->with('user')->latest()->paginate(getPaginate());
    }

    public function createCaseStudy()
    {
        $pageTitle   = 'Add New Case Study';
        $users    = User::where('status', 1)->latest()->get();
        return view('admin.case_study.create', compact('pageTitle','users'));
    }
    public function editCaseStudy($id)
    {
        $pageTitle   = 'Edit Case Study';
        $caseStudy   = CaseStudy::with('user')->where('id', $id)->firstOrfail();
        return view('admin.case_study.edit', compact('pageTitle','caseStudy'));
    }

    public function storeCaseStudy(Request $request)
    {
        $this->validationCaseStudy($request);
        $patientCaseStudy = new CaseStudy();
        $this->saveCaseStudy($patientCaseStudy, $request);
        $notify[] = ['success', 'Case Study added successfully'];
        return redirect()->route('admin.prescription.case.studies.index')->withNotify($notify);
    }
    public function updateCaseStudy(Request $request, $id)
    {
        $this->validationCaseStudy($request, $id);
        $patientCaseStudy = CaseStudy::findOrFail($id);
        $this->saveCaseStudy($patientCaseStudy, $request);
        $notify[] = ['success', 'Case Study updated successfully'];
        return back()->withNotify($notify);
    }


    protected function validationCaseStudy($request)
    {
        $request->validate([
            'user_id'         => 'required|string|max:40',
            'food_allergies'  => 'nullable|string|',
            'tendency_bleed'  => 'nullable|string|max:500',
            'heart_disease'       => 'nullable|string|max:500',
            'high_blood_pressure' => 'nullable|string|max:500',
            'diabetic'            => 'nullable|string|max:500',
            'surgery'    => 'nullable|string|max:500',
            'accident'   => 'nullable|string|max:500',
            'others'     => 'nullable|string|max:500',
            'family_medical_history'  => 'nullable|string|max:500',
            'current_medication'      => 'nullable|string|max:500',
            'female_pregnancy'        => 'nullable|string|max:500',
            'breast_feeding'          => 'nullable|string|max:500',
            'health_insurance'        => 'nullable|string|max:500',
        ]);


    }

    protected function saveCaseStudy($patientCaseStudy, $request)
    {
        $patientCaseStudy->user_id             = $request->user_id;
        $case_study = [];
        $case_study['food_allergies']          = $request->food_allergies;
        $case_study['tendency_bleed']          = $request->tendency_bleed;
        $case_study['heart_disease']           = $request->heart_disease;
        $case_study['high_blood_pressure']     = $request->high_blood_pressure;
        $case_study['diabetic']                = $request->diabetic;
        $case_study['surgery']                 = $request->surgery;
        $case_study['accident']                = $request->accident;
        $case_study['others']                  = $request->others;
        $case_study['family_medical_history']  = $request->family_medical_history;
        $case_study['current_medication']      = $request->current_medication;
        $case_study['female_pregnancy']        = $request->female_pregnancy;
        $case_study['breast_feeding']          = $request->breast_feeding;
        $case_study['health_insurance']        = $request->health_insurance;
        $patientCaseStudy->case_studies        = $case_study;
        $patientCaseStudy->save();
    }

}
