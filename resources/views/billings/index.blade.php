@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Billings')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-billing.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-taxes.css')}}">
@endsection
<style>
	/* Gray */
	.default {
	  border-color: #e7e7e7 !important;
	  color: black;
	}
	.btn {
	  border-radius: 5px;
	}
</style>

@section('content')
<div class="app-content-overlay"></div>
<!-- invoice list -->
<section class="invoice-list-wrapper">
  @if(count($billings))
	  <div class="table-responsive">
		<table class="table invoice-data-table dt-responsive nowrap" style="width:100%" data-search="{{ __('Search Billings') }}">
		  <thead>
			<tr>
			  <th>
				<span class="align-middle">{{ __('Customer') }}</span>
			  </th>
			  <th>{{ __('Plan') }}</th>
			  <th>{{ __('Type') }}</th>
			  <th>{{ __('Total Amount') }}</th>
			  <th></th>
			</tr>
		  </thead>
		  <tbody>
			@foreach ($billings as $billing)
				<tr>
				  <td><span class="invoice-amount">{{ $billing->name }}</span></td>
				  <td><span class="invoice-amount">{{ $billing->product_description }}</span></td>
				  <td><span class="invoice-amount">{{ $billing->provider }}</span></td>
				  <td><span class="invoice-amount">{{ substr($billing->amount, 0, -2) }} {{ strtoupper($billing->currency) }}</span></td>
				  <td>
					<div class="invoice-action">
						<form method="post" action="{{ route('billings.update', $billing) }}" autocomplete="off" enctype="multipart/form-data" style="margin-bottom:0px;">
							@csrf
							@method('put')
							<button type="submit" class="btn btn-outline-secondary"><i class="bx bx-detail"></i>  {{ __('Invoice') }}</button>
						</form>
					</div>
				  </td>
				</tr>
			@endforeach
		  </tbody>
		</table>
	  </div>
  @else
	  <h4>{{ __('You don`t have any billings') }} ...</h4>
  @endif
  
</section>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-billing.js')}}"></script>
<script src="{{asset('js/scripts/pages/app-email.js')}}"></script>
<script src="{{asset('js/scripts/forms/validation/form-validation.js')}}"></script>
@endsection
