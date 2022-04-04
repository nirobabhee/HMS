@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th >@lang('S.N.')</th>
                                    <th >@lang('Image')</th>
                                    <th >@lang('Name')</th>
                                    <th >@lang('Department')</th>
                                    <th >@lang('Designation')</th>
                                    <th >@lang('Mobile')</th>
                                    <th >@lang('Status')</th>
                                    <th >@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($doctors as $doctor)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Image')">
                                            <a href="{{route('admin.doctor.details',[$doctor->id, slug($doctor->username)])}}">
                                            <img height="40" width="40"
                                                src="{{ getImage(imagePath()['profile']['doctor']['path'] . '/' . $doctor->image,imagePath()['profile']['doctor']['size']) }}"
                                                alt="Doctor">
                                            </a>
                                        </td>
                                        <td data-label="@lang('Name')">
                                            <a href="{{route('admin.doctor.details',[$doctor->id, slug($doctor->username)])}}">
                                                {{ __(@$doctor->name) }}
                                            </a>
                                        </td>
                                        <td data-label="@lang('Department')">
                                            {{ __(@$doctor->department->name) }} </td>
                                        <td data-label="@lang('Designation')">
                                            {{ __(@$doctor->designation) }}</td>
                                        <td data-label="@lang('Mobile')">{{ __(@$doctor->mobile) }} </td>
                                        <td data-label="@lang('Status')">
                                            @if (@$doctor->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Deactivate')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a class="icon-btn" href="{{ route('admin.doctor.edit',$doctor->id)}}">
                                                <i class="las la-edit text--shadow"></i>
                                            </a>
                                            @if($doctor->status == 0)
                                            <button type="button"
                                                    class="icon-btn btn--success ml-1 activateBtn"
                                                    data-toggle="modal" data-target="#activateModal"
                                                    data-id="{{ $doctor->id }}"
                                                    data-name="{{ __($doctor->name) }}"
                                                    data-original-title="@lang('Enable')">
                                                <i class="la la-eye"></i>
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="icon-btn btn--danger ml-1 deactivateBtn"
                                                    data-toggle="modal" data-target="#deactivateModal"
                                                    data-id="{{ $doctor->id }}"
                                                    data-name="{{$doctor->name }}"
                                                    data-original-title="@lang('Disable')">
                                                <i class="la la-eye-slash"></i>
                                            </button>
                                        @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($doctors->hasPages())
                            {{ paginateLinks($doctors) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Doctor Activation Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.doctor.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span class="font-weight-bold doctor-name"></span> @lang('doctor')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Activate')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Doctor Deactivate Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.doctor.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span class="font-weight-bold doctor-name"></span> @lang('doctor')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Deactivate')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection


@push('breadcrumb-plugins')

    <a href="{{route('admin.doctor.create')}}">
        <button class="btn btn-lg btn--primary text--small mr-3 mb-2">
            <i class="fa fa-fw fa-plus"></i>@lang('Add Doctor')
        </button>
    </a>
@endpush
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Department name')"
                value="{{ request()->search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush


@push('script-lib')
<script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
<script>
    (function($){
        'use strict';
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
</script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.doctor-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.doctor-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

        })(jQuery);
    </script>
@endpush
