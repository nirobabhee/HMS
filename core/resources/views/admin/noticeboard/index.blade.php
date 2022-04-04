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
                                    <th scope="col">@lang('Title')</th>
                                    <th scope="col">@lang('Description')</th>
                                    <th scope="col">@lang('Start Date')</th>
                                    <th scope="col">@lang('End Date')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($noticeboards as $noticeboard)
                                    <tr>
                                        <td data-label="@lang('S.N.')"> {{$loop->iteration}} </td>
                                        <td data-label="@lang('Title')">{{ __(shortDescription($noticeboard->title, 80)) }}</td>
                                        <td data-label="@lang('Description')">{{ __(shortDescription(@$noticeboard->description, 70)) }}</td>
                                        <td data-label="@lang('Start Date')">{{ showDateTime($noticeboard->start_date,'Y-m-d') }}</td>
                                        <td data-label="@lang('End Date')">{{ showDateTime($noticeboard->end_date, 'Y-m-d') }}</td>
                                        <td data-label="@lang('Status')">
                                            @if (@$noticeboard->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Deactivate')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button class="icon-btn text--small editBtn" data-resource="{{ $noticeboard }}"><i class="las la-edit text--shadow"></i></button>
                                            <button class="icon-btn text--small btn--danger deleteBtn" data-toggle="modal" data-target="#deleteModal" data-id="{{ $noticeboard->id }}"><i class="las la-trash text--shadow"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                            @if ($noticeboards->hasPages())
                                {{ paginateLinks($noticeboards) }}
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Delete Modal -->
   <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Notice Delete Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.noticeboard.delete') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to delete the notice')?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--danger">@lang('Delete')</button>
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
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Edit Noticeboard')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Title')<span class="text--danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>@lang('Description') <span class="text--danger">*</span></label>
                            <textarea name="description" class="form-control" required >{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('Start Date') <span class="text--danger">*</span></label>
                            <input name="start_date" type="text" data-language="en"
                                    class="datepicker-here form-control" data-position='bottom right' autocomplete="off"
                                    value="{{ old('start_date') }}" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('End Date') <span class="text--danger">*</span></label>
                            <input name="end_date" type="text" data-language="en"
                                    class="datepicker-here form-control" data-position='bottom left' autocomplete="off"
                                    value="{{ old('end_date') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Status')</label>
                            <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-height="40" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactivate')" data-width="100%" name="status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
@endsection


@push('breadcrumb-plugins')
<a class="btn btn-lg btn--primary text--small mr-3 mb-2" href="{{route('admin.noticeboard.create')}}"> <i class="fa fa-fw fa-plus"></i>@lang('Add Noticeboard')</a>
@endpush
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white mb-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Title/Date')"
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
@push('style')
<style>
   .datepickers-container{
        z-index: 9999;
    }
</style>
@endpush
@push('script')
    <script>
        (function($) {
            'use strict';
            $('.editBtn').on('click', function() {
                var modal = $('#updateModal');
                var resource = $(this).data('resource');
                modal.find('[name=title]').val(resource.title);
                modal.find('[name=description]').val(resource.description);
                modal.find('[name=start_date]').val(resource.start_date);
                modal.find('[name=end_date]').val(resource.end_date);

                if (resource.status == 1) {
                    modal.find('[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('[name=status]').bootstrapToggle('off');
                }
                modal.find('form').attr('action', `{{ route('admin.noticeboard.update', '') }}/${resource.id}`);
                modal.modal('show');
            });
             //Delete
             $('.deleteBtn').on('click', function () {
                 var modal = $('#deleteModal');
                 console.log(modal);
                modal.find('.appointment-no').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });


           //Datepicker
           if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }
        })(jQuery);
    </script>
@endpush


