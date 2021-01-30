@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Create Customer')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-customers.css')}}">
@endsection

@section('content')
<section id="basic-vertical-layouts">
  <div class="row match-height">
    <div class="col-md-12 col-12">
      <div class="card">
        <div class="card-header">
			<h4 class="card-title">
				{{ __('Create Customer') }}
				<span style='display:inline-block;position:relative;float:right;'>
					<a href="{{ route('customers.index') }}" class="btn btn-sm btn-primary">{{ __('Back to Customers') }}</a>
				</span>
			</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form method="post" action="{{ route('customers.store') }}" class="form form-vertical" novalidate>
				@csrf
              <div class="form-body">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
						<div class="controls">
						  <label for="first-name-vertical">{{ __('Customer/Company Name') }} *</label>
						  <input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Customer/Company Name') }}" required data-validation-required-message="{{ __('This Name field is required') }}">
						</div>
					</div>
					<div class="form-group">
						<div class="controls">
							<label for="email-id-vertical">{{ __('City') }}</label>
							<input type="text" class="form-control" name="city" placeholder="{{ __('City') }}">
						</div>
					</div>
					<div class="form-group">
						<div class="controls">
							<label for="email-id-vertical">{{ __('Zipcode') }}</label>
							<input type="text" class="form-control" name="zipcode" placeholder="{{ __('Zipcode') }}">
						</div>
					</div>
					<div class="form-group">
						<div class="controls">
							<label for="email-id-vertical">{{ __('Phone') }}</label>
							<input type="text" class="form-control" name="phone" placeholder="{{ __('Phone') }}">
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
							<input type="text" class="form-control" name="address" placeholder="{{ __('Address') }}">
						</div>
					</div>
					<div class="form-group">
						<div class="controls">
							<label for="email-id-vertical">{{ __('State') }}</label>
							<input type="text" class="form-control" name="state" placeholder="{{ __('State') }}">
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
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dropzone.min.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset  ('js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/pages/page-customers.js')}}"></script>
@endsection
<script>
	var tab = '';
	var country = '';
	var currency = '';
	var languages = '';
</script>