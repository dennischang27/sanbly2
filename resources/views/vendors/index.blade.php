@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','vendors')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-products.css')}}">
@endsection

@section('content')
<div class="app-content-overlay"></div>
<!-- invoice list -->
<section class="invoice-list-wrapper">
  <!-- create invoice button-->
  <div class="invoice-create-btn mb-1">
    <a href="{{ route('vendors.create') }}" class="btn btn-primary glow invoice-create" role="button" aria-pressed="true">{{ __('Create vendor') }}</a>
  </div>
  <!-- Options and filter dropdown button-->
  <div class="action-dropdown-btn d-none">
    <div class="dropdown invoice-options">
      <a onclick="check_selected()" class="btn btn-primary glow invoice-create mr-2" style="color:fff;" role="button" aria-pressed="true">{{ __('Delete') }}</a>
    </div>
  </div>
  @if(count($vendors))
	  <div class="table-responsive">
		<table class="table invoice-data-table dt-responsive nowrap" style="width:100%" data-search="{{ __('Search vendors') }}">
		  <thead>
			<tr>
			  <th></th>
			  <th></th>
                 <th>
				<span class="align-middle">{{ __('Vendor Name') }}</span>
			  </th>
			 
			  <th>{{ __('Action') }}</th>
			</tr>
		  </thead>
		  <tbody>
			@foreach ($vendors as $vendor)
              
				<tr>
				  <td></td>
				  <td></td>
				 
				  <td>
					<a onclick='edit({{ $vendor->id }})' class="compose-btn" style="color: #5A8DEE;text-decoration: none;background-color: transparent;cursor: pointer;">{{ $vendor->vendor_name }}</a>
				  </td>
                  

				  <td>
					<div class="invoice-action">
					  <a onclick="check_deleted({{ $vendor->id }})" class="invoice-action-edit cursor-pointer" data-toggle="modal" data-target="#delete">
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
					<h3 class="modal-title" id="myModalLabel1">{{ __('Delete vendor') }}</h3>
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
					<form id="deleteForm" action="{{ route('vendors.destroy', $vendors) }}" method="post">
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
				<h3 class="modal-title" id="myModalLabel1">{{ __('Delete vendors') }}</h3>
				<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
				  <i class="bx bx-x"></i>
				</button>
			  </div>
			  <div class="modal-body">
				<p id="deleteAllContent">
				  {{ __('Are you sure you want to delete selected vendors') }}?
				</p>
			  </div>
			  <div id="deleteAllFooter" class="modal-footer">
				<button id="btnClose" type="button" class="btn btn-light-secondary" data-dismiss="modal">
				  <i class="bx bx-x d-block d-sm-none"></i>
				  <span class="d-none d-sm-block">{{ __('Close') }}</span>
				</button>
				<button id="btnDelete" type="button" class="btn btn-primary ml-1" onclick="delete_vendors()">
				  <i class="bx bx-check d-block d-sm-none"></i>
				  <span class="d-none d-sm-block">{{ __('Delete') }}</span>
				</button>
			  </div>
			</div>
		  </div>
		</div>
	
  @else
	  <h4>{{ __('You don`t have any vendors') }} ...</h4>
  @endif
  
</section>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{asset('js/scripts/pages/app-email.js')}}"></script>
<script src="{{asset('js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/forms/number-input.js')}}"></script>
@endsection


<script>

	function check_deleted(vendorId) {
		$('#deleteForm').attr('action', "vendors/"+vendorId);
	}

	function check_selected() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		if (items === undefined || items.length == 0) {
			$("#deleteAllContent").text("{{ __('Please select the vendor you want to delete') }}.");
			$("#deleteAllFooter").css('visibility', 'hidden');
			$('#deleteAll').modal('show');
		} else {
			$("#deleteAllContent").text("{{ __('Are you sure you want to delete selected vendors') }}?");
			$("#deleteAllFooter").css('visibility', 'visible');
			$('#deleteAll').modal('show');
		}
	}

	function delete_vendors() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		
		jQuery.ajax({
				url: '{{ route("vendors.delete") }}',
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