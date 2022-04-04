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
                                    <th>@lang('Appointment No')</th>
                                    <th>@lang('Patient ID')</th>
                                    <th>@lang('Department')</th>
                                    <th>@lang('Doctor Name')</th>
                                    <th>@lang('Appointment Date')</th>
                                    <th>@lang('Schedule')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Serial')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Appointment No')">{{ $appointment->appointment_no }}</td>
                                        <td data-label="@lang('Patient ID')">
                                            <a href="{{ route('admin.users.detail', $appointment->user_id) }}">
                                                {{ @$appointment->user->username }}
                                            </a>
                                        </td>
                                        <td data-label="@lang('Department')">

                                            {{ __(@$appointment->department->name) }}

                                        </td>
                                        <td data-label="@lang('Doctor Name')">
                                            <a  href="{{ route('admin.doctor.edit', $appointment->doctor_id) }}">
                                                {{ @$appointment->doctor->name }}
                                            </a>
                                        </td>
                                        <td data-label="@lang('Appointment Date')">{{ __(@$appointment->booking_date) }}</td>
                                        <td data-label="@lang('Schedule')"> {{ __(@$appointment->slot->from_time . ' - ' . @$appointment->slot->to_time) }} </td>
                                        <td data-label="@lang('Priority')">
                                            @if (@$appointment->priority == 1)
                                                <span class="badge badge--primary">@lang('Normal')</span>
                                            @elseif (@$appointment->priority == 2)
                                                <span class="badge badge--success">@lang('Urgent')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Very Urgent')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Serial No')">{{ __(@$appointment->serial_no) }} </td>
                                        <td data-label="@lang('Status')">
                                            @if (@$appointment->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('Pending')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a class="icon-btn" href="{{route('admin.prescription.create')}}"><i class="las la-book-open text--shadow"></i></a>
                                            <button class="icon-btn viewBtn" data-resource="{{ $appointment }}">
                                                <i class="las la-stream text--shadow"></i>
                                            </button>
                                            @if($appointment->status == 0)
                                            <button type="button"
                                                    class="icon-btn btn--success ml-1 activateBtn"
                                                    data-toggle="modal" data-target="#activateModal"
                                                    data-id="{{ $appointment->id }}"
                                                    data-name="{{ __($appointment->appointment_no) }}"
                                                    data-original-title="@lang('Enable')">
                                                <i class="la la-eye"></i>
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="icon-btn btn--danger ml-1 deactivateBtn"
                                                    data-toggle="modal" data-target="#deactivateModal"
                                                    data-id="{{ $appointment->id }}"
                                                    data-name="{{ __($appointment->appointment_no) }}"
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
                        @if ($appointments->hasPages())
                            {{ paginateLinks($appointments) }}
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
                <h5 class="modal-title">@lang('Appointment Activation Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.appointment.activate') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to activate') <span class="font-weight-bold appointment-no"></span> @lang('appointment')?</p>
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
                <h5 class="modal-title">@lang('Appointment Deactivate Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.appointment.deactivate') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to disable') <span class="font-weight-bold appointment-no"></span> @lang('appointment')?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--danger">@lang('Deactivate')</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!--View Modal -->
    <div class="modal fade" id="viewModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Appointment Details') </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Patient Name')</h6>
                                    <p class="ml-4 name"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Age')</h6>
                                    <p class="ml-4 age"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('E-mail')</h6>
                                    <p class="ml-4 email"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Phone')</h6>
                                    <p class="ml-4 phone"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Doctor')</h6>
                                    <p class="ml-4 doctor"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Department')</h6>
                                    <p class="ml-4 department"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Live Consultation')</h6>
                                    <p class="ml-4 live_consultant"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Payment Note')</h6>
                                    <p class="ml-4 payment_note"></p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Appointment No')</h6>
                                    <p class="ml-4 appointment_no"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2 ">
                                    <h6>@lang('Appointment Date')</h6>
                                    <p class="ml-4 booking_date"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Appointment Serial')</h6>
                                    <p class="ml-4 serial"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Priority')</h6>
                                    <p class="ml-4 priority"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Slot')</h6>
                                    <p class="ml-4 slot"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Dr. Fee')</h6>
                                    <p class="ml-4 fee"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Assign by')</h6>
                                    <p class="ml-4 assign_by"></p>
                                </div>
                                <div class="d-flex justify-content-start my-2">
                                    <h6>@lang('Transaction ID')</h6>
                                    <p class="ml-4 transaction_id"></p>
                                </div>
                            </div>
                            <div class="my-1">
                                <h6 class="ml-3">@lang('Disease Details')</h6>
                                <p class="ml-3 disease_details"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.appointment.create') }}">
        <button class="btn btn-lg btn--primary text--small mr-3 mb-2">
            <i class="fa fa-fw fa-plus"></i>@lang('Add Appointment')
        </button>
    </a>
@endpush
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('No/ Doctor/ Date /Priority')"
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
            //view-Appointment
            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');
                var result = $(this).data("resource");

                modal.find('.name').text(`${result.user.firstname}  ${result.user.lastname}`);
                modal.find('.age').text(`${result.user.age}`);
                modal.find('.email').text(`${result.user.email}`);
                modal.find('.phone').text(`${result.user.mobile}`);
                modal.find('.doctor').text(`${result.doctor.name}`);
                modal.find('.department').text(`${result.department.name}`);

                if (result.live_consultant == 1) {
                    modal.find('.live_consultant').text(`Yes`);
                } else {
                    modal.find('.live_consultant').text(`No`);
                }
                modal.find('.payment_note').text(`None`);
                modal.find('.appointment_no').text(`${result.appointment_no}`);

                if (result.priority == 1) {
                    modal.find('.priority').text(`Normal`);
                } else if (result.priority == 2) {
                    modal.find('.priority').text(`Urgent`);
                } else {
                    modal.find('.priority').text(`Very Urgent`);
                }
                modal.find('.booking_date').text(`${result.booking_date}`);
                modal.find('.serial').text(`${result.serial_no}`);
                modal.find('.slot').text(`${result.slot.from_time} - ${result.slot.to_time}`);
                modal.find('.fee').text(`${result.doctor.fee}`);
                modal.find('.appointment_no').text(`${result.appointment_no}`);
                if (result.assign_by == 1) {
                    modal.find('.assign_by').text(`Admin`);
                }else if(result.assign_by == 2){
                    modal.find('.assign_by').text(`Doctor`);
                }else{
                    modal.find('.assign_by').text(`Receptionist`);
                }
                modal.find('.disease_details').text(`${result.disease_details}`);
                modal.modal('show');
            });
            //status
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.appointment-no').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.appointment-no').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });
        })(jQuery);
    </script>
@endpush
