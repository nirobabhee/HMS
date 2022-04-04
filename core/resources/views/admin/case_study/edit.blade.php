@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.prescription.case.study.update',$caseStudy->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label> <b class="text--primary">{{ __($caseStudy->user->fullname) }} </b> @lang('Patient ID') <span class="text-danger">*</span></label>
                                        <input type="hidden" name="user_id" value="{{ $caseStudy->user->id}}" required>
                                        <input type="text" class="form-control"  value="{{ __($caseStudy->user->username) }}" readonly>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Food Allergies')</label>
                                        <input type="text" class="form-control" name="food_allergies" value="{{ $caseStudy->case_studies->food_allergies }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Tendency Bleed')</label>
                                        <input type="text" class="form-control" name="tendency_bleed" value="{{ $caseStudy->case_studies->tendency_bleed }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Heart Disease')</label>
                                        <input type="text" class="form-control" name="heart_disease" value="{{ $caseStudy->case_studies->heart_disease }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('High Blood Pressure')</label>
                                        <input type="text" class="form-control" name="high_blood_pressure" value="{{ $caseStudy->case_studies->high_blood_pressure }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Diabetic')</label>
                                        <input type="text" name="diabetic" class="form-control" value="{{ $caseStudy->case_studies->diabetic }}"/>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Surgery')</label>
                                        <input type="text" class="form-control" name="surgery" value="{{ $caseStudy->case_studies->surgery }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>@lang('Accident')</label>
                                        <input type="text" class="form-control" name="accident" value="{{ $caseStudy->case_studies->accident }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Others')</label>
                                        <input type="text" class="form-control" name="others" value="{{ $caseStudy->case_studies->others }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Family Medical History')</label>
                                        <input type="text" name="family_medical_history" class="form-control" value="{{ $caseStudy->case_studies->family_medical_history }}" />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Current Medication')</label>
                                        <input type="text" class="form-control" name="current_medication" value="{{ $caseStudy->case_studies->current_medication}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Female Pregnancy')</label>
                                        <input type="text" class="form-control" name="female_pregnancy" value="{{$caseStudy->case_studies->female_pregnancy }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Breast Feeding')</label>
                                        <input type="text" class="form-control" name="breast_feeding" value="{{ $caseStudy->case_studies->breast_feeding}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Health Insurance')</label>
                                        <input type="text" class="form-control" name="health_insurance" value="{{ $caseStudy->case_studies->health_insurance }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.users.create') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="menu-icon las la-wheelchair"></i>@lang('Add Patient')
    </a>
    <a href="{{ route('admin.prescription.case.studies.index') }}" class="btn btn-lg btn--primary text--small  mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Case Studies')
    </a>
@endpush


