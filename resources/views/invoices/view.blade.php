@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Invoice')
{{-- styles --}}
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
@endsection
<style>
	@media print {
	    .invoice-action{
			display: none;
		}
		body {
			margin-left: 100;
			color: #000;
			background-color: #fff;
		}
	}
	@page :left {
		margin: 0.5cm;
	}
</style>
@section('content')
<div class="app-content-overlay"></div>
    <!-- app invoice View Page -->
<section class="invoice-view-wrapper">
  <div class="row">
    <!-- invoice view page -->
    <div class="col-xl-9 col-md-8 col-12">
      <div class="card invoice-print-area">
        <div class="card-content">
          <div class="card-body pb-0 mx-25">
            <!-- header section -->
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <span class="invoice-number mr-50">{{ __('Invoice No') }}</span>
                <span>{{ str_pad($invoices->invoice_id,4,'0',STR_PAD_LEFT) }}</span>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="d-flex align-items-center justify-content-xl-end flex-wrap">
                  <div class="mr-3">
                    <small class="text-muted">{{ __('Date Issue') }}:</small>
                    <span>{{ date('d-m-Y', strtotime($invoices->date_issue))}}</span>
                  </div>
                  <div>
                    <small class="text-muted">{{ __('Date Due') }}:</small>
                    <span>{{ date('d-m-Y', strtotime($invoices->date_due))}}</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- logo and title -->
            <div class="row my-3">
              <div class="col-6">
                <h4 class="text-primary">{{ __('Invoice') }}</h4>
                <span></span>
              </div>
              <div class="col-6 d-flex justify-content-end">
                <img src="{{asset('images/pages/workted-logo.png')}}" alt="logo" height="46" width="164">
              </div>
            </div>
            <hr>
            <!-- invoice address and contact -->
            <div class="row invoice-info">
              <div class="col-6 mt-1">
                <h6 class="invoice-from">{{ __('Bill From') }}</h6>
                <div class="mb-1">
                  <span>Sorable Sdn. Bhd. (1261555-A)</span>
                </div>
                <div class="mb-1">
                  <span>29-07, Jalan Riong</span>
                </div>
                <div class="mb-1">
                  <span>59100</span>
                </div>
				<div class="mb-1">
                  <span>Kuala Lumpur</span>
                </div>
				<div class="mb-1">
                  <span>Malaysia</span>
                </div>
              </div>
              <div class="col-6 mt-1">
                <h6 class="invoice-to">{{ __('Bill To') }}</h6>
                <div class="mb-1">
                  <span>{{ $invoices->customer_name }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $invoices->address }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $invoices->city }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $invoices->zipcode }}</span>
                </div>
				<div class="mb-1">
                  <span>{{ $invoices->state }}</span>
                </div>
				<div class="mb-1">
                  <span>{{ $invoices->country }}</span>
                </div>
              </div>
            </div>
            <hr>
          </div>
          <!-- product details table-->
          <div class="invoice-product-details table-responsive mx-md-25">
            <table class="table table-borderless mb-0">
              <thead>
                <tr class="border-0">
                  <th scope="col">{{ __('Item') }}</th>
				  <th scope="col">{{ __('Qty') }}</th>
                  <th scope="col">{{ __('Tax') }}</th>
                  <th scope="col" class="text-right">{{ __('Price') }}</th>
                </tr>
              </thead>
              <tbody>
				@foreach ($invoiceItems as $item)
                <tr>
                  <td>{{ $item->product_name }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td>{{ $item->tax_name }}</td>
                  <td class="text-primary text-right font-weight-bold">{{ number_format($item->price, 2) }}</td>
                </tr>
				@endforeach
              </tbody>
            </table>
          </div>

          <!-- invoice subtotal -->
          <div class="card-body pt-0 mx-25">
            <hr>
            <div class="row">
              <div class="col-4 col-sm-6 mt-75">
                <p>{{ __('Thanks for your business.') }}</p>
              </div>
              <div class="col-8 col-sm-6 d-flex justify-content-end mt-75">
                <div class="invoice-subtotal">
                  <div class="invoice-calc d-flex justify-content-between">
                    <span class="invoice-title">{{ __('Subtotal') }}</span>
                    <span class="invoice-value">{{ number_format($invoices->subtotal, 2) }}</span>
                  </div>
                  <div class="invoice-calc d-flex justify-content-between">
                    <span class="invoice-title">{{ __('Discount') }}</span>
                    <span class="invoice-value">- 0.00</span>
                  </div>
				  @foreach($InvoiceTaxes as $key=>$item)
					  <div class="invoice-calc d-flex justify-content-between">
						<span class="invoice-title">{{ $item->tax_name }}(<span id="percentage{{$key}}">{{ number_format($item->tax_percentage, 2) }}</span>%)</span>
						<span class="invoice-value">{{ number_format($item->tax_amount, 2) }}</span>
					  </div>
				  @endforeach
                  <hr>
                  <div class="invoice-calc d-flex justify-content-between">
                    <span class="invoice-title">{{ __('Invoice Total') }}</span>
                    <span class="invoice-value">{{ number_format($invoices->invoice_total, 2) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- invoice action  -->
    <div class="col-xl-3 col-md-4 col-12 invoice-action">
      <div class="card invoice-action-wrapper shadow-none border">
        <div class="card-body">
          <div class="invoice-action-btn">
            <button class="btn btn-primary btn-block invoice-send-btn">
              <i class="bx bx-send"></i>
              <span>{{ __('Send Invoice') }}</span>
            </button>
          </div>
          <div class="invoice-action-btn">
            <button class="btn btn-light-primary btn-block invoice-print">
              <span>{{ __('Print') }}</span>
            </button>
          </div>
          <div class="invoice-action-btn">
            <a href="{{asset('app-invoice-edit')}}" class="btn btn-light-primary btn-block">
              <span>{{ __('Edit Invoice') }}</span>
            </a>
          </div>
		  <div class="invoice-action-btn mb-1">
            <button class="btn btn-light-primary btn-block" onclick="download({{$invoices->id}})">
              <span>{{ __('Download Invoice') }}</span>
            </button>
          </div>
          <div class="invoice-action-btn">
            <button class="btn btn-success btn-block compose-btn">
              <i class='bx bx-dollar'></i>
			  @if($invoices->status != 'paid')
					<span>{{ __('Add Payment') }}</span>
			  @else
					<span>{{ __('View Payment') }}</span>
			  @endif
            </button>
          </div>
		  
        </div>
      </div>
    </div>
  </div>
  <!-- Add payment right area -->
	<div class="email-sidebar ps">
		<div class="card shadow-none quill-wrapper p-0">
		  <div class="card-header">
			<h3 class="card-title" id="emailCompose">{{ __('Payment Information') }}</h3>
			<button type="button" class="close close-icon">
			  <i class="bx bx-x"></i>
			</button>
		  </div>
		  <!-- form start -->
		  <form id="editForm" method="post" action="{{ route('invoices.payment') }}" autocomplete="off" enctype="multipart/form-data">
			@csrf
			<div class="card-content">
			  <div class="card-body pt-0">
				<div class="form-group pb-50">
				  @if($invoices->status == 'unpaid')
					<label for="first-name-vertical">{{ __('Amount') }} *</label>
					<input type="text" id="amount" class="form-control" name="amount" placeholder="{{ __('Amount') }}" required data-validation-required-message="{{ __('This Amount Received field is required') }}" value="{{ number_format((float)$invoices->invoice_total, 2, '.', '') }}">
				  @elseif($invoices->status == 'partially paid')
				    <label for="first-name-vertical">{{ __('Amount') }} * ( {{ __('Paid') }}: {{ number_format((float)$sum, 2, '.', '') }} )</label> 
				    <input type="text" id="amount" class="form-control" name="amount" placeholder="{{ __('Amount') }}" required data-validation-required-message="{{ __('This Amount Received field is required') }}" value="{{ number_format((float)$invoices->invoice_total - (float)$sum, 2, '.', '') }}">
				  @else
					<label for="first-name-vertical">{{ __('Amount') }} *</label>
					<input type="text" id="amount" class="form-control" name="amount" placeholder="{{ __('Amount') }}" disabled value="{{ number_format((float)$sum, 2, '.', '') }}">
			      @endif
				</div>
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Payment Date') }} *</label>
				  @if($invoices->status == 'unpaid' || $invoices->status == 'partially paid')
					<input id="payment_date" name="payment_date" type="text" class="form-control pickadate mr-2 mb-50 mb-sm-0" placeholder="{{ __('Select Date') }}" required data-validation-required-message="{{ __('This Payment Date field is required') }}" value="{{ $payment_date }}">
			      @else
					<input id="payment_date" name="payment_date" type="text" class="form-control pickadate mr-2 mb-50 mb-sm-0" placeholder="{{ __('Select Date') }}" style="background-color:#F2F4F4;" disabled value="{{ date('m/d/Y', strtotime($InvoicePayments->payment_date)) }}">
			      @endif
				</div>
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Payment Mode') }} *</label>
				  @if($invoices->status != 'paid')
					<select id="payment_mode" name="payment_mode" class="select2 form-control" onchange="payment_mode_change()" required data-validation-required-message="{{ __('This Payment Mode field is required') }}" >
						<option value=""></option>
						@foreach($payment_modes as $payment_mode)
							<option value="{{$payment_mode['id']}}"  @if (old('payment_mode') == $payment_mode['id']) {{ 'selected' }} @endif>{{$payment_mode['name']}}</option>
						@endforeach
					</select>
			      @else
					<select id="payment_mode" name="payment_mode" class="select2 form-control" onchange="payment_mode_change()" disabled>
						<option value=""></option>
						@foreach($payment_modes as $payment_mode)
							<option value="{{$payment_mode['id']}}"  @if ($InvoicePayments->payment_mode_id == $payment_mode['id']) {{ 'selected' }} @endif>{{$payment_mode['name']}}</option>
						@endforeach
					</select>
			      @endif
				</div>
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Transaction ID') }}</label>
				  @if($invoices->status != 'paid')
					<input type="text" id="transaction_id" class="form-control" name="transaction_id" placeholder="{{ __('Transaction ID') }}" value="">
			      @else
					<input type="text" id="transaction_id" class="form-control" name="transaction_id" placeholder="{{ __('Transaction ID') }}" disabled value="{{$InvoicePayments->transaction_id}}">
			      @endif
				</div>
				<div class="form-group pb-50">
				  <label for="first-name-vertical">{{ __('Leave a note') }}</label>
				  @if($invoices->status != 'paid')
					<textarea name="note" id="note" class="form-control" rows="3" maxlength="300" placeholder="{{ __('Leave a note') }}"></textarea>
			      @else
					<textarea name="note" id="note" class="form-control" rows="3" maxlength="300" disabled placeholder="{{ __('Leave a note') }}">{{$InvoicePayments->note}}</textarea>
			      @endif
				</div>
				<div class="form-group pb-50">
					<div class="controls checkbox">
						@if($invoices->status == 'unpaid')
							<input type="checkbox" class="checkbox-input" id="do_not_send_invoice" name="do_not_send_invoice">
						@elseif($invoices->status == 'partially paid')
							<input type="checkbox" class="checkbox-input" id="do_not_send_invoice" name="do_not_send_invoice" @if ($InvoicePayments->do_not_send_invoice) {{ 'checked' }} @endif>
					    @else
							<input type="checkbox" class="checkbox-input" id="do_not_send_invoice" name="do_not_send_invoice" disabled  @if ($InvoicePayments->do_not_send_invoice) {{ 'checked' }} @endif>
					    @endif
						<label for="do_not_send_invoice">{{ __('Do not send invoice payment to customer') }}</label>
					</div>
				</div>
				<input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoices->id }}">
				<input type="hidden" id="invoice_amount" name="invoice_amount" value="{{ $invoices->invoice_total }}">
				<input type="hidden" id="payment_mode_name" name="payment_mode_name" value="">
				<input type="hidden" id="page" name="page" value="view-invoice">
			  </div>
			</div>
			@if($invoices->status != 'paid')
			<div class="card-footer d-flex justify-content-end pt-0">
			  <button type="reset" class="btn btn-light-secondary cancel-btn mr-1">
				<i class='bx bx-x mr-25'></i>
				<span class="d-sm-inline d-none">{{ __('Cancel') }}</span>
			  </button>
			  <button type="submit" class="btn-send btn btn-primary">
				<i class='bx bx-send mr-25'></i> <span class="d-sm-inline d-none">{{ __('Save') }}</span>
			  </button>
			</div>
			@endif
		  </form>
		  <!-- form start end-->
		</div>
	</div>
</section>
@endsection
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{asset('js/scripts/pages/app-email.js')}}"></script>
@endsection

