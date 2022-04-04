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
                                    <th >@lang('Doctor Name')</th>
                                    <th >@lang('Doctor Assistant')</th>
                                    <th >@lang('Available Date')</th>
                                    <th >@lang('Slot')</th>
                                    <th >@lang('Per Patient Time')</th>
                                    <th >@lang('Serial Limit')</th>
                                    <th >@lang('Status')</th>
                                    <th >@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td data-label="@lang('S.N.')"> {{$loop->iteration}}</td>
                                        <td data-label="@lang('Doctor Name')">{{ __($schedule->doctor->name) }}</td>
                                        <td data-label="@lang('Doctor Assistant')">{{ __(@$schedule->assistant->name) }}</td>
                                        <td data-label="@lang('Available Date')">{{ showDateTime($schedule->available_date,'Y-m-d')}}</td>
                                        <td data-label="@lang('Slot')">{{$schedule->slot->from_time. ' - ' . $schedule->slot->to_time }}</td>
                                        <td data-label="@lang('Per Patient Time')">{{ __(@$schedule->per_patient_time ) }}</td>
                                        <td data-label="@lang('Serial Limit')">{{ __($schedule->serial_limit ) }}</td>
                                        <td data-label="@lang('Status')">
                                            @if (@$schedule->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Deactivate')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{route('admin.doctor.schedule.edit', $schedule->id)}}" class="icon-btn text--small"><i class="las la-edit text--shadow"></i></a>
                                            <button class="icon-btn text--small btn--danger deleteBtn" data-id="{{ $schedule->id }}"><i class="las la-trash text--shadow"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                            @if ($schedules->hasPages())
                                {{ paginateLinks($schedules) }}
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--delete Modal -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                {{-- <div class="modal-body"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Delete Confirmation')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.doctor.schedule.delete') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id">
                            <b class="mb-2">@lang('Are you sure to delete the schedule?')</b>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                        </div>
                    </form>
                {{-- </div> --}}
            </div>
        </div>
    </div>

    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{route('admin.doctor.schedule.create')}}" class="btn btn-lg btn--primary text--small mr-3">
        <i class="fa fa-fw fa-plus"></i>@lang('Add Schedule')
    </a>
@endpush
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white mb-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Doctor /Day /Time')"
                value="{{ request()->search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
@push('script')
    <script>
        (function($) {
            $('.deleteBtn').on('click', function() {
                var modal = $('#deleteModal');
                modal.find('[name=id]').val($(this).data("id"));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush


{{-- 'serial_limit'  => 'nullable|integer|numeric|gt:0', --}}


