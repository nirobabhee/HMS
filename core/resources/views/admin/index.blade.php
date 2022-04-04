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
                                    <th >@lang('Name')</th>
                                    <th >@lang('Username')</th>
                                    <th >@lang('Password')</th>
                                    <th >@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $admin)
                                    <tr>
                                        <td data-label="@lang('Name')">{{ @$admin->name }}</td>
                                        <td data-label="@lang('Name')">{{ @$admin->username }}</td>
                                        <td data-label="@lang('Name')">{{ @$admin->password }}</td>
                                        <td data-label="@lang('Action')">
                                            <button class="icon-btn text--small editBtn" data-resource="{{ $admin }}">
                                                <i  class="las la-edit text--shadow"></i>
                                            </button>
                                            <button class="icon-btn text--small deleteBtn btn--danger" data-id="{{ $admin->id }}">
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
                        @if ($admins->hasPages())
                            {{ paginateLinks($admins) }}
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
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Add New Admin')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </button>
                </div>
                <form action="{{ route('admin.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>@lang('Username') <span class="text-danger">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control"
                                required />
                        </div>
                        <div class="form-group">
                            <label>@lang('Password') <span class="text-danger">*</span></label>
                            <input type="text" name="password" value="{{ old('password') }}" class="form-control"
                                required />
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
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Edit Admin')</h5>
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
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>@lang('Username')</label>
                            <input type="text" name="username" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>@lang('Password')</label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--Delete Modal -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Delete Confirmation')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('admin.delete')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id">
                            <p>@lang('Are you sure to delete the admin ?')</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn--primary text--small" data-toggle="modal" data-target="#addModal">
        <i class="fa fa-fw fa-plus"></i>@lang('Add Admin')
    </button>
@endpush
@push('script')
    <script>
        (function($) {
            $('.editBtn').on('click', function() {
                var modal = $('#updateModal');
                var resource = $(this).data('resource');
                modal.find('[name=name]').val(resource.name);
                modal.find('[name=username]').val(resource.username);
                modal.find('form').attr('action', `{{ route('admin.update', '') }}/${resource.id}`);
                modal.modal('show');
            });
            $('.deleteBtn').on('click', function() {
                var modal = $('#deleteModal');
                modal.find('[name=id]').val($(this).data("id"));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
