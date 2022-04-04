@extends('admin.layouts.app')
@section('panel')

{{-- @dump($schedule) --}}

    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.doctor.schedule.update', $schedule->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Doctor')<span class="text--danger">*</span></label>
                                    <select class="select2-basic form-control" name="doctor" required>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{$doctor->id == $schedule->doctor->id ?'selected': ''}}> {{ __($doctor->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Assistant') <span
                                            class="text--danger">*</span></label>
                                    <select class="select2-basic form-control" name="assistant" required>
                                        @foreach ($assistants as $assistant)
                                            <option value="{{ $assistant->id }}" {{$assistant->id == $schedule->assistant_id ?'selected':''}} >{{__($assistant->name)}}</option>
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
                                            value="{{ showDateTime($schedule->available_date,'Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Available Slot') <span
                                            class="text--danger">*</span></label>
                                    <select class="select2-basic form-control" name="slot" required>
                                        @foreach ($slots as $slot)
                                            <option value="{{ $slot->id }}" {{$schedule->slot_id == $slot->id ?'selected':''}} > {{ __($slot->from_time . ' - ' . $slot->to_time) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-control-label  font-weight-bold">@lang('Per Patient Time')<span class="text--danger">*</span></label>
                                <div class="input-group has_append">
                                    <input type="number" class="form-control" name="per_patient_time" value="{{ $schedule->per_patient_time }}" required>
                                    <div class="input-group-append">
                                        <button class="btn btn--primary" type="button"><i class="fa fa-clock"></i> @lang('Mins')</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Serial Limit')<span class="text--danger">*</span></label>
                                    <input type="number" class="form-control" name="serial_limit" value="{{ $schedule->serial_limit }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-12 mt-2 ">
                                    <label>@lang('Status') <span class="text-danger">*</span></label>
                                    <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-height="40" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactivate')" data-width="100%" name="status">
                                </div>


                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
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
                placement: 'top',
                align: 'left',
                donetext: 'Done'
            });
            //Datepicker
            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }
            //status
            if ('{{ $schedule->status }}' == 1) {
                   $('[name=status]').bootstrapToggle('on');
                } else {
                    $('[name=status]').bootstrapToggle('off');
                }
        })(jQuery)
    </script>
@endpush
