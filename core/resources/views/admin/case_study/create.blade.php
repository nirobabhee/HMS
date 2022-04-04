@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.prescription.case.study.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label><b class="user_name text--primary"></b> @lang('Patient ID') <span class="text-danger">*</span>  </label>
                                        <select class="select2-basic form-control" name="user_id" required>
                                            <option value="" disabled selected>@lang('Select  Patient ID')</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" data-name="{{ $user->fullname}}">{{ __($user->username) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Food Allergies')</label>
                                        <input type="text" class="form-control" name="food_allergies" value="{{old('food_allergies')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Tendency Bleed')</label>
                                        <input type="text" class="form-control" name="tendency_bleed" value="{{old('tendency_bleed')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Heart Disease')</label>
                                        <input type="text" class="form-control" name="heart_disease" value="{{old('heart_disease')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('High Blood Pressure')</label>
                                        <input type="text" class="form-control" name="high_blood_pressure" value="{{old('high_blood_pressure')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Diabetic')</label>
                                        <input type="text" name="diabetic" class="form-control" value="{{old('diabetic')}}"/>
                                    </div>

                                    <div class="col-12 form-group">
                                        <label>@lang('Surgery')</label>
                                        <input type="text" class="form-control" name="surgery" value="{{old('surgery')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>@lang('Accident')</label>
                                        <input type="text" class="form-control" name="accident" value="{{old('accident')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Others')</label>
                                        <input type="text" class="form-control" name="others" value="{{old('others')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Family Medical History')</label>
                                        <input type="text" name="family_medical_history" class="form-control" value="{{old('family_medical_history')}}" />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Current Medication')</label>
                                        <input type="text" class="form-control" name="current_medication" value="{{old('current_medication')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Female Pregnancy')</label>
                                        <input type="text" class="form-control" name="female_pregnancy" value="{{old('female_pregnancy')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Breast Feeding')</label>
                                        <input type="text" class="form-control" name="breast_feeding" value="{{old('breast_feeding')}}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Health Insurance')</label>
                                        <input type="text" class="form-control" name="health_insurance" value="{{old('health_insurance')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
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
@push('script')
    <script>
        (function($) {
            'use strict';
            $('select[name=user_id]').on('change', function(){
                var user  = $(this).find('option:selected').data('name');
                $(".user_name").text(user);
            });

        })(jQuery)
    </script>
@endpush
