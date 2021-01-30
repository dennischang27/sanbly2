@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Invoice')
{{-- styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection
@section('content')
    <!-- app invoice View Page -->
<br/>
<div class="invoice-create-btn mb-1">
	<div class="row justify-content-md-center">
		<div class="col-xl-10 col-md-9 col-12">
			<a href="{{ route('billings.index') }}" class="btn btn-primary glow invoice-create" role="button" aria-pressed="true">{{ __('Back') }}</a>
			<button class="btn btn-light-primary invoice-print" style="float:right;"><span>{{ __('Print') }}</span></button>
		</div>
	</div>
</div>
<br/>
<section class="invoice-view-wrapper">
  <div class="row justify-content-md-center">
    <!-- invoice view page -->
    <div class="col-xl-10 col-md-9 col-12">
      <div class="card invoice-print-area">
        <div class="card-content">
          <div class="card-body pb-0 mx-25">
            <!-- header section -->
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <span class="invoice-number mr-50">{{ __('Invoice No') }}</span>
                <span>{{ $billings->id }}</span>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="d-flex align-items-center justify-content-xl-end flex-wrap">
                  <div>
                    <span class="text-muted">{{ __('Date') }}:</span>
                    <span>{{ $billings->created_at }}</span>
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
                <h6 class="invoice-from">{{ __('Vendor') }}</h6>
                <div class="mb-1">
                  <span style="display:inline-block;width:80px;">{{ __('Name') }}:</span>
				  <span>Sorable Sdn. Bhd. (1261555-A)</span>
                </div>
                <div class="mb-1">
                  <span style="display:inline-block;width:80px;">{{ __('Address') }}:</span>
				  <span>29-07, Jalan Riong</span>
                </div>
                <div class="mb-1">
                  <span style="display:inline-block;width:80px;">{{ __('City') }}:</span>
				  <span>Kuala Lumpur</span>
                </div>
                <div class="mb-1">
				  <span style="display:inline-block;width:80px;">{{ __('Country') }}:</span>
                  <span>Malaysia</span>
                </div>
				<div class="mb-1">
				  <span style="display:inline-block;width:80px;">{{ __('Zipcode') }}:</span>
                  <span>59100</span>
                </div>
				<div class="mb-1">
				  <span style="display:inline-block;width:80px;">{{ __('Email') }}:</span>
                  <span>info@workted.com</span>
                </div>
              </div>
              <div class="col-6 mt-1">
                <h6 class="invoice-to">{{ __('Customer') }}</h6>
                <div class="mb-1">
                  <span style="display:inline-block;width:80px;">{{ __('Name') }}:</span>
				  <span>{{ $billings->name }}</span>
                </div>
                <div class="mb-1">
				  <span style="display:inline-block;width:80px;">{{ __('Email') }}:</span>
                  <span>{{ $email }}</span>
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
                  <th scope="col">{{ __('Description') }}</th>
                  <th scope="col" class="text-right">{{ __('Amount') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ $billings->product_description }}</td>
				  @if($billings->frequency == 'month')
					  <td>{{ __('30 days access') }}</td>
				  @else
					  <td>{{ __('365 days access') }}</td>
				  @endif
                  
                  <td class="text-right">{{ substr($billings->amount, 0, -2) }} {{ strtoupper($billings->currency) }}</td>
                </tr>
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
                    <span class="invoice-title">{{ __('Total') }}</span>
                    <span class="invoice-value">{{ substr($billings->amount, 0, -2) }} {{ strtoupper($billings->currency) }}</span>
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
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection