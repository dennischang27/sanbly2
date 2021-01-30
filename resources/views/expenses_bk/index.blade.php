@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Expenses')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-taxes.css')}}">
@endsection

@section('content')
<div class="app-content-overlay"></div>
<!-- invoice list -->
<section class="invoice-list-wrapper">
  <!-- create invoice button-->
  <div class="invoice-create-btn mb-1">
    <a href="{{ route('expenses.create') }}" class="btn btn-primary glow invoice-create" role="button" aria-pressed="true">{{ __('Create Expenses') }}</a>
  </div>
  <!-- Options and filter dropdown button-->
  <div class="action-dropdown-btn d-none">
    <div class="dropdown invoice-options">
      <a onclick="check_selected()" class="btn btn-primary glow invoice-create mr-2" style="color:fff;" role="button" aria-pressed="true">{{ __('Delete') }}</a>
    </div>
  </div>
  
  @if(count($expenses))
	  <div class="table-responsive">
		<table class="table invoice-data-table dt-responsive nowrap" style="width:100%" data-search="{{ __('Search Expenses') }}">
		  <thead>
			<tr>
			  <th></th>
			  <th></th>
			  <th>
				<span class="align-middle">{{ __('Expenses Name') }}</span>
			  </th>
			  <th>
				<span class="align-middle">{{ __('Expenses Category') }}</span>
			  </th>
			  <th>{{ __('Action') }}</th>
			</tr>
		  </thead>
		  <tbody>
			@foreach ($expenses as $expense)
				<tr>
				  <td></td>
				  <td data-id="{{ $expense->id }}"></td>
				  <td>
					<a onclick='edit({{ $expense->id }},"{{$expense->name}}","{{$expense->expenses_category_name}}")' class="compose-btn" style="color: #5A8DEE;text-decoration: none;background-color: transparent;cursor: pointer;">{{ $expense->name }}</a>
				  </td>
				  <td>{{ $expense->expenses_category_name }}</td>
				  <td>
					<div class="invoice-action">
					  <a onclick="check_deleted({{ $expense->id }})" class="invoice-action-edit cursor-pointer" data-toggle="modal" data-target="#delete">
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
					<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Expenses') }}</h3>
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
					<form id="deleteForm" action="{{ route('expenses.destroy', $expense) }}" method="post">
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
				<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Expenses') }}</h3>
				<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
				  <i class="bx bx-x"></i>
				</button>
			  </div>
			  <div class="modal-body">
				<p id="deleteAllContent">
				  {{ __('Are you sure you want to delete selected expenses') }}?
				</p>
			  </div>
			  <div id="deleteAllFooter" class="modal-footer">
				<button id="btnClose" type="button" class="btn btn-light-secondary" data-dismiss="modal">
				  <i class="bx bx-x d-block d-sm-none"></i>
				  <span class="d-none d-sm-block">{{ __('Close') }}</span>
				</button>
				<button id="btnDelete" type="button" class="btn btn-primary ml-1" onclick="delete_expenses()">
				  <i class="bx bx-check d-block d-sm-none"></i>
				  <span class="d-none d-sm-block">{{ __('Delete') }}</span>
				</button>
			  </div>
			</div>
		  </div>
		</div>
	<!-- Edit expenses right area -->
	<div class="email-sidebar ps">
		<div class="card shadow-none quill-wrapper p-0">
		  <div class="card-header">
			<h3 class="card-title" id="emailCompose">{{ __('Expenses Information') }}</h3>
			<button type="button" class="close close-icon">
			  <i class="bx bx-x"></i>
			</button>
		  </div>
		  <!-- form start -->
		  <form id="editForm" method="post" action="{{ route('expenses.update', $expenses) }}" autocomplete="off" enctype="multipart/form-data">
			@csrf
			@method('put')
			<div class="card-content">
			  <div class="card-body pt-0">
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Expenses Name') }} *</label>
				  <input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Expenses Name') }}" required data-validation-required-message="{{ __('This Expenses Name field is required') }}">
				</div>
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Expenses Category') }}</label>
				  <textarea name="category" id="category" class="form-control" rows="3" maxlength="300" placeholder="{{ __('Expenses Category') }}"></textarea>
				</div>
				<div class="col-md-6" style="margin-left:0px;">
					<div class="form-group">
						<div class="controls">
							<div class="invoice-terms-title" style="margin-bottom:12px;">{{ __('Active') }}</div>
							<div class="custom-control custom-switch custom-switch-glow">
							  <input name="active" type="checkbox" class="custom-control-input" checked id="paymentTerm">
							  <label class="custom-control-label" for="paymentTerm">
							  </label>
							</div>
						</div>
					</div>
                  </div>
			  </div>
			</div>
			<div class="card-footer d-flex justify-content-end pt-0">
			  <button type="reset" class="btn btn-light-secondary cancel-btn mr-1">
				<i class='bx bx-x mr-25'></i>
				<span class="d-sm-inline d-none">{{ __('Cancel') }}</span>
			  </button>
			  <button type="submit" class="btn-send btn btn-primary">
				<i class='bx bx-send mr-25'></i> <span class="d-sm-inline d-none">{{ __('Update') }}</span>
			  </button>
			</div>
		  </form>
		  <!-- form start end-->
		</div>
	</div>
  @else
	  <h4>{{ __('You don`t have any expenses') }} ...</h4>
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
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{asset('js/scripts/pages/app-email.js')}}"></script>
<script src="{{asset('js/scripts/forms/validation/form-validation.js')}}"></script>
@endsection
<script>
	function edit(id, name, category, is_active) {
		$('#name').val(name.trim());
		$('#category').val(category.trim());
		
		if(is_active == 1){
			$('#paymentTerm').prop('checked', true);
		}else{
			$('#paymentTerm').prop('checked', false);
		}
		
		$('#editForm').attr('action', "expenses/"+id);
	}
	
	function check_deleted(expensesId) {
		$('#deleteForm').attr('action', "expenses/"+expensesId);
	}

	function check_selected() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		if (items === undefined || items.length == 0) {
			$("#deleteAllContent").text("{{ __('Please select the expenses you want to delete') }}.");
			$("#deleteAllFooter").css('visibility', 'hidden');
			$('#deleteAll').modal('show');
		} else {
			$("#deleteAllContent").text("{{ __('Are you sure you want to delete selected expenses') }}?");
			$("#deleteAllFooter").css('visibility', 'visible');
			$('#deleteAll').modal('show');
		}
	}

	function delete_expenses() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		
		jQuery.ajax({
				url: '{{ route("expenses.delete") }}',
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