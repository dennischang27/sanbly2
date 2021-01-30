@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Create Products')
{{-- vendor scripts --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
@endsection
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
				{{ __('Create Products') }}
				<span style='display:inline-block;position:relative;float:right;'>
					<a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">{{ __('Back to Products') }}</a>
				</span>
			</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form method="post" action="{{ route('products.store') }}" class="form form-vertical" novalidate>
				@csrf
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
						<div class="controls">
						  <label for="first-name-vertical">{{ __('Item Code') }}</label>
						  <input type="text" id="item_code" class="form-control" name="item_code" placeholder="{{ __('Item Code') }}">
						</div>
					</div>
				    <div class="form-group">
						<label for="first-name-vertical">{{ __('Product Category') }}</label>
					    <select id="product_category" name="product_category" class="select2 form-control" onchange="productCategoryChange()">
							@foreach($categories as $category)
								<option value="{{$category['id']}}"  @if (old('product_category') == $category['name']) {{ 'selected' }} @endif>{{$category['name']}}</option>
							@endforeach
					    </select>
					</div>
					<div class="form-group">
						<div class="controls">
							<label for="email-id-vertical">{{ __('Product Price') }} *</label>
							<div class="nopadding input-group">
							<span class="input-group-text" style="border-top-right-radius:0rem;border-bottom-right-radius:0rem;color: #828D99;">RM</span>
							  <input step=".01" min="0.00" type="number" name="price" id="price" class="form-control" style="color: #828D99;" placeholder="0.00" required data-validation-required-message="{{ __('This Product Price field is required') }}">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="first-name-vertical">{{ __('Taxes') }}</label>
					    <select id="tax" name="tax" class="select2 form-control" onchange="taxChange()">
							<option value="N/A"  @if (old('tax') == "N/A") {{ 'selected' }} @endif>N/A</option>
							@foreach($taxes as $tax)
								<option value="{{$tax['id']}}"  @if (old('tax') == $tax['tax_name']) {{ 'selected' }} @endif>{{$tax['tax_name']}}</option>
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
				  <div class="col-md-6">
					<div class="form-group">
						<div class="controls">
						  <label for="first-name-vertical">{{ __('Serial Number') }}</label>
						  <input type="text" id="serial_number" class="form-control" name="serial_number" placeholder="{{ __('Serial Number') }}">
						</div>
					</div>
                    <div class="form-group">
						<div class="controls">
						  <label for="first-name-vertical">{{ __('Product Name') }} *</label>
						  <input type="text" id="product_name" class="form-control" name="product_name" placeholder="{{ __('Product Name') }}" required data-validation-required-message="{{ __('This Product Name field is required') }}">
						</div>
					</div>
					<div class="form-group">
						<div class="controls">
							<label for="email-id-vertical">{{ __('Product Cost') }} *</label>
							<div class="nopadding input-group">
							<span class="input-group-text" style="border-top-right-radius:0rem;border-bottom-right-radius:0rem;color: #828D99;">RM</span>
							  <input step=".01" min="0.00" type="number" name="cost" id="cost" class="form-control" style="color: #828D99;" placeholder="0.00" required data-validation-required-message="{{ __('This Product Cost field is required') }}">
							</div>
						</div>
					</div>
					<div class="form-group" style="margin-top: 2.5rem;margin-bottom: 2.1rem;">
						<div class="controls checkbox">
							<input type="checkbox" class="checkbox-input" id="price_includes_tax" name="price_includes_tax">
							<label for="price_includes_tax">{{ __('Price includes tax') }}</label>
						</div>
					</div>
					<div class="form-group">
						<div class="d-inline-block mb-1 mr-1">
							<label for="first-name-vertical">{{ __('Stock Level') }}</label>
							<input name="stock_level" id="stock_level" type="number" class="touchspin" style="color:#828D99;" value="0">
						</div>
					</div>
                  </div>
				  <input type="hidden" id="category_name" name="category_id" value="">
				  <input type="hidden" id="tax_name" name="tax_id" value="">
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
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/forms/number-input.js')}}"></script>
@endsection

<script>
    function taxChange() {
		var tax_name = $( "#tax option:selected" ).text();
		$('#tax_name').val(tax_name);
	}
	
	function productCategoryChange() {
		var product_category_name = $( "#product_category option:selected" ).text();
		$('#category_name').val(product_category_name);
	}
</script>