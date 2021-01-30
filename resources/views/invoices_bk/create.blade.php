@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Invoice Add')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

@section('content')
    <!-- app invoice View Page -->
<section class="invoice-edit-wrapper">
  <div class="row">
    <!-- invoice view page -->
    <div class="col-xl-9 col-md-8 col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body pb-0 mx-25">
            <!-- header section -->
            <div class="row mx-0">
              <div class="col-xl-4 col-md-12 d-flex align-items-center pl-0">
                <h6 class="invoice-number mr-75">{{ __('Invoice No') }}</h6>
				@if($invoices)
					<input id="invoice_no" name="invoice_no" type="text" class="form-control pt-25 w-50" placeholder="#000" value="{{ $invoices->invoice_id }}">
				@else
				    <input id="invoice_no" name="invoice_no" type="text" class="form-control pt-25 w-50" placeholder="#000" value="{{ $invoice_id }}">
			    @endif
              </div>
              <div class="col-xl-8 col-md-12 px-0 pt-xl-0 pt-1">
                <div class="invoice-date-picker d-flex align-items-center justify-content-xl-end flex-wrap">
                  <div class="d-flex align-items-center">
                    <small class="text-muted mr-75">{{ __('Date Issue') }}: </small>
                    <fieldset class="d-flex ">
                      <input id="date_issue" name="date_issue" type="text" class="form-control pickadate mr-2 mb-50 mb-sm-0" placeholder="{{ __('Select Date') }}" value="{{ $date_issue }}">
                    </fieldset>
                  </div>
                  <div class="d-flex align-items-center">
                    <small class="text-muted mr-75">{{ __('Date Due') }}: </small>
                    <fieldset class="d-flex justify-content-end">
                      <input id="date_due" name="date_due" type="text" class="form-control pickadate mb-50 mb-sm-0" placeholder="{{ __('Select Date') }}" value="{{ $date_due }}">
                    </fieldset>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <!-- logo and title -->
            <div class="row my-2 py-50">
              <div class="col-sm-6 col-12 order-2 order-sm-1">
                <h4 class="text-primary">{{ __('Invoice') }}</h4>
				<h6 class="invoice-to">{{ __('Customer') }} *</h6>
				<select id="customer" name="customer" class="select2 form-control" onchange="get_address()" required data-validation-required-message="{{ __('This Customer field is required') }}">
					<option value=""></option>
					@foreach($customers as $customer)
						<option value="{{$customer['id']}}"  @if (old('customer') == $customer['id']) {{ 'selected' }} @endif>{{$customer['name']}}</option>
					@endforeach
				</select>
				<span id="customer_error" class="form-group error"></span>
              </div>
              <div class="col-sm-6 col-12 order-1 order-sm-1 d-flex justify-content-end">
                <img src="{{asset('images/pages/workted-logo.png')}}" alt="logo" height="46" width="164">
              </div>
            </div>
            <hr>
            <!-- invoice address and contact -->
            <div class="row invoice-info">
              <div class="col-lg-6 col-md-12 mt-25">
                <h6 class="invoice-to">{{ __('Bill To') }}</h6>
                <fieldset class="invoice-address form-group">
					<input type="text" class="form-control" id="address" name="address" placeholder="{{ __('Address') }}">
                </fieldset>
                <fieldset class="invoice-address form-group">
                  <input type="text" class="form-control" id="city" name="city" placeholder="{{ __('City') }}">
                </fieldset>
                <fieldset class="invoice-address form-group">
                  <input type="text" class="form-control" id="state" name="state" placeholder="{{ __('State') }}">
                </fieldset>
                <fieldset class="invoice-address form-group">
                  <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="{{ __('Zipcode') }}">
                </fieldset>
				<fieldset class="invoice-address form-group">
                  <select class="form-control" id="countrySelect" name="country" style="color:#475F7B;padding-left:0.5rem;">
				  </select>
                </fieldset>
              </div>
            </div>
            <hr>
          </div>
          <div class="card-body pt-50">
            <!-- product details table-->
            <div class="invoice-product-details ">
              <form class="form invoice-item-repeater">
                <div data-repeater-list="group-a">
                  <div data-repeater-item>
                    <div class="row mb-50">
                      <div class="col-3 col-md-4 invoice-item-title">{{ __('Item') }}</div>
                      <div class="col-3 invoice-item-title">{{ __('Qty') }}</div>
                      <div class="col-3 invoice-item-title">{{ __('Tax') }}</div>
                      <div class="col-3 col-md-2 invoice-item-title">{{ __('Price') }}</div>
                    </div>
                    <div class="invoice-item d-flex border rounded mb-1">
                      <div class="invoice-item-filed row pt-1 px-1">
                        <div class="col-12 col-md-4 form-group">
							<select id="product" name="product" class="select2 form-control" onchange="productChange(this)">
								<option data-price="0.00" value=""></option>
								@foreach($products as $product)
									<option data-price="{{$product['price']}}" value="{{$product['id']}}"  @if (old('product') == $product['id']) {{ 'selected' }} @endif>{{$product['name']}}</option>
								@endforeach
							</select>
							<span class="form-group item_error error"></span>
                        </div>
                        <div class="col-md-3 col-12 form-group">
                          <input id="quantity" name="quantity" type="text" class="form-control" placeholder="0" onchange="quantityChange(this)">
                        </div>
                        <div class="col-md-3 col-12 form-group">
							<select id="tax" name="tax" class="select2 form-control tax-select" onchange="taxChange(this)">
								<option data-value="0.00" value=""></option>
								@foreach($taxes as $tax)
									<option data-value="{{$tax['tax_amount']}}" value="{{$tax['id']}}"  @if (old('tax') == $tax['id']) {{ 'selected' }} @endif>{{$tax['tax_name']}}</option>
								@endforeach
							</select>
                        </div>
                        <div class="col-md-2 col-12 form-group">
                          <strong class="text-primary align-middle price">0.00</strong>
						  <input type="hidden" id="price" name="price" value="0.00">
                        </div>
                        <div class="col-md-4 col-12 form-group">
                        </div>
                        <div class="col-md-8 col-12 form-group">
                          <span>{{ __('Discount') }}: </span><span class="discount-value mr-1">0%</span>
                          <span class="mr-1 tax1">0%</span>
                          <span class="mr-1 tax2">0%</span>
                        </div>
                      </div>
                      <div class="invoice-icon d-flex flex-column justify-content-between border-left p-25">
                        <span class="cursor-pointer repeater-delete" data-repeater-delete data->
                          <i class="bx bx-x"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col p-0">
                    <button class="btn btn-light-primary btn-sm" data-repeater-create type="button">
                      <i class="bx bx-plus"></i>
                      <span class="invoice-repeat-btn">{{ __('Add Item') }}</span>
                    </button>
					<span id="no_item_error" class="form-group error"></span>
                  </div>
                </div>
              </form>
            </div>
            <!-- invoice subtotal -->
            <hr>
            <div class="invoice-subtotal pt-50">
              <div class="row">
                <div class="col-md-5 col-12">
                  <div class="form-group">
                    <textarea class="form-control" id="payment_term" name="payment_term" rows="3" maxlength="100" placeholder="{{ __('Add Payment Terms') }}"></textarea>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" id="client_note" name="client_note" rows="3" maxlength="100" placeholder="{{ __('Add client Note') }}"></textarea>
                  </div>
                </div>
                <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                  <ul id="summary" class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                      <span class="invoice-subtotal-title">{{ __('Subtotal') }}</span>
                      <h6 class="invoice-subtotal-value mb-0" id="subtotal">  0.00</h6>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                      <span class="invoice-subtotal-title">{{ __('Discount') }}</span>
                      <h6 class="invoice-subtotal-value mb-0">- 0.00</h6>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-0 pb-0 tax">
                      <span class="invoice-subtotal-title" id="taxlabel0">{{ __('Tax') }}1(<span id="percentage0">0.00</span>%)</span>
                      <h6 class="invoice-subtotal-value mb-0"><span class="totaltax" id="totaltax0">0.00</span></h6>
                    </li>
                    <li class="list-group-item py-0 border-0 mt-25">
                      <hr>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-0 py-0">
                      <span class="invoice-subtotal-title">{{ __('Invoice Total') }}</span>
                      <h6 class="invoice-subtotal-value mb-0" id="invoicetotal">  0.00</h6>
                    </li>
                    <li class="list-group-item border-0 pb-0">
                      <button class="btn btn-primary btn-block subtotal-preview-btn" style="margin-top:20px;" onclick="submit()">{{ __('Save') }}</button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset  ('js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection

<script>
	function get_address() {
		var customerid = $("#customer").val();
		jQuery.ajax({
			url: '{{ route("invoices.address") }}',
			method: 'post',
			cache: false,
			data: {
				customerid: customerid,
				"_token": "{{ csrf_token() }}"
				}
		}).then(function(response) {
			console.log(response);
			$('#address').val(response[0].address);
			$('#city').val(response[0].city);
			$('#state').val(response[0].state);
			$('#zipcode').val(response[0].zipcode);
			$('#countrySelect').val(response[0].country);
		}, function(error) {
			console.log(error);
		});
		
		$( "#customer_error" ).html( '' );
	}
	
	function productChange(obj) {
		var subtotal = 0;
		var taxtotal = 0
		var invoicetotal = 0;
		var price = $(obj).find(':selected').data('price');
		var tax_name = $(obj).parent().next().next().find('select').attr("name");
		var number = tax_name.charAt(8); 
		var totaltax = "#totaltax" + number;
		var percentage = "#percentage" + number;
		
		$(percentage).text('0.00');
		$(totaltax).text('0.00');

		$(obj).parent().next().next().find('select').val("");
		
		$(obj).parent().next().find('input').val(1);
		$(obj).parent().next().next().next().find('strong').text(price.toFixed(2));
		
		$('.price').each(function() {
			subtotal += parseFloat($(this).text());
		});
		
		$("#subtotal").text(subtotal.toFixed(2));
		
		$('.tax').each(function() {
			taxtotal += parseFloat($(this).find(".totaltax").text());
		});
		
		invoicetotal = subtotal + taxtotal;
		$("#invoicetotal").text(invoicetotal.toFixed(2));
		
		$( ".item_error" ).html( '' );
	}
	
	function quantityChange(obj) {
		var subtotal = 0;
		var taxtotal = 0
		var invoicetotal = 0;
		var quantity = $(obj).val();
		var price = $(obj).parent().prev().find(':selected').data('price');
		var tax_name = $(obj).parent().next().find('select').attr("name");
		var number = tax_name.charAt(8); 
		var totaltax = "#totaltax" + number;
		var percentage = "#percentage" + number;
		var tax_amount = parseFloat($(percentage).text());
		var tax_value = tax_amount / 100;
		var product_tax = 0;
		
		if(price != "0.00"){
			price = price * quantity;
			product_tax = price * tax_value;
			
			$(obj).parent().next().next().find('strong').text(price.toFixed(2));
			$(totaltax).text(product_tax.toFixed(2));
			
			$('.price').each(function() {
				subtotal += parseFloat($(this).text());
			});
			
			$("#subtotal").text(subtotal.toFixed(2));
			
			$('.tax').each(function() {
				taxtotal += parseFloat($(this).find(".totaltax").text());
			});
		
			invoicetotal = subtotal + taxtotal;
			$("#invoicetotal").text(invoicetotal.toFixed(2));
		}
	}
	
	function addItem(){
		var tax_amount = 0; 
		var tax_value = 0; 
		var price = 0;
		var number = 1;
		var index = 0;
		var tax_content = '';
		var product_tax = 0;

		$('.tax').each(function(index){
			$(this).remove();
		});
		
		$('.tax-select').each(function() {
			tax_amount = parseFloat($(this).find(':selected').data('value'));
			price = $(this).parent().next().find('strong').text();
			tax_value = tax_amount / 100;
			product_tax = price * tax_value;
			tax_content += '<li class="list-group-item d-flex justify-content-between border-0 pb-0 tax">' +
                      '<span class="invoice-subtotal-title">{{ __("Tax") }}'+number+'(<span id="percentage'+index+'">'+tax_amount.toFixed(2)+'</span>%)</span>' +
                      '<h6 class="invoice-subtotal-value mb-0"><span class="totaltax" id="totaltax'+index+'">'+product_tax.toFixed(2)+'</span></h6>' +
                    '</li>';
			number += 1;
			index += 1;
		});
		
		/*tax_content += '<li class="list-group-item d-flex justify-content-between border-0 pb-0 tax">' +
                      '<span class="invoice-subtotal-title">{{ __("Tax") }}'+number+'(<span id="percentage'+index+'">0.00</span>%)</span>' +
                      '<h6 class="invoice-subtotal-value mb-0"><span class="totaltax" id="totaltax'+index+'">0.00</span></h6>' +
                    '</li>';**/
			
		$("#summary li:nth-child(2)").after(tax_content);
		$( "#no_item_error" ).html('');
	}
	
	function taxChange(obj) {
		var invoicetotal = 0;
		var taxtotal = 0
		var tax_amount = $(obj).find(':selected').data('value');
		var tax = tax_amount / 100;
		var tax_name = $(obj).attr("name");
		var number = tax_name.charAt(8); 
		var price = $(obj).parent().next().find('strong').text();
		var product_tax = price * tax;
		var tax_type = $(obj).find(':selected').text();
		
		console.log(tax_type);
		
		var totaltax = "#totaltax" + number;
		$(totaltax).text(product_tax.toFixed(2));
		
		var percentage = "#percentage" + number;
		$(percentage).text(tax_amount);
		
		var subtotal = parseFloat($("#subtotal").text());
		
		$('.tax').each(function() {
			taxtotal += parseFloat($(this).find(".totaltax").text());
		});
		
		var invoicetotal = parseFloat(subtotal) + parseFloat(taxtotal);
		$("#invoicetotal").text(invoicetotal.toFixed(2));
	}
	
	function submit() {
		var invoice_id = $("#invoice_no").val();
		var date_issue = $("#date_issue").val();
		var date_due = $("#date_due").val();
		var customer_id = $("#customer").val();
		var customer_name = $( "#customer option:selected" ).text();
		
		var address = $("#address").val();
		var city = $("#city").val();
		var state = $("#state").val();
		var zipcode = $("#zipcode").val();
		var country = $("#countrySelect").val();
		
		var payment_term = $("#payment_term").val();
		var client_note = $("#client_note").val();
		
		var subtotal = $("#subtotal").text();
		var invoicetotal = $("#invoicetotal").text();
		
		var items = [];
		var product_id, product_name, quantity, tax_id, tax_name, price;
		
		var tax_name = "";
		var number = ""; 
		var totaltax = "";
		var totalpercentage = "";
		var tax_percentage = 0.00;
		var tax_amount = 0.00;
		var item_count = 0;
		var item_validate = false;
		
		if(!customer_id){
			$( "#customer_error" ).html( '<div class="help-block"><ul role="alert"><li>This Customer field is required</li></ul></div>' );
			return;
		} else {
			$( "#customer_error" ).html( '' );
		}

		$('.invoice-item-filed').each(function() {
			tax_name = $(this).find('#product').attr("name");
			number = tax_name.charAt(8); 
			totaltax = "#totaltax" + number;
			totalpercentage = "#percentage" + number;
			tax_amount = parseFloat($(totaltax).text()).toFixed(2);
			tax_percentage = parseFloat($(totalpercentage).text()).toFixed(2);
			
			if(item_count == 0){
				if($(this).find('#product').val() == ""){
					$( ".item_error" ).html( '<div class="help-block"><ul role="alert"><li>This item field is required</li></ul></div>' );
					item_validate = false;
					return;
				} else {
					$( ".item_error" ).html( '' );
					obj = {};
					obj['product_id'] = $(this).find('#product').val();
					obj['product_name'] = $(this).find('#product option:selected').text();
					obj['quantity'] = $(this).find('#quantity').val();
					obj['tax_id'] = $(this).find('#tax').val();
					obj['tax_name'] = $(this).find('#tax option:selected').text();
					obj['price'] = $(this).find('.price').text();
					obj['tax_percentage'] = tax_percentage;
					obj['tax_amount'] = tax_amount;
					items.push(obj);
					item_validate = true;
				}
			} else {
				obj = {};
				obj['product_id'] = $(this).find('#product').val();
				obj['product_name'] = $(this).find('#product option:selected').text();
				obj['quantity'] = $(this).find('#quantity').val();
				obj['tax_id'] = $(this).find('#tax').val();
				obj['tax_name'] = $(this).find('#tax option:selected').text();
				obj['price'] = $(this).find('.price').text();
				obj['tax_percentage'] = tax_percentage;
				obj['tax_amount'] = tax_amount;
				items.push(obj);
				item_validate = true;
			}
			item_count += 1;
		});

		if ($(".invoice-item-filed").length == 0) {
			$( "#no_item_error" ).html( '<div class="help-block"><ul role="alert"><li>Item is required</li></ul></div>' );
		} else {
			$( "#no_item_error" ).html('');
		}
		
		if(item_validate){
			jQuery.ajax({
					url: '{{ route("invoices.store") }}',
					method: 'post',
					cache: false,
					data: {
						items: items,
						invoice_id: invoice_id,
						date_issue: date_issue,
						date_due: date_due,
						customer_id: customer_id,
						customer_name: customer_name,
						address: address,
						city: city,
						state: state,
						zipcode: zipcode,
						country: country,
						payment_term: payment_term,
						client_note: client_note,
						subtotal: subtotal,
						invoicetotal: invoicetotal,
						"_token": "{{ csrf_token() }}"
						}
			}).then(function(response) {
				console.log(response);
				window.location.href = '{{ route("invoices.index") }}';
			}, function(error) {
				console.log(error);
			});
		}
	}
	
	function item_delete() {
		var tax_amount = 0; 
		var tax_value = 0; 
		var price = 0;
		var number = 1;
		var index = 0;
		var tax_content = '';
		var product_tax = 0;
		var subtotal = 0;
		var invoicetotal = 0;
		var taxtotal = 0
		
		$('.price').each(function() {
			subtotal += parseFloat($(this).text());
		});
		
		$("#subtotal").text(subtotal.toFixed(2));
	
		$('.tax').each(function(index){
			$(this).remove();
		});
		
		$('.tax-select').each(function() {
			tax_amount = parseFloat($(this).find(':selected').data('value'));
			price = $(this).parent().next().find('strong').text();
			tax_value = tax_amount / 100;
			product_tax = price * tax_value;
			tax_content += '<li class="list-group-item d-flex justify-content-between border-0 pb-0 tax">' +
                      '<span class="invoice-subtotal-title">{{ __("Tax") }}'+number+'(<span id="percentage'+index+'">'+tax_amount.toFixed(2)+'</span>%)</span>' +
                      '<h6 class="invoice-subtotal-value mb-0"><span class="totaltax" id="totaltax'+index+'">'+product_tax.toFixed(2)+'</span></h6>' +
                    '</li>';
			number += 1;
			index += 1;
		});
			
		$("#summary li:nth-child(2)").after(tax_content);
		
		$('.tax').each(function() {
			taxtotal += parseFloat($(this).find(".totaltax").text());
		});
		
		var invoicetotal = parseFloat(subtotal) + parseFloat(taxtotal);
		$("#invoicetotal").text(invoicetotal.toFixed(2));
	}
</script>