@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Expenses')
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
    <a href="{{ route('expenses.create') }}" class="btn btn-primary glow invoice-create" role="button" aria-pressed="true">{{ __('Create Expense') }}</a>
  </div>
  <!-- Options and filter dropdown button-->
  <div class="action-dropdown-btn d-none">
    <div class="dropdown invoice-options">
      <a onclick="check_selected()" class="btn btn-primary glow invoice-create mr-2" style="color:fff;" role="button" aria-pressed="true">{{ __('Delete') }}</a>
    </div>
  </div>
  @if(count($expenses))
	  <div class="table-responsive">
		<table class="table invoice-data-table dt-responsive nowrap" style="width:100%" data-search="{{ __('Search expenses') }}">
		  <thead>
			<tr>
			  <th></th>
			  <th></th>
                 <th>
				<span class="align-middle">{{ __('Expense Name') }}</span>
			  </th>
			  <th>
				<span class="align-middle">{{ __('Expense Date') }}</span>
			  </th>
			  <th>
				<span class="align-middle">{{ __('Amount') }}</span>
			  </th>
			  <th>
				<span class="align-middle">{{ __('Expense Category') }}</span>
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
					<a onclick='edit({{ $expense->id }},"{{
                                htmlentities($expense->name)}}",
                                "{{$expense->expense_date}}",
                                {{$expense->expense_amount}},
                                "{{$expense->expense_category_id}}","{{$expense->expense_notes}}","{{$expense->customer_id}}")' class="compose-btn" style="color: #5A8DEE;text-decoration: none;background-color: transparent;cursor: pointer;">{{ $expense->name }}</a>
				  </td>
                  <td>{{ $expense->expense_date }}</td>
				  <td>{{ $expense->expense_amount }}</td>
				  <td>{{ $expense->expenseCat->name ?? '' }}</td>

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
					<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Expense') }}</h3>
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
				<h3 class="modal-title" id="myModalLabel1">{{ __('Delete expenses') }}</h3>
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
	<!-- Edit expense right area -->
	<div class="email-sidebar ps">
		<div class="card shadow-none quill-wrapper p-0">
		  <div class="card-header">
			<h3 class="card-title" id="emailCompose">{{ __('Expense Information') }}</h3>
			<button type="button" class="close close-icon">
			  <i class="bx bx-x"></i>
			</button>
		  </div>
		  <!-- form start -->
		  <form id="editForm" method="post" action="{{ route('expenses.update', $expense) }}" autocomplete="off" enctype="multipart/form-data">
			@csrf
			@method('put')
			<div class="card-content">
			  <div class="card-body pt-0">
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Expense Name/ Description') }} *</label>
				  <input type="text" id="expense_name" class="form-control" name="expense_name" placeholder="{{ __('Expense Name') }}" required data-validation-required-message="{{ __('This Expense Name field is required') }}">
				</div>
				<div class="form-group pb-50">
				<label for="first-name-vertical">{{ __('Expense Category') }}</label>
					    <select id="expense_category" name="expense_category" class="select2 form-control" >
                            <option value=""></option>
							@foreach($categories as $category)
								<option value="{{$category['id']}}"  @if (old('expense_category') == $category['id']) {{ 'selected' }} @endif>{{$category['name']}}</option>
							@endforeach
					    </select>
				</div>
			
				
				<div class="form-group pb-50">
					<div class="controls" >
						  <label for="first-name-vertical">{{ __('Expense Date') }} *</label>
                            
                      <input id="expense_date" name="expense_date" type="text" class="form-control pickadate mr-2 mb-50 mb-sm-0" placeholder="{{ __('Select Date') }}" required data-validation-required-message="{{ __('This Expense Date field is required') }}">
						</div>
				</div>
                <div class="form-group ">
                  <div class="controls">
							<label for="email-id-vertical">{{ __('Amount') }} *</label>
							<div class="nopadding input-group">
							<span class="input-group-text" style="border-top-right-radius:0rem;border-bottom-right-radius:0rem;color: #828D99;">RM</span>
							  <input step=".01" min="0.00" type="number" name="expense_amount" id="expense_amount" class="form-control" style="color: #828D99;" placeholder="0.00" required data-validation-required-message="{{ __('This Amount field is required') }}">
							</div>
						</div>
                  </div>
				<div class="form-group">
					<fieldset class="form-group">
						<label for="email-id-vertical">{{ __('Notes') }} </label>
						<textarea name="notes" id="notes" class="form-control" rows="3" placeholder="{{ __('Notes') }}"></textarea>
					</fieldset>
				</div>
                  <div class="form-group">
						<label for="first-name-vertical">{{ __('Vendor') }}</label>
					    <select id="vendor" name="vendor" class="select2 form-control">
					    </select>
					</div>
                      <div class="form-group">
						<label for="first-name-vertical">{{ __('Customer') }}</label>
					    <select id="customer" name="customer" class="select2 form-control" >
                        <option value=""></option>
                        @foreach($customers as $customer)
                           <option value="{{$customer['id']}}"  @if (old('customer') == $customer['id']) {{ 'selected' }} @endif>{{$customer['name']}}</option>
                        @endforeach
                    </select>
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
	function edit(id, name, expense_date, expense_amount, expense_category_id,expense_notes,customer_id) {
		
		$('#expense_name').val(name.trim().replace(/&quot;/g, '"'));
		$('#expense_date').val(expense_date.trim());
        
		if(expense_category_id){
			$("#expense_category").val(expense_category_id).change();
		} else {
            $("#expense_category").val("").change();
        }
		$("#expense_amount").val(expense_amount.toFixed(2));

		$("#notes").val(expense_notes);
		
	   if(customer_id){
			$("#customer").val(customer_id).change();
		}

		$('#editForm').attr('action', "expenses/"+id);
	}
	
	function check_deleted(expenseId) {
		$('#deleteForm').attr('action', "expenses/"+expenseId);
	}

	function check_selected() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		if (items === undefined || items.length == 0) {
			$("#deleteAllContent").text("{{ __('Please select the expense you want to delete') }}.");
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