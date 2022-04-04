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
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Patient ID')</th>
                                    <th>@lang('Appointment No')</th>
                                    <th>@lang('Patient Type')</th>
                                    <th>@lang('Visiting Fee')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prescriptions as $prescription)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Patient ID')">
                                            <a href="{{route('admin.users.detail', $prescription->user_id)}}">
                                                {{ __(@$prescription->user->username) }}
                                            </a>
                                        </td>
                                        <td data-label="@lang('Appointment No')">{{ @$prescription->appointment_no}}</td>
                                        <td data-label="@lang('Patient Type')">
                                            @if (@$prescription->type == 1)
                                                <span class="badge badge--primary">@lang('New')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('Old')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Visiting Fee')">{{ __(@$prescription->visiting_fee) }}</td>
                                        <td data-label="@lang('date')">{{ showDateTime($prescription->created_at,'Y-m-d') }} </td>

                                        <td data-label="@lang('Action')">
                                            <a href="{{route('admin.prescription.view',[$prescription->id,$prescription->appointment_no])}}" class="icon-btn">
                                                <i class="las la-eye text--shadow"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($prescriptions->hasPages())
                            {{ paginateLinks($prescriptions) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.prescription.create') }}">
        <button class="btn btn-lg btn--primary text--small mr-3 mb-2">
            <i class="fa fa-fw fa-plus"></i>@lang('Add Prescription')
        </button>
    </a>
@endpush
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Patient ID/ Appointment No/ Date / Type')"
                value="{{ request()->search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
