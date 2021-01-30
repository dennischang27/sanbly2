@extends('layouts.app', ['title' => __('Edit Taxes')])

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Tax') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('taxes.index') }}" class="btn btn-sm btn-primary">{{ __('Back to Taxes') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">{{ __('Tax information') }}</h6>
                    <div class="pl-lg-4">
                        <form method="post" action="{{ route('taxes.update', $tax) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="col-xl-5 nopadding form-group{{ $errors->has('tax_name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="tax_name">{{ __('Tax Name') }} *</label>
                                <input type="text" name="tax_name" id="tax_name" class="form-control form-control-alternative{{ $errors->has('tax_name') ? ' is-invalid' : '' }}" placeholder="{{ __('') }}" value="{{$tax->tax_name}}" required autofocus>
                                @if ($errors->has('tax_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tax_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <label class="form-control-label" for="tax_amount">{{ __('Tax Amount') }} *</label>
                            
							<div class="col-xl-5 nopadding form-group input-group {{ $errors->has('tax_amount') ? ' has-danger' : '' }}">
                                
                                <input type="number" name="tax_amount" id="tax_amount" class="form-control form-control-alternative{{ $errors->has('tax_amount') ? ' is-invalid' : '' }}" placeholder="{{ __('') }}" value="{{$tax->tax_amount}}" required autofocus>
                                
                                <div class="input-group-append">
                                    <span id="custom-input-text">%</span>
                                </div>
                                
                                @if ($errors->has('tax_amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tax_amount') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4" onclick="this.disabled=true;this.form.submit();">{{ __('Save') }}</button>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth')

@endsection
