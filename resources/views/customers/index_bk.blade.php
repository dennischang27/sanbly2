@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Account Settings')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-products.css')}}">
@endsection

@section('content')
<!-- account setting page start -->
<section id="page-account-settings">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <!-- left menu section -->
                <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center active" id="account-pill-profile" data-toggle="pill"
                                href="#account-vertical-profile" aria-expanded="true">
                                <i class="bx bx-cog"></i>
                                <span>{{ __('Profile') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-invoices" data-toggle="pill"
                                href="#account-vertical-invoices" aria-expanded="false">
                                <i class="bx bx-lock"></i>
                                <span>{{ __('Invoices') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- right content section -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-profile"
                                        aria-labelledby="account-pill-profile" aria-expanded="true">
                                        <form method="post" action="{{ route('account-settings.updateGeneral', $user) }}" novalidate>
											@csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('First Name') }}</label>
                                                            <input type="text" class="form-control" name="first_name"
                                                                placeholder="{{ __('First Name') }}" value="{{ $user->first_name }}" required
                                                                data-validation-required-message="{{ __('This first name field is required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('Last Name') }}</label>
                                                            <input type="text" class="form-control" placeholder="{{ __('Last Name') }}" name="last_name"
                                                                value="{{ $user->last_name }}" required
                                                                data-validation-required-message="{{ __('This last name field is required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('Email') }}</label>
                                                            <input type="email" class="form-control" placeholder="{{ __('Email') }}" name="email"
                                                                value="{{ $user->email }}" required
                                                                data-validation-required-message="{{ __('This email field is required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{ __('Company') }}</label>
                                                        <input type="text" class="form-control" value="{{ $company->name }}" name="company"
                                                            placeholder="{{ __('Company name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">{{ __('Save changes') }}</button>
                                                    <button type="reset" class="btn btn-light mb-1">{{ __('Cancel') }}</button>
                                                </div>
                                            </div>
											<input type="hidden" id="id" name="id" value="{{ $user->id }}">
                                        </form>
                                    </div>
                                    <div class="tab-pane fade " id="account-vertical-invoices" role="tabpanel"
                                        aria-labelledby="account-pill-invoices" aria-expanded="false">
                                        <div class="app-content-overlay"></div>
										<!-- invoice list -->
										<section class="invoice-list-wrapper">
										  <!-- create invoice button-->
										  <div class="invoice-create-btn mb-1">
											<a href="{{ route('products.create') }}" class="btn btn-primary glow invoice-create" role="button" aria-pressed="true">{{ __('Create Product') }}</a>
										  </div>
										  <!-- Options and filter dropdown button-->
										  <div class="action-dropdown-btn d-none">
											<div class="dropdown invoice-options">
											  <a onclick="check_selected()" class="btn btn-primary glow invoice-create mr-2" style="color:fff;" role="button" aria-pressed="true">{{ __('Delete') }}</a>
											</div>
										  </div>
										  @if(count($products))
											  <div class="table-responsive">
												<table class="table invoice-data-table dt-responsive nowrap" style="width:100%" data-search="{{ __('Search Products') }}">
												  <thead>
													<tr>
													  <th></th>
													  <th></th>
													  <th>
														<span class="align-middle">{{ __('Item Code') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Product Name') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Serial Number') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Product Category') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Product Price') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Product Cost') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Taxes') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Price includes tax') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Stock Level') }}</span>
													  </th>
													  <th>
														<span class="align-middle">{{ __('Notes') }}</span>
													  </th>
													  <th>{{ __('Action') }}</th>
													</tr>
												  </thead>
												  <tbody>
													@foreach ($products as $product)
														<tr>
														  <td></td>
														  <td data-id="{{ $product->id }}"></td>
														  <td>{{ $product->item_code }}</td>
														  <td>
															<a onclick='edit({{ $product->id }},"{{$product->name}}","{{$product->item_code}}","{{$product->serial_number}}","{{$product->category}}",{{$product->price}},{{$product->cost}},"{{$product->tax}}",{{$product->price_includes_tax}},{{$product->stock_level}},"{{$product->notes}}")' class="compose-btn" style="color: #5A8DEE;text-decoration: none;background-color: transparent;cursor: pointer;">{{ $product->name }}</a>
														  </td>
														  <td>{{ $product->serial_number }}</td>
														  <td>{{ $product->category }}</td>
														  <td>{{ number_format($product->price, 2, '.', ',') }}</td>
														  <td>{{ number_format($product->cost, 2, '.', ',') }}</td>
														  <td>{{ $product->tax }}</td>
														  <td>{{ $product->price_includes_tax === 1 ? "Yes" : "No" }}</td>
														  <td>{{ $product->stock_level }}</td>
														  <td>{{ $product->notes }}</td>
														  <td>
															<div class="invoice-action">
															  <a onclick="check_deleted({{ $product->id }})" class="invoice-action-edit cursor-pointer" data-toggle="modal" data-target="#delete">
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
															<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Product') }}</h3>
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
															<form id="deleteForm" action="{{ route('products.destroy', $product) }}" method="post">
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
														<h3 class="modal-title" id="myModalLabel1">{{ __('Delete Products') }}</h3>
														<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
														  <i class="bx bx-x"></i>
														</button>
													  </div>
													  <div class="modal-body">
														<p id="deleteAllContent">
														  {{ __('Are you sure you want to delete selected products') }}?
														</p>
													  </div>
													  <div id="deleteAllFooter" class="modal-footer">
														<button id="btnClose" type="button" class="btn btn-light-secondary" data-dismiss="modal">
														  <i class="bx bx-x d-block d-sm-none"></i>
														  <span class="d-none d-sm-block">{{ __('Close') }}</span>
														</button>
														<button id="btnDelete" type="button" class="btn btn-primary ml-1" onclick="delete_products()">
														  <i class="bx bx-check d-block d-sm-none"></i>
														  <span class="d-none d-sm-block">{{ __('Delete') }}</span>
														</button>
													  </div>
													</div>
												  </div>
												</div>
											<!-- Edit product right area -->
											<div class="email-sidebar ps">
												<div class="card shadow-none quill-wrapper p-0">
												  <div class="card-header">
													<h3 class="card-title" id="emailCompose">{{ __('Product Information') }}</h3>
													<button type="button" class="close close-icon">
													  <i class="bx bx-x"></i>
													</button>
												  </div>
												  <!-- form start -->
												  <form id="editForm" method="post" action="{{ route('products.update', $product) }}" autocomplete="off" enctype="multipart/form-data">
													@csrf
													@method('put')
													<div class="card-content">
													  <div class="card-body pt-0">
														<div class="form-group pb-50">
														  <label for="first-name-vertical">{{ __('Item Code') }}</label>
														  <input type="text" id="item_code" class="form-control" name="item_code" placeholder="{{ __('Item Code') }}">
														</div>
														<div class="form-group pb-50">
														  <label for="first-name-vertical">{{ __('Product Name') }} *</label>
														  <input type="text" id="product_name" class="form-control" name="product_name" placeholder="{{ __('Product Name') }}" required data-validation-required-message="{{ __('This Product Name field is required') }}">
														</div>
														<div class="form-group pb-50">
														  <label for="first-name-vertical">{{ __('Serial Number') }}</label>
														  <input type="text" id="serial_number" class="form-control" name="serial_number" placeholder="{{ __('Serial Number') }}">
														</div>
														<div class="form-group pb-50">
														  <label for="first-name-vertical">{{ __('Product Category') }}</label>
														  <select id="product_category" name="product_category" class="select2 form-control" style="color: #475F7B;">
															@foreach($categories as $category)
																<option value="{{$category['name']}}"  @if (old('product_category') == $category['name']) {{ 'selected' }} @endif>{{$category['name']}}</option>
															@endforeach
														  </select>
														</div>
														<div class="form-group pb-50">
														  <label for="email-id-vertical">{{ __('Product Price') }} *</label>
														  <div class="nopadding input-group">
															  <span class="input-group-text" style="border-top-right-radius:0rem;border-bottom-right-radius:0rem;color: #828D99;">RM</span>
															  <input step=".01" min="0.00" type="number" name="price" id="price" class="form-control" style="color: #828D99;" placeholder="0.00" required data-validation-required-message="{{ __('This Product Price field is required') }}">
														  </div>
														</div>
														<div class="form-group pb-50">
															<label for="email-id-vertical">{{ __('Product Cost') }} *</label>
															<div class="nopadding input-group">
															<span class="input-group-text" style="border-top-right-radius:0rem;border-bottom-right-radius:0rem;color: #828D99;">RM</span>
															  <input step=".01" min="0.00" type="number" name="cost" id="cost" class="form-control" style="color: #828D99;" placeholder="0.00" required data-validation-required-message="{{ __('This Product Cost field is required') }}">
															</div>
														</div>
														<div class="form-group pb-50">
															<label for="first-name-vertical">{{ __('Taxes') }}</label>
															<select id="tax" name="tax" class="select2 form-control">
																<option value="N/A"  @if (old('tax') == "N/A") {{ 'selected' }} @endif>N/A</option>
																@foreach($taxes as $tax)
																	<option value="{{$tax['tax_name']}}"  @if (old('tax') == $tax['tax_name']) {{ 'selected' }} @endif>{{$tax['tax_name']}}</option>
																@endforeach
															</select>
														</div>
														<div class="form-group pb-50">
															<div class="controls checkbox">
																<input type="checkbox" class="checkbox-input" id="price_includes_tax" name="price_includes_tax">
																<label for="price_includes_tax">{{ __('Price includes tax') }}</label>
															</div>
														</div>
														<div class="form-group pb-50">
															<label for="first-name-vertical">{{ __('Stock Level') }}</label>
															<input name="stock_level" id="stock_level" type="number" class="touchspin" style="color:#828D99;" value="0">
														</div>
														<div class="form-group">
															<fieldset class="form-group">
																<label for="email-id-vertical">{{ __('Notes') }} </label>
																<textarea name="notes" id="notes" class="form-control" rows="3" placeholder="{{ __('Notes') }}"></textarea>
															</fieldset>
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
											  <h4>{{ __('You don`t have any products') }} ...</h4>
										  @endif
										  
										</section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- account setting page ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dropzone.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
