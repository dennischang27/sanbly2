@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Invoice List')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

@section('content')
<!-- invoice list -->
<section class="invoice-list-wrapper">
  <!-- create invoice button-->
  <div class="invoice-create-btn mb-1">
    <a href="{{ route('invoices.create') }}" class="btn btn-primary glow invoice-create" role="button" aria-pressed="true">{{ __('Create Invoice') }}</a>
  </div>
  
  @if(count($invoices))
	  <!-- Options and filter dropdown button-->
	  <div class="action-dropdown-btn d-none">
		<div class="dropdown invoice-options">
		  <a href="#" onclick="check_selected()" class="btn btn-primary glow invoice-create mr-2" style="color:fff;" role="button" aria-pressed="true">{{ __('Delete') }}</a>
		</div>
	  </div>
	  
	  <div class="table-responsive">
		<table class="table invoice-data-table dt-responsive nowrap" style="width:100%">
		  <thead>
			<tr>
			  <th></th>
			  <th></th>
			  <th>
				<span class="align-middle">{{ __('Invoice No') }}</span>
			  </th>
			  <th>{{ __('Amount') }}</th>
			  <th>{{ __('Status') }}</th>
			  <th>{{ __('Date Issue') }}</th>
			  <th>{{ __('Date Due') }}</th>
			  <th>{{ __('Customer') }}</th>
			  <th>{{ __('Payment Terms') }}</th>
			  <th>{{ __('Notes') }}</th>
			  <th>{{ __('Action') }}</th>
			</tr>
		  </thead>
		  <tbody>
			@foreach ($invoices as $invoice)
			<tr>
			  <td></td>
			  <td data-id="{{ $invoice->id }}"></td>
			  <td>
				<a href="{{URL::to('/view-invoice/')}}/{{$invoice->id}}">{{ $invoice->invoice_id }}</a>
			  </td>
			  <td><span class="invoice-amount">{{ number_format((float)$invoice->invoice_total, 2, '.', '') }}</span></td>
			  <td><span class="invoice-amount">{{ $invoice->status }}</span></td>
			  <td><span class="invoice-date-issue">{{ $invoice->date_issue }}</span></td>
			  <td><span class="invoice-date-due">{{ $invoice->date_due }}</span></td>
			  <td><span class="invoice-customer">{{ $invoice->customer_name }}</span></td>
			  <td><span class="invoice-payment-terms">{{ $invoice->payment_terms }}</span></td>
			  <td><span class="invoice-payment-terms">{{ $invoice->client_notes }}</span></td>
			  <td>
				<div class="invoice-action">
				  @if($invoice->status != 'paid')
				  <a href="{{URL::to('/edit/')}}/{{$invoice->id}}" class="invoice-action-edit cursor-pointer">
					<i class="bx bx-edit"></i>
				  </a>
				  @endif
				  <a onclick="check_deleted({{ $invoice->id }})" class="invoice-action-edit cursor-pointer" data-toggle="modal" data-target="#delete">
					<i class="bx bx-trash"></i>
				  </a>
				</div>
			  </td>
			</tr>
			@endforeach
			<!--Delete Modal -->
            <div class="modal fade text-left" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-scrollable" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Invoice') }}</h3>
					<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
					  <i class="bx bx-x"></i>
					</button>
				  </div>
				  <div class="modal-body">
					<p>
					  {{ __('Are you sure you want to delete this item') }}?
					</p>
				  </div>
				  <div class="modal-footer">
					<form id="deleteForm" action="{{ route('invoices.destroy', $invoice) }}" method="post">
						@csrf
						@method('delete')
						<button type="button" class="btn btn-light-secondary" data-dismiss="modal">
						  <i class="bx bx-x d-block d-sm-none"></i>
						  <span class="d-none d-sm-block">{{ __('Close') }}</span>
						</button>
						<button type="submit" class="btn btn-primary ml-1">
						  <i class="bx bx-check d-block d-sm-none"></i>
						  <span class="d-none d-sm-block">{{ __('Delete') }}</span>
						</button>
					</form>
				  </div>
				</div>
			  </div>
			</div>
		  </tbody>
		</table>
	  </div>
	  <!--Delete All Modal -->
		<div class="modal fade text-left" id="deleteAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Invoices') }}</h3>
				<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
				  <i class="bx bx-x"></i>
				</button>
			  </div>
			  <div class="modal-body">
				<p id="deleteAllContent">
				  {{ __('Are you sure you want to delete selected invoices') }}?
				</p>
			  </div>
			  <div id="deleteAllFooter" class="modal-footer">
				<button id="btnClose" type="button" class="btn btn-light-secondary" data-dismiss="modal">
				  <i class="bx bx-x d-block d-sm-none"></i>
				  <span class="d-none d-sm-block">{{ __('Close') }}</span>
				</button>
				<button id="btnDelete" type="button" class="btn btn-primary ml-1" onclick="delete_invoices()">
				  <i class="bx bx-check d-block d-sm-none"></i>
				  <span class="d-none d-sm-block">{{ __('Delete') }}</span>
				</button>
			  </div>
			</div>
		  </div>
		</div>
  @else
	  <h4>{{ __('You don`t have any invoice') }} ...</h4>
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
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection
<script>
	function check_deleted(invoiceId) {
		$('#deleteForm').attr('action', "invoices/"+invoiceId);
	}
	
	function check_selected() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		if (items === undefined || items.length == 0) {
			$("#deleteAllContent").text("{{ __('Please select the invoices you want to delete') }}.");
			$("#deleteAllFooter").css('visibility', 'hidden');
			$('#deleteAll').modal('show');
		} else {
			$("#deleteAllContent").text("{{ __('Are you sure you want to delete selected invoices') }}?");
			$("#deleteAllFooter").css('visibility', 'visible');
			$('#deleteAll').modal('show');
		}
	}
	
	function delete_invoices() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		
		jQuery.ajax({
				url: '{{ route("invoices.delete") }}',
				method: 'post',
				cache: false,
				data: {
					items: items,
					"_token": "{{ csrf_token() }}"
					}
		}).then(function(response) {
			console.log(response);
			location.reload(); 
		}, function(error) {
			console.log(error);
		});
	}
</script>