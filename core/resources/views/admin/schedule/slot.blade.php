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
                                    <th scope="col">@lang('S.N.')</th>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Time Slot')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($slots as $slot)
                                    <tr>
                                        <td data-label="@lang('S.N.')"> {{ $loop->iteration }} </td>
                                        <td data-label="@lang('Name')">{{ __(@$slot->name) }}</td>
                                        <td data-label="@lang('Time Slot')">
                                            {{ $slot->from_time . ' - ' . $slot->to_time }}</td>
                                        <td data-label="@lang('Status')">
                                            @if (@$slot->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Deactivate')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button class="icon-btn text--small editBtn"
                                                data-resource="{{ $slot }}"><i
                                                    class="las la-edit text--shadow"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($slots->hasPages())
                            {{ paginateLinks($slots) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Add Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Add Time Slot')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </button>
                </div>
                <form action="{{ route('admin.schedule.slot.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Name') <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required />
                        </div>
                        <div class="row">
                            <div class="col-6 form-group mb-2 clockpicker">
                                <label>@lang('From Time') <span class="text-danger">*</span></label>
                                <input  type="text" name="from_time" class="form-control" value="{{old('from_time')}}" autocomplete="off" required>
                            </div>
                            <div class="col-6 form-group mb-2 clockpicker">
                                <label>@lang('To Time') <span class="text-danger">*</span></label>
                                <input  type="text" name="to_time" class="form-control" value="{{old('to_time')}}" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Update Modal -->
    <div class="modal fade" id="updateModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Edit Time  Slot')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </button>
                </div>
                <form  method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" required/>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group mb-2 clockpicker">
                                <label>@lang('From Time') <span class="text-danger">*</span></label>
                                <input  type="text" name="from_time"  class="form-control" required>
                            </div>
                            <div class="col-6 form-group mb-2 clockpicker">
                                <label>@lang('To Time') <span class="text-danger">*</span></label>
                                <input  type="text" name="to_time" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Status')</label>
                            <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-height="40"
                                data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactivate')"
                                data-width="100%" name="status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    @endsection

    @push('breadcrumb-plugins')
        <button class="btn btn-lg btn--primary text--small mr-3" data-toggle="modal" data-target="#addModal">
            <i class="fa fa-fw fa-plus"></i>@lang('Add Slot')
        </button>
    @endpush
    @push('breadcrumb-plugins')
        <form method="GET" class="form-inline float-sm-right bg--white mb-2">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Name / Time')"
                    value="{{ request()->search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endpush
    @push('script-lib')
        <script src="{{ asset('assets/admin/js/vendor/bootstrap-clockpicker.min.js') }}"></script>
    @endpush
    @push('style')
<style>
    
</style>
    @endpush

    @push('script')
        <script>
            (function($) {
                "use strict";
                // clock picker
                $('.clockpicker').clockpicker({
                    placement: 'top',
                    align: 'right',
                    donetext: 'Done'
                });
                //Edit
                $('.editBtn').on('click', function() {
                    var modal = $('#updateModal');
                    var resource = $(this).data('resource');
                    modal.find('[name=name]').val(resource.name);
                    modal.find('[name=from_time]').val(resource.from_time);
                    modal.find('[name=to_time]').val(resource.to_time);
                        if (resource.status == 1) {
                            modal.find('[name=status]').bootstrapToggle('on');
                        } else {
                            modal.find('[name=status]').bootstrapToggle('off');
                        }
                    modal.find('form').attr('action', `{{ route('admin.schedule.slot.update', '') }}/${resource.id}`);
                     modal.modal('show');
                });

            })(jQuery);
        </script>
    @endpush