<script>
	function payment_mode_change() {
		var payment_mode_name = $( "#payment_mode option:selected" ).text();
		$("#payment_mode_name").val(payment_mode_name);
	}
	
	/*function download(invoice_id) {
		window.location.href = "{{ route('invoices.download') }}";
	}*/
	
	function download(invoice_id) {
		$.ajax({
			type: 'POST',
			//url: 'printpdf',
			url: '{{ route("invoices.download") }}',
			data: { 
				invoice_id : invoice_id,
				"_token": "{{ csrf_token() }}"
			},
			xhrFields: {
				responseType: 'blob'
			},
			success: function (response, status, xhr) {
				var filename = "";                   
				var disposition = xhr.getResponseHeader('Content-Disposition');

				if (disposition) {
					var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
					var matches = filenameRegex.exec(disposition);
					if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
				} 
				
				var linkelem = document.createElement('a');
				
				try {
					var blob = new Blob([response], { type: 'application/octet-stream' });
					if (typeof window.navigator.msSaveBlob !== 'undefined') {
						//   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
						window.navigator.msSaveBlob(blob, filename);
					} else {
						var URL = window.URL || window.webkitURL;
						var downloadUrl = URL.createObjectURL(blob);

						if (filename) { 
							// use HTML5 a[download] attribute to specify filename
							var a = document.createElement("a");

							// safari doesn't support this yet
							if (typeof a.download === 'undefined') {
								window.location = downloadUrl;
							} else {
								a.href = downloadUrl;
								a.download = filename;
								document.body.appendChild(a);
								a.target = "_blank";
								a.click();
							}
						} else {
							window.location = downloadUrl;
						}
					}
				} catch (ex) {
					console.log(ex);
				} 
			}
		});
	}
</script>
