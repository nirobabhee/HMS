
@extends('admin.layouts.app')
@section('panel')
<div class="card">
    <div class="card-body border-bottom" id='printMe'>
        <div class="row py-3 bg--primary">
            <div class="col-lg-6">
              <h4 class=" text--white"><i class="fa fa-book-reader"></i> @lang('Prescription')</h4>
            </div>
            <div class="col-lg-6">
              <h5 class="float-sm-right text--white">@lang('Date:  '){{ showDateTime($prescription->created_at,'d-m-Y') }}</h5>
            </div>
          </div>

        <div class="row d-flex justify-content-between mb-4 mt-2">
          <div class="col-md-5">
            <div class="row">
                <div class="col-sm-4">@lang('Patient ID:')</div> <h6 class="col-sm-8 font-weight-light">{{ __(@$prescription->user->username)}}</h6>
                <div class="col-sm-4">@lang('Name:')</div> <h6 class="col-sm-8 font-weight-light">{{ __(@$prescription->user->fullname)}}</h6>
                <div class="col-sm-4">@lang('Appointed Dr:')</div> <h6 class="col-sm-8 font-weight-light">{{ __(@$prescription->doctor->name) }}</h6>
                <div class="col-sm-4">@lang('Age:')</div> <h6 class="col-sm-8 font-weight-light">{{ @$prescription->user->age}}</h6>
                <div class="col-sm-4">@lang('Blood Group:')</div> <h6 class="col-sm-8 font-weight-light">{{ @$prescription->user->blood_group}}</h6>
                <div class="col-sm-4">@lang('Gender:')</div> <h6 class="col-sm-8 font-weight-light">
                    @if ($prescription->user->gender == 1)
                    @lang('Male')  @elseif($prescription->user->gender == 2)  @lang('Female')  @else  @lang('Others')
                    @endif
            </h6>
            </div>
          </div><!-- /.col -->

          <div class="col-md-4 col-6">
               <div class="d-flex justify-content-start"> {{  __(@$siteInfo->data_values->site_title) }} </div>
               <div class="d-flex justify-content-start"> {{  @$siteInfo->data_values->email }} </div>
               <div class="d-flex justify-content-start"> {{  @$siteInfo->data_values->phone }} </div>
               <div class="d-flex justify-content-start"> {{  @$siteInfo->data_values->mobile }} </div>
               <div class="d-flex justify-content-start"> {{  @$siteInfo->data_values->state.', '. @$siteInfo->data_values->city  }} </div>
               <div class="d-flex justify-content-start"> {{  @$siteInfo->data_values->country.' - '. @$siteInfo->data_values->zip }} </div>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row mt-2">
         <div class="col-sm-3">
             <h5 class="border-bottom "> @lang('Prime Complain: ')</h5>
             <h6 class="font-weight-light mt-1">
                {{__(@$prescription->prime_complain)}}
            </h6>
             <h5 class="mt-3 border-bottom"> @lang('Patient Notes : ')</h5>
             <h6 class="font-weight-light mt-1">
                {{__(@$prescription->patient_notes)}}
         </div>
         <div class="col-sm-9 table-responsive--md">
            <table class="table table-striped">
              <thead class="bg--primary">
                <tr>
                  <th>@lang('S.N.')</th>
                  <th>@lang('Medicine Name')</th>
                  <th>@lang('Type')</th>
                  <th>@lang('Days')</th>
                  <th>@lang('Instruction')</th>
                </tr>
              </thead>
              <tbody>
                  @forelse ($prescription->medicine as $medicine)
                  <tr>
                    <td data-label="S.N">{{ $loop->iteration}}</td>
                    <td data-label="Medicine Name">{{ __(@$medicine->medicine_name)}}</td>
                    <td data-label="Type">{{ __(@$medicine->medicine_type)}}</td>
                    <td data-label="Days">{{__(@$medicine->days)}}</td>
                    <td data-label="Instruction">{{ __(@$medicine->medicine_instruction)}}</td>
                  </tr>
                  @empty
                    <tr> @lang('No medicine prescribed')</tr>
                  @endforelse


              </tbody>
            </table>
            {{-- //diagnosis --}}
            <table class="table table-striped mt-3">
              <thead class="bg--primary">
                <tr>
                  <th>@lang('S.N.')</th>
                  <th>@lang('Diagnosis')</th>
                  <th>@lang('Instruction')</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($prescription->diagnosis as $diagnosis)
                  <tr>
                    <td data-label="S.N.">{{ $loop->iteration}}</td>
                    <td data-label="Diagnosis">{{__($diagnosis->diagnosis)}}</td>
                    <td data-label="Instruction">{{__($diagnosis->diagnosis_instruction)}}</td>
                  </tr>
                  @empty
                    <tr> @lang('No medicine prescribed')</tr>
                  @endforelse
              </tbody>
            </table>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="d-block justify-content-end">
            <h6 class="mt-3 d-flex justify-content-end">@lang('Signature')</h6>
            <h6 class="mt-2 d-flex justify-content-end">............................................</h6>
        </div>
    </div>
        <div class="row no-print mt-2">
          <div class="col-sm-3">
            <a target="_blank" class="btn btn-dark text--white" onclick="printDiv('printMe')"><i class="fa fa-print"></i> @lang('Print')</a>
          </div>
          <div class="col-sm-9">
          <div class="float-sm-right">
            <a class="btn btn-primary m-1" href="{{route('admin.pdf.generate', $prescription->id)}}"><i class="fa fa-download"></i> @lang('PDF Generate')</a>
          </div>
          </div>
        </div>
</div><!-- card end -->
  @endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.prescription.index') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Prescription')
    </a>
@endpush

@push('script')

    <script>
		function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;

		}


	</script>


{{-- <div id='printMe'>
  Print this only
</div> --}}

<button onclick="printDiv('printMe')">Print only the above div</button>


@endpush





