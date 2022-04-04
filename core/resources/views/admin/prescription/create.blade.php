@extends('admin.layouts.app')
@section('panel')
    <div class="mb-none-30">
            <form action="{{ route('admin.prescription.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        @csrf

                        <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label><b class="patient_name text--primary"></b> @lang('Patient ID') <span  class="text-danger">*</span> </label>
                                <select class="select2-basic form-control" name="user_id" required>
                                    <option value="" disabled selected>@lang('Select Patient ID')</option>
                                    @foreach ($users as $user)
                                        <option data-patient="{{ $user }}" value="{{ $user->id }}"
                                            data-name='{{ $user->fullname }}'
                                            data-appointment='{{ @$user->appointment }}'
                                            data-appointment-no='{{ $appointmentNo }}'
                                            data-case-study='{{ $user->caseStudy }}'>
                                            {{ __($user->username) }} </option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>@lang('Patient Name')</label>
                                    <input type="text" name="user_name" value="{{ old('name') }}" class="form-control" readonly />
                                </div>
                            </div>
                        <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>@lang('Appointment No') <span  class="text-danger">*</span><span></span></label>
                                <input type="text" name="appointment_no" value="{{ old('appointment_no') }}" class="form-control" required readonly />
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label> @lang('Appointment Doctor')  </label>
                                    <input type="hidden" name="department">
                                    <select class="select2-basic form-control" name="doctor_id">
                                        <option value="" disabled selected>@lang('Select Doctor')</option>
                                        @foreach ($doctors as $doctor)
                                            <option data-department='{{$doctor->department->id}}' value="{{ $doctor->id }}"'> {{ __($doctor->username) }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="row">
                                <div class="col-sm-6 form-group">
                                        <label>@lang('Date Of Birth')</label>
                                        <input type="text" name="date_of_birth" class="form-control" readonly />

                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>@lang('Weight / Kg') </label>
                                        <input type="number" name="weight" value="{{ old('weight') }}"  class="form-control" readonly />
                                </div>
                            </div>
                        <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>@lang('Gender')</label>
                                    <input type="text" name="gender" value="{{ old('gender') }}" class="form-control" readonly />

                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>@lang('Type')</label>
                                        <select class="form-control" name="type">
                                            <option value="1">@lang('New')</option>
                                            <option value="2">@lang('Old')</option>
                                        </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>@lang('Prime Complain') <span class="text-danger">*</span></label>
                                    <textarea name="prime_complain" cols="30" rows="2" class="form-control" required></textarea>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <button type="button" class="btn btn--info caseStudyBtn mt-3 d-none"><span  class="text--white patient_name"></span> @lang('Case Study ') </button>
                                </div>
                            </div>







                            {{--Add Medicines --}}
                            <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="card border--primary">
                                    <h5 class="card-header bg--primary">@lang('Medicines')
                                        <button type="button" class="btn btn-sm btn-outline-light float-right addMedicine ">
                                            <i class="la la-fw la-plus"></i>@lang('Add Medicine ')
                                        </button>
                                    </h5>

                                    <div class="card-body">
                                        <div class="row addedMedicine">
                                            <div class="col-md-12 medicine-data ">
                                                <div class="form-group">
                                                    <div class="input-group mb-md-0 mb-4">
                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                            <input class="form-control" type="text" name="medicine_name[]" placeholder="Medicine Name">
                                                        </div>
                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                            <input class="form-control" type="text" name="medicine_type[]" placeholder="Medicine Type">
                                                        </div>
                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                            <textarea class="form-control" rows="1" name="medicine_instruction[]" placeholder="Medicine Instruction"></textarea>
                                                        </div>
                                                        <div class="col-md-2 mt-md-0 mt-2">
                                                            <input class="form-control" type="text" name="days[]" placeholder="Days">
                                                        </div>
                                                        <div class="col-md-1 mt-md-0 mt-2 text-right">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn--danger btn-lg removeBtn w-100" type="button">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>


                            {{-- Add Diagnosis --}}
                            <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="card border--primary">
                                    <h5 class="card-header bg--primary">@lang('Diagnosis')
                                        <button type="button" class="btn btn-sm btn-outline-light float-right addDiagnosis ">
                                            <i class="la la-fw la-plus"></i>@lang('Add Diagnosis ')
                                        </button>
                                    </h5>

                                    <div class="card-body">
                                        <div class="row diagnosisFieldAdded">
                                            <div class="col-md-12 medicine-data ">
                                                <div class="form-group">
                                                    <div class="input-group mb-md-0 mb-4">
                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                            <input class="form-control" type="text" name="diagnosis[]" placeholder="Daignosis ">
                                                        </div>

                                                        <div class="col-md-8 mt-md-0 mt-2">
                                                            <textarea class="form-control" rows="1" name="diagnosis_instruction[]" placeholder="Daignosis Instruction"></textarea>
                                                        </div>

                                                        <div class="col-md-1 mt-md-0 mt-2 text-right">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn--danger btn-lg removeBtn w-100" type="button">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>@lang('Visiting Fee')</label>
                                    <input type="number" name="visiting_fee" class="form-control" />
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>@lang('Patient Note')</label>
                                    <textarea name="patient_notes"  rows="1" class="form-control" required></textarea>
                                </div>
                            </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>



        {{-- Case Study Modal --}}
        <div class="modal fade" id="caseStudyModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('Case Study Details ') </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4 mt-2">  <h6>@lang('Food Allergies')</h6>  </div>
                                <div class="col-sm-8 mt-2">  <p class="food_allergies"></p> </div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Heart Disease')</h6>  </div>
                                <div class="col-sm-8 mt-2">  <p class="heart_disease"></p>  </div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Tendency Bleed')</h6> </div>
                                <div class="col-sm-8 mt-2">  <p class="tendency_bleed"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('High Blood Pressure')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="high_blood_pressure"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Diabetic')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="diabetic"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Surgery')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="surgery"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Accident')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="accident"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Current Medication')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="current_medication"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Others')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="others"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Female Pregnancy')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="female_pregnancy"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Breast Feeding')</h6></div>
                                <div class="col-sm-8 mt-2">   <p class="breast_feeding"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Health Insurance')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="health_insurance"></p></div>
                                <div class="col-sm-4 mt-2">  <h6>@lang('Family Medical History')</h6></div>
                                <div class="col-sm-8 mt-2">  <p class="family_medical_history"></p></div>
                            </div>
                        </div>
                        <div class="modal-footer"> </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('style')
    <style>
        textarea { min-height: 40px; }
    </style>
    @endpush


    @push('breadcrumb-plugins')
        <a href="{{ route('admin.prescription.index') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
            <i class="fa fa-fw fa-list"></i>@lang('All Prescriptions')
        </a>
    @endpush

    @push('script')
        <script>
            (function($) {
                'use strict';
                var modal = $('#caseStudyModal');
                $('select[name=user_id]').on('change', function() {
                    var text = ' - ';
                    var patient = $(this).find('option:selected').data('name');
                    $(".patient_name").text(patient + text);

                    console.log($(this).find('option:selected').data('name'));

                    //-----------Defendency-
                    var patient = $(this).find('option:selected').data('patient');
                    $('input[name=user_name]').val(patient.firstname+' '+patient.lastname)
                    $('input[name=date_of_birth]').val(patient.date_of_birth)
                    $('input[name=weight]').val(patient.weight)
                    $('input[name=reference]').val(patient.reference)
                    if (patient.gender == 1) {
                        $('input[name=gender]').val('Male')
                    } else if (patient.gender == 2)
                        $('input[name=gender]').val('Female')
                    else {
                        $('input[name=gender]').val('Others')
                    }
                    var appointment = $(this).find('option:selected').data('appointment');
                    var AppNo = $(this).find('option:selected').data('appointment-no');
                    if (appointment.length > 0) {
                        $('input[name=appointment_no]').val(appointment[0].appointment_no);
                        $('.doctor').addClass('d-none');
                    } else {
                        $('input[name=appointment_no]').val(AppNo);
                        $('.doctor').removeClass('d-none');

                    }
                    //dr/-dept
                        $('select[name=doctor_id]').on('change', function() {
                            var department = $(this).find('option:selected').data('department');
                            $('input[name=department]').val(department);
                        }); //end





                    //--------Modal view
                    var result = $(this).find('option:selected').data('case-study');
                    if (result.length > 0) {
                        modal.find('.food_allergies').text(`${result[0].case_studies.food_allergies}`);
                        modal.find('.tendency_bleed').text(`${result[0].case_studies.tendency_bleed}`);
                        modal.find('.high_blood_pressure').text(`${result[0].case_studies.high_blood_pressure}`);
                        modal.find('.heart_disease').text(`${result[0].case_studies.heart_disease}`);
                        modal.find('.diabetic').text(`${result[0].case_studies.diabetic}`);
                        modal.find('.surgery').text(`${result[0].case_studies.surgery}`);
                        modal.find('.accident').text(`${result[0].case_studies.accident}`);
                        modal.find('.current_medication').text(`${result[0].case_studies.current_medication}`);
                        modal.find('.others').text(`${result[0].case_studies.others}`);
                        modal.find('.female_pregnancy').text(`${result[0].case_studies.female_pregnancy}`);
                        modal.find('.breast_feeding').text(`${result[0].case_studies.breast_feeding}`);
                        modal.find('.family_medical_history').text(`${result[0].case_studies.family_medical_history}`);
                        modal.find('.health_insurance').text(`${result[0].case_studies.health_insurance}`);
                        $('.caseStudyBtn').removeClass('d-none')
                    } else {
                        $('.caseStudyBtn').addClass('d-none')
                    }
                }); //End


                $('.caseStudyBtn').on('click', function() {
                    modal.modal('show');
                })








                //--------Medicines-
                $('.addMedicine ').on('click', function () {
                var html = `
                        <div class="col-md-12 medicine-data ">
                            <div class="form-group">
                                <div class="input-group mb-md-0 mb-4">
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <input class="form-control" type="text" name="medicine_name[]" placeholder="Medicine Name" required>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <input class="form-control" type="text" name="medicine_type[]" placeholder="Medicine Type" required>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <textarea rows="1" placeholder="Medicine Instruction" name="medicine_instruction[]" required></textarea>
                                    </div>
                                    <div class="col-md-2 mt-md-0 mt-2">
                                        <input class="form-control" type="text" name="days[]" placeholder="Days" required>
                                    </div>
                                    <div class="col-md-1 mt-md-0 mt-2 text-right">
                                        <span class="input-group-btn">
                                            <button class="btn btn--danger btn-lg removeBtn w-100" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                $('.addedMedicine').append(html);
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.medicine-data').remove();
            });





                //-----------Diagnosis-
                $('.addDiagnosis ').on('click', function () {
                var html = `
                        <div class="col-md-12 diagnosis-data ">
                            <div class="form-group">
                                <div class="input-group mb-md-0 mb-4">
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <input class="form-control" type="text" name="diagnosis[]" placeholder="Daignosis" required>
                                    </div>
                                    <div class="col-md-8 mt-md-0 mt-2">
                                        <textarea class="form-control" rows="1" name="diagnosis_instruction[]" placeholder="Daignosis Instruction" required></textarea>
                                    </div>
                                    <div class="col-md-1 mt-md-0 mt-2 text-right">
                                        <span class="input-group-btn">
                                            <button class="btn btn--danger btn-lg diagnosisRemoveBtn w-100" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                $('.diagnosisFieldAdded').append(html);
            });

            $(document).on('click', '.diagnosisRemoveBtn', function () {
                $(this).closest('.diagnosis-data').remove();
            });





            })(jQuery);
        </script>
    @endpush