@endsection

@section('page-scripts')
<script>
	var tab = "{{ session()->get( 'tab' ) }}";
	var country = "{{ $user->country }}";
	var currency = "{{ $user->currency }}";
	var languages = "{{ $user->languages }}";
	var dob = "{{ $user->dob }}";
	
	$("#dob").val(dob);
</script>

<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{asset('js/scripts/pages/app-email.js')}}"></script>
<script src="{{asset('js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/forms/number-input.js')}}"></script>

<script src="{{asset('js/scripts/pages/page-customers.js')}}"></script>


@endsection

<script>
	function edit(id, name, item_code, serial_number, category, price, cost, tax, price_includes_tax, stock_level, notes) {
		$('#item_code').val(item_code.trim());
		$('#product_name').val(name.trim());
		$('#serial_number').val(serial_number.trim());
		$("#product_category").val(category).change();
		$("#price").val(price);
		$("#cost").val(cost);
		$("#tax").val(tax).change();
		$("#stock_level").val(stock_level);
		$("#notes").val(notes);
		
		if(price_includes_tax){
			$("#price_includes_tax").prop('checked', true);
		} else {
			$("#price_includes_tax").prop('checked', false);
		}
		
		
		$('#editForm').attr('action', "products/"+id);
	}
	
	function check_deleted(productId) {
		$('#deleteForm').attr('action', "products/"+productId);
	}

	function check_selected() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		if (items === undefined || items.length == 0) {
			$("#deleteAllContent").text("{{ __('Please select the product you want to delete') }}.");
			$("#deleteAllFooter").css('visibility', 'hidden');
			$('#deleteAll').modal('show');
		} else {
			$("#deleteAllContent").text("{{ __('Are you sure you want to delete selected products') }}?");
			$("#deleteAllFooter").css('visibility', 'visible');
			$('#deleteAll').modal('show');
		}
	}

	function delete_products() {
		let items = [];
		var id = 0;
		$("input:checkbox[class=dt-checkboxes]:checked").each(function () {
			id = $(this).closest('.dt-checkboxes-cell').attr('data-id');
			items.push(id);
		});
		
		jQuery.ajax({
				url: '{{ route("products.delete") }}',
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