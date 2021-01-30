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
                                <i class="bx bx-user"></i>
                                <span>{{ __('Profile') }}</span>
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
										<form method="post" action="{{ route('customers.updateGeneral') }}" class="form form-vertical" novalidate>
											@csrf
										  <div class="form-body">
											<div class="row">
											  <div class="col-6">
												<div class="form-group">
													<div class="controls">
													  <label for="first-name-vertical">{{ __('Customer/Company Name') }} *</label>
													  <input type="text" id="name" class="form-control" name="name" value="{{ $customer->name }}" placeholder="{{ __('Customer/Company Name') }}" required data-validation-required-message="{{ __('This Name field is required') }}">
													</div>
												</div>
												<div class="form-group">
													<div class="controls">
														<label for="email-id-vertical">{{ __('City') }}</label>
														<input type="text" class="form-control" name="city" value="{{ $customer->city }}" placeholder="{{ __('City') }}">
													</div>
												</div>
												<div class="form-group">
													<div class="controls">
														<label for="email-id-vertical">{{ __('Zipcode') }}</label>
														<input type="text" class="form-control" name="zipcode" value="{{ $customer->zipcode }}" placeholder="{{ __('Zipcode') }}">
													</div>
												</div>
												<div class="form-group">
													<div class="controls">
														<label for="email-id-vertical">{{ __('Phone') }}</label>
														<input type="text" class="form-control" name="phone" value="{{ $customer->phone }}" placeholder="{{ __('Phone') }}">
													</div>
												</div>
												<div class="form-group">
													<div class="controls">
														<label for="email-id-vertical">{{ __('Language') }}</label>
														<select class="form-control" id="languageselect2" name="languages[]" multiple="multiple">
														</select>
													</div>
												</div>
											  </div>
											  <div class="col-6">
												<div class="form-group">
													<div class="controls">
														<label for="email-id-vertical">{{ __('Address') }}</label>
														<input type="text" class="form-control" name="address" value="{{ $customer->address }}" placeholder="{{ __('Address') }}">
													</div>
												</div>
												<div class="form-group">
													<div class="controls">
														<label for="email-id-vertical">{{ __('State') }}</label>
														<input type="text" class="form-control" name="state" value="{{ $customer->state }}" placeholder="{{ __('State') }}">
													</div>
												</div>
												<div class="form-group">
													<div class="controls">
														<label for="email-id-vertical">{{ __('Country') }}</label>
														<select class="form-control" id="countrySelect" name="country">
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="controls">
														<label for="email-id-vertical">{{ __('Currency') }}</label>
														<select class="form-control" id="currencySelect" name="currency">
														</select>
													</div>
												</div>
											  </div>
											  <input type="hidden" id="id" name="id" value="{{ $customer->id }}">
											  <div class="col-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary mt-3 mr-1 mb-1">{{ __('Submit') }}</button>
												<button type="reset" class="btn btn-light-secondary mt-3 mb-1">{{ __('Reset') }}</button>
											  </div>
											</div>
										  </div>
										</form>
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
	var country = "{{ $customer->country }}";
	var currency = "{{ $customer->currency }}";
	var languages = "{{ $customer->languages }}";
	var dob = "";
	
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