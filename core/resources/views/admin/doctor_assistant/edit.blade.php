@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.doctor.assistant.update', $assistant->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <div class="row">
                                    <div class="col-12 form-group mb-2">
                                        <label class="form-control-label font-weight-bold">@lang('Full Name')<span class="text--danger">*</span></label>
                                        <input type="text" name="name" value="{{ __($assistant->name) }}" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group mb-2">
                                        <label class="form-control-label font-weight-bold">@lang('E-Mail')<span class="text--danger">*</span></label>
                                        <input type="text" name="email" value="{{ $assistant->email }}" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-control-label font-weight-bold">@lang('Mobile Number')<span class="text--danger">*</span></label>
                                        <input type="number" name="mobile" value="{{ $assistant->mobile }}" class="form-control" />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-control-label font-weight-bold">@lang('Blood Group')<span class="text--danger">*</span></label>
                                        <select class="select2-basic form-control" name="blood_group">
                                                @foreach (bloodGroups() as $key => $value)
                                                    <option value="{{ $value }}" {{ $value == $assistant->blood_group ? 'selected' : '' }}>
                                                        {{ __($key) }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-control-label font-weight-bold">@lang('Date Of Birth')</label>
                                        <input name="date" type="text" data-language="en" class="datepicker-here form-control" data-position='bottom left'  autocomplete="off"
                                        value="{{ $assistant->date_of_birth }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-control-label font-weight-bold">@lang('Address')</label>
                                         <textarea name="address" class="form-control">{{ __($assistant->address) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-control-label font-weight-bold">@lang('Image')</label>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview"
                                                style="background-image: url({{ getImage(imagePath()['profile']['doctor_assistant']['path'] . '/' . $assistant->image,imagePath()['profile']['doctor_assistant']['size']) }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit mt-0">
                                            <input type="file" class="profilePicUpload" name="image"
                                                id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload1" class="btn btn--success btn-block btn-lg">@lang('Upload')</label>
                                            <small class="text-facebook">@lang('Supported images'):
                                                <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 400x400px') </small>
                                        </div>
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
    <a href="{{ route('admin.doctor.assistant.index') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Assistants')
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
        })(jQuery)
    </script>
@endpush
