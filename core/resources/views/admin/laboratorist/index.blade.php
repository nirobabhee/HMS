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
                                    <th >@lang('E-mail')</th>
                                    <th >@lang('Mobile')</th>
                                    <th >@lang('Blood Group')</th>
                                    <th >@lang('Status')</th>
                                    <th >@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laboratorists as $laboratorist)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Image')">
                                            <img height="40" width="40"
                                                src="{{ getImage(imagePath()['profile']['laboratorist']['path'] . '/' . $laboratorist->image,imagePath()['profile']['laboratorist']['size']) }}"
                                                alt="Laboratorist">
                                        </td>
                                        <td data-label="@lang('Name')">
                                                {{ __(@$laboratorist->name) }}
                                        </td>
                                        <td data-label="@lang('Mobile')">{{ @$laboratorist->email }} </td>
                                        <td data-label="@lang('Mobile')">{{ @$laboratorist->mobile }} </td>
                                        <td data-label="@lang('Blood Group')">{{ __(@$laboratorist->blood_group) }} </td>
                                        <td data-label="@lang('Status')">
                                            @if (@$laboratorist->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Deactivate')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a class="icon-btn" href="{{ route('admin.laboratorist.edit',$laboratorist->id)}}">
                                                <i class="las la-edit text--shadow"></i>
                                            </a>
                                                @if($laboratorist->status == 0)
                                                <button type="button"
                                                        class="icon-btn btn--success ml-1 activateBtn"
                                                        data-toggle="modal" data-target="#activateModal"
                                                        data-id="{{ $laboratorist->id }}"
                                                        data-name="{{ __($laboratorist->name) }}"
                                                        data-original-title="@lang('Enable')">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="icon-btn btn--danger ml-1 deactivateBtn"
                                                        data-toggle="modal" data-target="#deactivateModal"
                                                        data-id="{{ $laboratorist->id }}"
                                                        data-name="{{ __($laboratorist->name) }}"
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
                        @if ($laboratorists->hasPages())
                            {{ paginateLinks($laboratorists) }}
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
                <h5 class="modal-title">@lang('Nurse Activation Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.laboratorist.activate') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to activate') <span class="font-weight-bold laboratorist-name"></span> @lang('laboratorist')?</p>
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
                <h5 class="modal-title">@lang('Nurse Deactivate Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.laboratorist.deactivate') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to disable') <span class="font-weight-bold laboratorist-name"></span> @lang('laboratorist')?</p>
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
    <a href="{{route('admin.laboratorist.create')}}">
        <button class="btn btn-lg btn--primary text--small mr-3 mb-2">
            <i class="fa fa-fw fa-plus"></i>@lang('Add Laboratorist')
        </button>
    </a>
@endpush
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Name/Email/Number')"
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
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.laboratorist-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.laboratorist-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });
        })(jQuery);
    </script>
@endpush
