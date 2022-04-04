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
                                    <th>@lang('Patient Name')</th>
                                    <th>@lang('Heart Disease')</th>
                                    <th>@lang('High Blood Pressure')</th>
                                    <th>@lang('Currrent Medication')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($caseStudies as $caseStudy)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Patient ID')">
                                            <a href="{{route('admin.users.detail', $caseStudy->user->id)}}">
                                                {{ __(@$caseStudy->user->username) }}
                                            </a>
                                        </td>
                                        <td data-label="@lang('Patient Name')">
                                            <a href="{{route('admin.users.detail', $caseStudy->user->id)}}">
                                                {{ __(@$caseStudy->user->fullname) }}
                                            </a>
                                         </td>
                                        <td data-label="@lang('Heart Disease')">{{ __(shortDescription(@$caseStudy->case_studies->heart_disease, 30)) }} </td>
                                        <td data-label="@lang('High Blood Pressure')">{{ __(shortDescription(@$caseStudy->case_studies->high_blood_pressure, 30)) }} </td>
                                        <td data-label="@lang('Currrent Medication')">{{ __(shortDescription(@$caseStudy->case_studies->current_medication, 30)) }} </td>
                                        <td data-label="@lang('Action')">
                                            <a class="icon-btn" href="{{ route('admin.prescription.case.studies.edit',$caseStudy->id)}}">
                                                <i class="las la-edit text--shadow"></i></a>
                                            <button class="icon-btn viewBtn" title="More View"
                                                data-resources ="{{ $caseStudy }}" >
                                                <i class="las la-stream text--shadow"></i>
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
                        @if ($caseStudies->hasPages())
                            {{ paginateLinks($caseStudies) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--View Modal -->
    <div class="modal fade" id="viewModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5>@lang('Details Case Study of ') <span class="font-weight-bold patient-name"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Food Allergies')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="food_allergies"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Tendency Bleed')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="tendency_bleed"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Heart Disease')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="heart_disease"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('High Blood Pressure')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="high_blood_pressure"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Diabetic')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="diabetic"></p>
                            </div>

                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Surgery')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="surgery"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Current Medication')</h6>
                            </div>
                            <div class="col-sm-8 mt-2 mt-2">
                                <p class="current_medication"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Accident')</h6>
                            </div>
                            <div class="col-sm-8 mt-2 mt-2">
                                <p class="accident"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Female Pregnancy')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="female_pregnancy"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Breast Feeding')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="breast_feeding"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Others')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="others"></p>
                            </div>

                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Health Insurance')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="health_insurance"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Family Medical History')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="family_medical_history"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{route('admin.prescription.case.study.create')}}">
        <button class="btn btn-lg btn--primary text--small mr-3 mb-2">
            <i class="fa fa-fw fa-plus"></i>@lang('Add Case Study')
        </button>
    </a>
@endpush
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Patient ID/Firstname')"
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

            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');
                var result =  $(this).data("resources")
                modal.find('.patient-name').text(result.user.firstname+ ' '+result.user.lastname);


                modal.find('.food_allergies').text(result.case_studies.food_allergies);
                modal.find('.tendency_bleed').text(result.case_studies.tendency_bleed);
                modal.find('.heart_disease').text(result.case_studies.heart_disease);
                modal.find('.high_blood_pressure').text(result.case_studies.high_blood_pressure);
                modal.find('.diabetic').text(result.case_studies.diabetic);
                modal.find('.surgery').text(result.case_studies.surgery);
                modal.find('.current_medication').text(result.case_studies.current_medication);
                modal.find('.accident').text(result.case_studies.accident);
                modal.find('.female_pregnancy').text(result.case_studies.female_pregnancy);
                modal.find('.breast_feeding').text(result.case_studies.breast_feeding);
                modal.find('.others').text(result.case_studies.others);
                modal.find('.health_insurance').text(result.case_studies.health_insurance);
                modal.find('.family_medical_history').text(result.case_studies.family_medical_history);


                modal.find('.breast_feeding').text($(this).data("breast_feeding"));
                modal.find('.others').text($(this).data("others"));
                modal.find('.health_insurance').text($(this).data("breast_feeding"));
                modal.find('.others').text($(this).data("others"));
                modal.find('.health_insurance').text($(this).data("health_insurance"));
                modal.find('.family_medical_history').text($(this).data("family_medical_history"));


                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
