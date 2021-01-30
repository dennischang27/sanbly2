@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Create Vendors')
{{-- vendor scripts --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

@section('content')
<section id="basic-vertical-layouts">
  <div class="row match-height">
    <div class="col-md-12 col-12">
      <div class="card">
        <div class="card-header">
			<h4 class="card-title">
				{{ __('Create Vendor') }}
				<span style='display:inline-block;position:relative;float:right;'>
					<a href="{{ route('vendors.index') }}" class="btn btn-sm btn-primary">{{ __('Back to vendors') }}</a>
				</span>
			</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form method="post" action="{{ route('vendors.store') }}" class="form form-vertical" novalidate>
				@csrf
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <h6 >
                        {{ __('Vendor Information') }}
                    </h6> 
                    <div class="form-group">
                      <div class="controls" >
                          <label for="first-name-vertical">{{ __('Display Name') }} *</label>
                          <input type="text" id="display_name" class="form-control" name="display_name" placeholder="{{ __('Display Name') }}" required data-validation-required-message="{{ __('This Display Name field is required') }}" >
                      </div>
                    </div>
                   <div class="form-group">
                      <label for="first-name-vertical">{{ __('Contact Name') }}</label>
                      <input type="text" id="contact_name" class="form-control" name="contact_name" placeholder="{{ __('Contact Name') }}"  >
                    </div>
                      
                    <div class="form-group">
                      <label for="first-name-vertical">{{ __('Phone') }}</label>
                      <input type="text" id="vendor_phone" class="form-control" name="vendor_phone" placeholder="{{ __('Phone') }}"  >
                    </div>
                      
                    <div class="form-group">
                      <label for="first-name-vertical">{{ __('Email') }}</label>
                      <input type="text" id="vendor_email" class="form-control" name="vendor_email" placeholder="{{ __('Email') }}"  >
                    </div>
                      
                     <div class="form-group">
                      <label for="first-name-vertical">{{ __('Website') }}</label>
                      <input type="text" id="vendor_website" class="form-control" name="vendor_website" placeholder="{{ __('Website') }}"  >
                    </div>
                   <div class="form-group">
						<div class="controls">
							<div class="invoice-terms-title" style="margin-bottom:12px;">{{ __('Active') }}</div>
							<div class="custom-control custom-switch custom-switch-glow">
							  <input name="active" type="checkbox" class="custom-control-input" checked id="vendorTerm">
							  <label class="custom-control-label" for="vendorTerm">
							  </label>
							</div>
						</div>
					</div>
					
                  </div>
				  <div class="col-md-6">
					 <h6 >
                        {{ __('Billing Information') }}
                    </h6> 
                     
                    <div class="form-group">
                      <label for="first-name-vertical">{{ __('Name') }}</label>
                      <input type="text" id="bill_name" class="form-control" name="bill_name" placeholder="{{ __('Name') }}"  >
                    </div>  
                      
                    <div class="form-group">
                      <label for="first-name-vertical">{{ __('Phone') }}</label>
                      <input type="text" id="bill_phone" class="form-control" name="bill_phone" placeholder="{{ __('Phone') }}"  >
                    </div>
                      
                     <div class="form-group">
                      <label for="first-name-vertical">{{ __('Address') }}</label>
                      <input type="text" id="bill_address" class="form-control" name="bill_address" placeholder="{{ __('Adress') }}"  >
                    </div> 
                      
                    <div class="form-group">
                      <label for="first-name-vertical">{{ __('Country') }}</label>
                      <input type="text" id="bill_country" class="form-control" name="bill_country" placeholder="{{ __('Country') }}"  >
                    </div>  
                      
                    <div class="form-group">
                      <label for="first-name-vertical">{{ __('State') }}</label>
                      <input type="text" id="bill_state" class="form-control" name="bill_state" placeholder="{{ __('State') }}"  >
                    </div> 
                      
                     <div class="form-group">
                      <label for="first-name-vertical">{{ __('City') }}</label>
                      <input type="text" id="bill_city" class="form-control" name="bill_city" placeholder="{{ __('City') }}"  >
                    </div> 
                      
                     <div class="form-group">
                      <label for="first-name-vertical">{{ __('Zipcode') }}</label>
                      <input type="text" id="bill_zipcode" class="form-control" name="bill_zipcode" placeholder="{{ __('Zipcode') }}"  >
                    </div> 
                      
                      
                      
                      
                  </div>
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
</section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>

@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/forms/number-input.js')}}"></script>
<script>

(function(window, document, $) {
  'use strict';

  // Input, Select, Textarea validations except submit button
  $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();

})(window, document, jQuery);

</script>
@endsection