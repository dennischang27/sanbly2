@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Create Expense Category')
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-taxes.css')}}">
@endsection

@section('content')
<section id="basic-vertical-layouts">
  <div class="row match-height">
    <div class="col-md-12 col-12">
      <div class="card">
        <div class="card-header">
			<h4 class="card-title">
				{{ __('Create Payment Modes') }}
				<span style='display:inline-block;position:relative;float:right;'>
					<a href="{{ route('payment-modes.index') }}" class="btn btn-sm btn-primary">{{ __('Back to Payment Modes') }}</a>
				</span>
			</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form method="post" action="{{ route('payment-modes.store') }}" class="form form-vertical" novalidate>
				@csrf
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
						<div class="controls">
						  <label for="first-name-vertical">{{ __('Payment Mode Name') }} *</label>
						  <input type="text" id="payment_mode_name" class="form-control" name="payment_mode_name" placeholder="{{ __('Payment Mode Name') }}" required data-validation-required-message="{{ __('This Payment Mode Name field is required') }}">
						</div>
					</div>
					<div class="form-group">
						<fieldset class="form-group">
							<label for="email-id-vertical">{{ __('Description') }} </label>
							<textarea name="description" id="description" class="form-control" rows="3" maxlength="300" placeholder="{{ __('Description') }}"></textarea>
						</fieldset>
					</div>
                  </div>
				  <div class="col-md-6">
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
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset  ('js/scripts/forms/validation/form-validation.js')}}"></script>
@endsection