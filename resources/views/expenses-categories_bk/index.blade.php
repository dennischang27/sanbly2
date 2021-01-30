@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Expenses Categories')
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
    <a href="{{ route('expenses-categories.create') }}" class="btn btn-primary glow invoice-create" role="button" aria-pressed="true">{{ __('Create Expenses Category') }}</a>
  </div>
  <!-- Options and filter dropdown button-->
  <div class="action-dropdown-btn d-none">
    <div class="dropdown invoice-options">
      <a onclick="check_selected()" class="btn btn-primary glow invoice-create mr-2" style="color:fff;" role="button" aria-pressed="true">{{ __('Delete') }}</a>
    </div>
  </div>
  
  @if(count($expenses_categories))
	  <div class="table-responsive">
		<table class="table invoice-data-table dt-responsive nowrap" style="width:100%" data-search="{{ __('Search Expenses Categories') }}">
		  <thead>
			<tr>
			  <th></th>
			  <th></th>
			  <th>
				<span class="align-middle">{{ __('Expenses Category Name') }}</span>
			  </th>
			  <th>
				<span class="align-middle">{{ __('Description') }}</span>
			  </th>
			  <th>
				<span class="align-middle">{{ __('Active') }}</span>
			  </th>
			  <th>{{ __('Action') }}</th>
			</tr>
		  </thead>
		  <tbody>
			@foreach ($expenses_categories as $expenses_category)
				<tr>
				  <td></td>
				  <td data-id="{{ $expenses_category->id }}"></td>
				  <td>
					<a onclick='edit({{ $expenses_category->id }},"{{$expenses_category->name}}","{{$expenses_category->description}}",{{$expenses_category->is_active}})' class="compose-btn" style="color: #5A8DEE;text-decoration: none;background-color: transparent;cursor: pointer;">{{ $expenses_category->name }}</a>
				  </td>
				  <td>{{ $expenses_category->description }}</td>
				  @if($expenses_category->is_active == 1)
					  <td>{{ __('Active') }}</td>
				  @else
					  <td>{{ __('Inactive') }}</td>
				  @endif
				  
				  <td>
					<div class="invoice-action">
					  <a onclick="check_deleted({{ $expenses_category->id }})" class="invoice-action-edit cursor-pointer" data-toggle="modal" data-target="#delete">
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
					<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Expenses Category') }}</h3>
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
					<form id="deleteForm" action="{{ route('expenses-categories.destroy', $expenses_category) }}" method="post">
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
				<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Expenses Categories') }}</h3>
				<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
				  <i class="bx bx-x"></i>
				</button>
			  </div>
			  <div class="modal-body">
				<p id="deleteAllContent">
				  {{ __('Are you sure you want to delete selected expenses categories') }}?
				</p>
			  </div>
			  <div id="deleteAllFooter" class="modal-footer">
				<button id="btnClose" type="button" class="btn btn-light-secondary" data-dismiss="modal">
				  <i class="bx bx-x d-block d-sm-none"></i>
				  <span class="d-none d-sm-block">{{ __('Close') }}</span>
				</button>
				<button id="btnDelete" type="button" class="btn btn-primary ml-1" onclick="delete_expenses_categories()">
				  <i class="bx bx-check d-block d-sm-none"></i>
				  <span class="d-none d-sm-block">{{ __('Delete') }}</span>
				</button>
			  </div>
			</div>
		  </div>
		</div>
	<!-- Edit expenses category right area -->
	<div class="email-sidebar ps">
		<div class="card shadow-none quill-wrapper p-0">
		  <div class="card-header">
			<h3 class="card-title" id="emailCompose">{{ __('Expenses Category Information') }}</h3>
			<button type="button" class="close close-icon">
			  <i class="bx bx-x"></i>
			</button>
		  </div>
		  <!-- form start -->
		  <form id="editForm" method="post" action="{{ route('expenses-categories.update', $expenses_category) }}" autocomplete="off" enctype="multipart/form-data">
			@csrf
			@method('put')
			<div class="card-content">
			  <div class="card-body pt-0">
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Expenses Category Name') }} *</label>
				  <input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Expenses Category Name') }}" required data-validation-required-message="{{ __('This Expenses Category Name field is required') }}">
				</div>
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Description') }}</label>
				  <textarea name="description" id="description" class="form-control" rows="3" maxlength="300" placeholder="{{ __('Description') }}"></textarea>
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
	  <h4>{{ __('You don`t have any expenses categories') }} ...</h4>
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
	function edit(id, name, description, is_active) {
		$('#name').val(name.trim());
		$('#description').val(description.trim());
		
		if(is_active == 1){
			$('#paymentTerm').prop('checked', true);
		}else{
			$('#paymentTerm').prop('checked', false);
		}
		
		$('#editForm').attr('action', "expenses-categories/"+id);
	}
	
	function check_deleted(expensesCategoryId) {
		$('#deleteForm').attr('action', "expenses-categories/"+expensesCategoryId);
	}

	function check_selected() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		if (items === undefined || items.length == 0) {
			$("#deleteAllContent").text("{{ __('Please select the expenses categories you want to delete') }}.");
			$("#deleteAllFooter").css('visibility', 'hidden');
			$('#deleteAll').modal('show');
		} else {
			$("#deleteAllContent").text("{{ __('Are you sure you want to delete selected expenses categories') }}?");
			$("#deleteAllFooter").css('visibility', 'visible');
			$('#deleteAll').modal('show');
		}
	}

	function delete_expenses_categories() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		
		jQuery.ajax({
				url: '{{ route("expenses-categories.delete") }}',
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