@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.doctor.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <div class="row">
                                    <div class="col-12 form-group mb-2">
                                        <label>@lang('Name') <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                            required />
                                    </div>
                                    <div class="col-12 form-group mb-2">
                                        <label>@lang('Username') <span class="text-danger">*</span></label>
                                        <input type="text" name="username" value="{{ old('username') }}"
                                            class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group mb-2">
                                        <label>@lang('E-mail')<span class="text-danger">*</span></label>
                                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                            required />
                                    </div>
                                    <div class="col-12 form-group mb-2">
                                        <label>@lang('Password') <span class="text-danger">*</span></label>
                                        <input type="password" name="password" value="" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group mb-2">
                                        <label> @lang('Department') <span class="text-danger">*</span></label>
                                        <select class="select2-basic form-control" name="department" required>
                                            <option value="" disabled selected>@lang('Select Department')</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ __($department->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Designation')<span class="text-danger">*</span></label>
                                        <input type="text" name="designation" value="{{ old('designation') }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Fee')<span class="text-danger">*</span></label>
                                        <input type="text" name="fee" value="{{ old('fee') }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label> @lang('Gender')</label>
                                        <select class="select2-basic form-control" name="gender">
                                            <option disabled selected> @lang('Select Gender')</option>
                                            <option value="1">@lang('Male')</option>
                                            <option value="2">@lang('Female') </option>
                                            <option value="0"> @lang('Others')</option>
                                        </select>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Mobile') <span class="text-danger">*</span></label>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}"
                                            class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>@lang('Phone') </label>
                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label> @lang('Blood Group')</label>
                                        <select class="select2-basic form-control" name="blood_group">
                                        <option disabled selected> @lang('Select Blood Group')</option>
                                            @foreach (bloodGroups() as $key => $value)
                                                <option value="{{ $value }}">
                                                    {{ __($key) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label> @lang('Date Of Birth')</label>
                                        <input name="date" type="text" data-language="en"
                                            class="datepicker-here form-control" data-position='bottom left'
                                            autocomplete="off" value="{{ old('date') }}">
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <label>@lang('Image')</label>
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url({{ getImage('', imagePath()['profile']['doctor']['size']) }})">
                                                        <button type="button" class="remove-image"><i
                                                                class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit mt-0">
                                                    <input type="file" class="profilePicUpload" name="image"
                                                        id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <label for="profilePicUpload1"
                                                        class="btn btn--success btn-block btn-lg">@lang('Upload')</label>
                                                    <small class="text-facebook">@lang('Supported images'):
                                                        <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized
                                                        into 400x400px') </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label>@lang('Address') </label>
                                        <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label>@lang('Google Plus Link') </label>
                                        <input type="url" name="google_plus" value="{{ old('google_plus') }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label>@lang('Linkedin Link') </label>
                                        <input type="url" name="linkedin" value="{{ old('linkedin') }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label>@lang('Youtube Channel Link') </label>
                                        <input type="url" name="youtube" value="{{ old('youtube') }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label>@lang('Facebook Profile Link') </label>
                                        <input type="url" name="facebook" value="{{ old('facebook') }}"
                                            class="form-control" />

                                    </div>
                                    <div class="col-12 mt-3">
                                        <label>@lang('Twitter Link') </label>
                                        <input type="url" name="twitter" value="{{ old('twitter') }}"
                                            class="form-control" />
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
    <a href="{{ route('admin.doctor.index') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Doctors')
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
