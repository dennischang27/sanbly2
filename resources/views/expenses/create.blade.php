@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Create expenses')
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
				{{ __('Create Expenses') }}
				<span style='display:inline-block;position:relative;float:right;'>
					<a href="{{ route('expenses.index') }}" class="btn btn-sm btn-primary">{{ __('Back to expenses') }}</a>
				</span>
			</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form method="post" action="{{ route('expenses.store') }}" class="form form-vertical" novalidate>
				@csrf
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                      
                  <div class="form-group">
                      <label for="first-name-vertical">{{ __('Expense Name/ Description') }} *</label>
                      <input type="text" id="expense_name" class="form-control" name="expense_name" placeholder="{{ __('Expense Name') }}" required >
                    </div>
                   
				    <div class="form-group">
                        <div class="control-group" >
						<label for="first-name-vertical">{{ __('Expense Category') }}</label>
					    <select id="expense_category" name="expense_category" class="select2 form-control" >
                            <option value="">Select Expense Category</option>
							@foreach($categories as $category)
								<option value="{{$category['id']}}"  @if (old('expense_category') == $category['id']) {{ 'selected' }} @endif>{{$category['name']}}</option>
							@endforeach
					    </select>
                        </div>
					</div>
                      
                    <div class="form-group">
						<div class="controls" id="expense_dd" >
						  <label for="first-name-vertical">{{ __('Expense Date') }} *</label>
                            
                      <input id="expense_date" name="expense_date" type="text" class="form-control pickadate mr-2 mb-50 mb-sm-0" placeholder="{{ __('Select Date') }}" required data-validation-required-message="{{ __('This Expense Date field is required') }}">
						</div>
					</div>  
                      
					<div class="form-group">
						<div class="controls">
							<label for="email-id-vertical">{{ __('Amount') }} *</label>
							<div class="nopadding input-group">
							<span class="input-group-text" style="border-top-right-radius:0rem;border-bottom-right-radius:0rem;color: #828D99;">RM</span>
							  <input step=".01" min="0.00" type="number" name="expense_amount" id="expense_amount" class="form-control" style="color: #828D99;" placeholder="0.00" required data-validation-required-message="{{ __('This Amount field is required') }}">
							</div>
						</div>
					</div>
				
					
                  </div>
				  <div class="col-md-6">
					
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
                      
                      <div class="form-group">
						<fieldset class="form-group">
							<label for="email-id-vertical">{{ __('Notes') }} </label>
							<textarea name="notes" id="notes" class="form-control" rows="3" placeholder="{{ __('Notes') }}"></textarea>
						</fieldset>
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
<script src="{{asset('js/scripts/pages/app-expense.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/forms/number-input.js')}}"></script>

@endsection