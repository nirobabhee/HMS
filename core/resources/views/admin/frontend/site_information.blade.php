@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.frontend.sections.content', 'site')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="data">
                        <div class="form-group ">
                            <label class="orm-control-label font-weight-bold">@lang('Site Title')</label>
                            <input type="text" class="form-control" name="site_title" placeholder="Site Title" value="{{ @$site->data_values->site_title }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label  font-weight-bold">@lang('Site Slogan')</label>
                            <textarea name="site_slogan" rows="2" class="form-control" placeholder="@lang('Site Slogan')" required>{{ @$site->data_values->site_slogan }}</textarea>
                        </div>
                        <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="form-control-label  font-weight-bold">@lang('Country')</label>
                            <input type="text" class="form-control" placeholder="@lang('Site Country')" name="country" value="{{ @$site->data_values->country }}" required/>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-control-label  font-weight-bold">@lang('City')</label>
                            <input type="text" class="form-control" placeholder="@lang('Site City')" name="city" value="{{ @$site->data_values->city }}" required/>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="form-control-label  font-weight-bold">@lang('State')</label>
                            <input type="text" class="form-control" placeholder="@lang('Site State')" name="state" value="{{ @$site->data_values->state }}" required/>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-control-label  font-weight-bold">@lang('Zip')</label>
                            <input type="text" class="form-control" placeholder="@lang('Site Zip')" name="zip" value="{{ @$site->data_values->zip }}" required/>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label  font-weight-bold">@lang('Description')</label>
                            <textarea name="description" rows="2" class="form-control" placeholder="@lang('Social Share  meta description')" required>{{ @$site->data_values->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
