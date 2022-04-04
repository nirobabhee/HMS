@extends('admin.layouts.app')
@section('panel')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.user.document.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                    <div class="col-sm-12 form-group">
                                        <label> @lang('Patient ID/Username') <span class="text-danger">*</span></label>
                                        <select class="select2-basic form-control" name="user_id" required>
                                            <option value="" disabled selected> @lang('Select Patient')</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ __($user->username) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12  form-group">
                                        <label> @lang('Doctor Name')</label>
                                        <select class="select2-basic form-control" name="doctor_id" required>
                                            <option value="" disabled selected> @lang('Select Doctor')</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">
                                                    {{ __($doctor->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="inputAttachments">@lang('Attachments')</label>
                                                <div class="row form-group">
                                                    <div class="col-sm-11">
                                                        <div class="file-upload-wrapper" data-text="@lang('Select your file')">
                                                            <input type="file" name="attachments[]" id="inputAttachments"
                                                            class="file-upload-field" required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn--dark extraAttachments"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div class="col-sm-12">
                                                    <div id="fileUploadsContainer"></div>
                                                    </div>
                                                    <div class="col-sm-12 text-muted">
                                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label>@lang('Description') </label>
                                <textarea name="description" class="form-control border-radius-5 nicEdit">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.user.documents') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Patients Document')
    </a>
@endpush


@push('script')
    <script>
        (function($) {
            'use strict';

            //Append
            $('.extraAttachments').on('click',function(){

                $("#fileUploadsContainer").append(`
                <div class="row form-group">
                    <div class="col-11">
                        <div class="file-upload-wrapper" data-text="@lang('Select your file')">
                            <input type="file" name="attachments[]" id="inputAttachments"   class="file-upload-field" required/>
                        </div>
                    </div>
                    <div class="col-1"> <button type="button" class="btn btn--danger extraAttachments remove-btn"><i class="fa fa-times"></i></button> </div>
                </div>`)
            });

            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.form-group').remove();
            });

            var patient =  '{{ old('patient_id')}}';
            var doctor =  '{{ old('doctor_id')}}';
            $('select[name=patient_id]').val(patient).select2();
            $('select[name=doctor_id]').val(doctor).select2();
        })(jQuery)
    </script>
@endpush
