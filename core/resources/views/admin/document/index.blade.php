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
                                    <th >@lang('Patient ID / Username')</th>
                                    <th >@lang('Doctor Name')</th>
                                    <th >@lang('Date')</th>
                                    <th >@lang('Uploaded By')</th>
                                    <th >@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                    <tr>
                                        <td data-level="S.N.">{{ $loop->iteration }}</td>
                                        <td data-level="Patient ID">{{ __(@$document->user->username) }}</td>
                                        <td data-label="@lang('Doctor Name')">{{ __(@$document->doctor->name) }}</td>
                                        <td data-label="@lang('Date')">{{ showDateTime(@$document->created_at, 'Y-m-d') }} </td>
                                        <td data-label="@lang('Upload By')">{{ __($document->admin->name) }} </td>
                                        <td data-label="@lang('Action')">
                                            <a class="icon-btn" href="{{ route('admin.user.document.attachments', @$document->id) }}">
                                                <i class="las la-paperclip text--shadow"></i>
                                            </a>
                                            </button>
                                            <button class="icon-btn viewBtn ml-1"
                                            data-name="{{$document->user->fullname }}"
                                                data-description="{{$document->description }}">
                                                <i class="las la-stream text--shadow"></i>
                                            </button>
                                            <button class="icon-btn deleteBtn ml-1 btn--danger"
                                                data-id="{{ $document->id }}"
                                                data-name="{{$document->user->fullname }}">
                                                <i class="las la-trash text--shadow"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($documents->hasPages())
                            {{ paginateLinks($documents) }}
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
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Delete Confirmation')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.user.document.delete') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id">
                            <p>@lang('Are you sure to delete') <span class="font-weight-bold user-name"></span> @lang("'s document")?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
    <!--view Modal -->
    <div class="modal fade" id="viewModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Description of ')<span class="name font-weight-bold"></span>@lang(' Documents')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body">
                            <input type="hidden" name="id">
                            <p class="description"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancel')</button>
                        </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')

    <a href="{{route('admin.user.document.create')}}">
        <button class="btn btn-lg btn--primary text--small  mr-3 mb-2">
            <i class="fa fa-fw fa-plus"></i>@lang('Add Patient Documents')
        </button>
    </a>
@endpush
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Patient ID / Doctor')"
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
                modal.find('.user-name').text($(this).data('name'));
                modal.find('[name=id]').val($(this).data("id"));
                modal.modal('show');
            });
            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');
                console.log($(this).data('description'));
                modal.find('.name').text($(this).data('name'));
                modal.find('.description').text($(this).data('description'));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
