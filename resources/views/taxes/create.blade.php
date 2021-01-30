@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Create Tax')
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
				{{ __('Create Tax') }}
				<span style='display:inline-block;position:relative;float:right;'>
					<a href="{{ route('taxes.index') }}" class="btn btn-sm btn-primary">{{ __('Back to Taxes') }}</a>
				</span>
			</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form method="post" action="{{ route('taxes.store') }}" class="form form-vertical" novalidate>
				@csrf
              <div class="form-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
						<div class="controls">
						  <label for="first-name-vertical">{{ __('Tax Name') }} *</label>
						  <input type="text" id="tax_name" class="form-control" name="tax_name" placeholder="{{ __('Tax Name') }}" required data-validation-required-message="{{ __('This Tax Name field is required') }}">
						</div>
					</div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
						<div class="controls">
							<label for="email-id-vertical">{{ __('Tax Amount') }} *</label>
							<div class="nopadding input-group">
							  <input step=".01" min="0.00" max="100.00" type="number" name="tax_amount" id="tax_amount" class="form-control" placeholder="{{ __('Tax Amount') }}" required data-validation-required-message="{{ __('This Tax Amount field is required') }}">
							  <div class="input-group-append">
								  <span id="custom-input-text">%</span>
							  </div>
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