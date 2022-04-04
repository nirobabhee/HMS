@extends('admin.layouts.app')
@section('panel')
<div class="mb-none-30">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.doctor.schedule.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label class="form-control-label font-weight-bold">@lang('Doctor')<span class="text--danger">*</span></label>
                            <select class="select2-basic form-control" name="doctor" required>
                                <option value="" disabled selected>@lang('Select One')</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"> {{ __($doctor->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label  font-weight-bold">@lang('Assistant') <span
                                    class="text--danger">*</span></label>
                            <select class="select2-basic form-control" name="assistant" required>
                                <option value="" disabled selected>@lang('Select One')</option>
                                @foreach ($assistants as $assistant)
                                    <option value="{{ $assistant->id }}">{{__($assistant->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label class="form-control-label font-weight-bold">@lang('Available Date')<span class="text--danger">*</span></label>
                            <input name="available_date" type="text" data-language="en" class="datepicker-here form-control" data-position='bottom left' autocomplete="off"
                                    value="{{ old('available_date') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label  font-weight-bold">@lang('Available Slot') <span
                                    class="text--danger">*</span></label>
                            <select class="select2-basic form-control" name="slot" required>
                                <option value="" disabled selected>@lang('Select One')</option>
                                @foreach ($slots as $slot)
                                    <option value="{{ $slot->id }}"> {{ __($slot->from_time . ' - ' . $slot->to_time) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-control-label  font-weight-bold">@lang('Per Patient Time')<span class="text--danger">*</span></label>
                        <div class="input-group has_append">
                            <input type="number" class="form-control" name="per_patient_time" value="{{ old('per_patient_time') }}" required>
                            <div class="input-group-append">
                                <button class="btn btn--primary" type="button"><i class="fa fa-clock"></i> @lang('Mins')</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label class="form-control-label font-weight-bold">@lang('Serial Limit')<span class="text--danger">*</span></label>
                            <input type="number" class="form-control" name="serial_limit" value="{{ old('serial_limit') }}" required>
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

@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.doctor.schedule.index') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Schedules')
    </a>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            // clock picker
            $('.clockpicker').clockpicker({
                placement: 'bottom',
                align: 'left',
                donetext: 'Done'
            });
            //Datepicker
            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }
            //old value selected//
            var available_slot = '{{ old('slot') }}';
            var date = '{{ old('available_date') }}';
            var doctor = '{{ old('doctor') }}';
            var assistant = '{{ old('assistant') }}';
            $('select[name=slot]').val(available_slot).select2();
            $('select[name=available_date]').val(date).select2();
            $('select[name=doctor]').val(doctor).select2();
            $('select[name=assistant]').val(assistant).select2();
        })(jQuery)
    </script>
@endpush
