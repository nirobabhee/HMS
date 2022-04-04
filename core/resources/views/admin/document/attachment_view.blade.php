@extends('admin.layouts.app')
@section('panel')
            <div class="card">
                <div class="card-body">
                        <div class="my-3 d-flex justify-content-center">
                            @forelse($attachments as $image)
                                    <a href="{{route('admin.attachment.download',$image->id)}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{$loop->index + 1}} </a>
                                @empty
                                <div class="text-muted d-flex justify-content-center">
                                    {{ __($emptyMessage) }}
                                </div>
                            @endforelse
                        </div>
                </div>
            </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.user.documents') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="fa fa-fw fa-plus"></i>@lang('Patient Documents List')
    </a>
@endpush

