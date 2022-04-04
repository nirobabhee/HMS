@extends('admin.layouts.app')

@section('panel')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.noticeboard.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Title') <span class="text--danger">*</span></label>
                                <input type="text" class="form-control" name="title" value="{{old('title')}}" required/>
                            </div>
                                <div class="form-group col-sm-6">
                                    <label class="font-weight-bold">@lang('Start Date') <span class="text--danger">*</span></label>
                                    <input name="start_date" type="text" data-language="en" class="datepicker-here form-control" data-position='bottom left' autocomplete="off"
                                    value="{{ old('start_date') }}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="font-weight-bold">@lang('End date') <span class="text--danger">*</span></label>
                                    <input name="end_date" type="text" data-language="en" class="datepicker-here form-control" data-position='bottom left' autocomplete="off"
                                    value="{{ old('end_date') }}" required>
                                </div>
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Description') <span class="text--danger">*</span></label>
                                <textarea name="description" rows="5" class="form-control nicEdit">{{old('description')}}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Submit')</button>
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>

@endsection
@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            'use strict';
           //Datepicker
           if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }
        })(jQuery);
    </script>
@endpush


