@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.patient.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <div class="row">
                                    <div class="col-12 form-group mb-2">
                                        <label>@lang('Name') <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group mb-2">
                                        <label>@lang('Username') <span class="text-danger">*</span></label>
                                        <input type="text" name="username" value="{{ old('username') }}" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group mb-2">
                                        <label>@lang('E-mail')<span class="text-danger">*</span></label>
                                        <input type="text" name="email" value="{{ old('email') }}" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group mb-2">
                                        <label>@lang('Password') <span class="text-danger">*</span></label>
                                        <input type="password" name="password" value="" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Mobile') <span class="text-danger">*</span></label>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label> @lang('Gender')</label>
                                        <select class="select2-basic form-control" name="gender">
                                            <option value="1">@lang('Male')</option>
                                            <option value="2">@lang('Female') </option>
                                            <option value="0"> @lang('Others')</option>
                                        </select>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label> @lang('Blood Group')</label>
                                        <select class="select2-basic form-control" name="blood_group">
                                            @foreach (bloodGroups() as $key => $value)
                                                <option value="{{ $value }}">
                                                    {{ __($key) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label> @lang('Date Of Birth')</label>
                                        <input name="date" type="text" data-language="en" class="datepicker-here form-control" data-position='top left'
                                            autocomplete="off" value="{{ old('date') }}">
                                    </div>
                                    <div class="col-12">
                                        <label> @lang('Age')<span class="text-danger">*</span></label>
                                        <input type="number" name="age" value="{{ old('age') }}" class="form-control" required />
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-12">
                                        <label> @lang('Weight')<span class="text-danger">*</span></label>
                                        <input type="number" name="weight" value="{{ old('weight') }}" class="form-control" required />
                                    </div>
                                    <div class="col-12">
                                        <label>@lang('Image')</label>
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url({{ getImage('', imagePath()['profile']['patient']['size']) }})">
                                                        <button type="button" class="remove-image">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <label for="profilePicUpload1" class="btn btn--success btn-block btn-lg">@lang('Upload')</label>
                                                    <small class="text-facebook">@lang('Supported images'):
                                                        <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 400x400px') </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label>@lang('Address') </label>
                                        <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label> @lang('Reference')</label>
                                        <input type="reference" name="reference" value="{{ old('reference') }}" class="form-control" />
                                    </div>
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
    <a href="{{ route('admin.patient.index') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Patients')
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
