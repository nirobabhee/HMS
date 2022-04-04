@extends('admin.layouts.app')
@section('panel')
    <div class="mb-none-30">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.appointment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-control-label font-weight-bold">@lang('Patient Username')<span
                                        class="text--danger">*</span></label>
                                <select class="select2-basic form-control" name="user_id" required>
                                    <option value="" disabled selected>@lang('Select Patient ID')</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ __($user->username) }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label  font-weight-bold">@lang('Department') <span
                                        class="text--danger">*</span></label>
                                <select class="form-control" name="department_id" required>
                                    <option value="" disabled selected>@lang('Select One')</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ __($department->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-control-label font-weight-bold">@lang('Doctor')<span
                                        class="text--danger">*</span></label>
                                <select class="form-control" name="doctor_id" data-doctors="{{ $doctors }}" required>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label  font-weight-bold">@lang('Appointment / Available Date')
                                    <span class="text--danger">*</span></label>
                                <select class="form-control" name="available_date" required>
                                    <option value="" disabled selected>@lang('Select One')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-control-label font-weight-bold">@lang('Slot')<span
                                        class="text--danger">*</span></label>
                                <select class="form-control" name="slot_id" data-schedule="{{ $schedules }}" required>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label  font-weight-bold">@lang('Fee') <span
                                        class="text--danger">*</span></label>
                                <input type="text" name="fee" value="" class="form-control" readonly required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-control-label font-weight-bold">@lang('Priority')<span
                                        class="text--danger">*</span></label>
                                <select class="form-control" name="priority" required>
                                    <option value="1">@lang('Normal')</option>
                                    <option value="2">@lang('Urgent') </option>
                                    <option value="3">@lang('Very Urgent') </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label  font-weight-bold">@lang('Live Consultant (On Video
                                    Conference)') <span class="text--danger">*</span></label>
                                <select class="form-control" name="live_consultant" required>
                                    <option value="0">@lang('No')</option>
                                    <option value="1">@lang('Yes')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label>@lang('Disease Details') </label>
                            <textarea name="disease_details" class="form-control">{{ old('disease_details') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.users.create') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="menu-icon las la-wheelchair"></i>@lang('Add Patient')
    </a>
    <a href="{{ route('admin.appointment.index') }}" class="btn btn-lg btn--primary text--small  mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Appointments')
    </a>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            'use strict';
            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }

            //departmentWiseDoctorShow
            $('select[name="doctor_id"] option').remove()
            $('select[name=department_id]').on('change', function() {
                $('select[name="doctor_id"] option').remove()
                var department_id = $(this).val();
                var doctors = $('select[name=doctor_id]').data('doctors');
                if (doctors) {
                    $('select[name="doctor_id"]').append(
                        `<option value="" disabled selected> @lang('Select One') </option>`);
                    $.each(doctors, function(index, value) {
                        if (value.department_id == department_id) {
                            $('select[name="doctor_id"]').append(
                                `<option value="${value.id}" data-fee="${value.fee}"> ${value.name} </option>`
                                );
                        }
                    });
                    if ($('select[name=doctor_id] option').length < 1) {
                        $('select[name="doctor_id"]').append(
                            `<option value="" selected disabled> @lang('No Doctor Found') </option>`);
                    }
                }
            }); //End

            //doctorWiseAppointmentDateShow
            $('select[name="available_date"] option').remove()
            $('select[name=doctor_id]').on('change', function() {
                $('select[name="available_date"] option').remove();
                var doctor_id = $(this).val();
                var schedules = $('select[name=slot_id]').data('schedule');
                if (schedules) {
                    $('select[name="available_date"]').append(
                        `<option value="" disabled selected> @lang('Select One') </option>`);
                    $.each(schedules, function(index, value) {
                        if (value.doctor_id == doctor_id) {
                            $('select[name="available_date"]').append(
                                `<option value="${value.available_date}"> ${value.available_date} </option>`
                                );
                        }
                    });
                    if ($('select[name=slot_id] option').length < 1) {
                        $('select[name="slot_id"]').append(
                            `<option value="" selected disabled> @lang('No Schedule Found') </option>`);
                    }
                    $('input[name=fee]').val($('select[name=doctor_id]').find(":selected").data('fee'));

                }
            }); //End


            //dateWiseScheduleShow
            $('select[name="slot_id"] option').remove()
            $('select[name=available_date]').on('change', function() {
                $('select[name="slot_id"] option').remove();
                var date = $(this).val();
                var schedules = $('select[name=slot_id]').data('schedule');

                if (schedules) {
                    $.each(schedules, function(index, value) {
                        // console.log(value.slot_id);
                        if (value.available_date == date) {
                            $('select[name="slot_id"]').append(
                                `<option value="${value.slot_id}"  > ${value.slot.from_time} - ${value.slot.to_time}</option>`
                                );
                        }
                    });
                    if ($('select[name=available_date] option').length < 1) {
                        $('select[name="available_date"]').append(
                            `<option value="" selected disabled> @lang('No Date Found') </option>`);
                    }
                }
            }); //End




        })(jQuery)
    </script>
@endpush
