@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Account Settings')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
@endsection

@section('content')
<!-- account setting page start -->
<section id="page-account-settings">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <!-- left menu section -->
                <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center active" id="account-pill-general" data-toggle="pill"
                                href="#account-vertical-general" aria-expanded="true">
                                <i class="bx bx-cog"></i>
                                <span>{{ __('General') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-password" data-toggle="pill"
                                href="#account-vertical-password" aria-expanded="false">
                                <i class="bx bx-lock"></i>
                                <span>{{ __('Change Password') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-info" data-toggle="pill"
                                href="#account-vertical-info" aria-expanded="false">
                                <i class="bx bx-info-circle"></i>
                                <span>{{ __('Info') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- right content section -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                        aria-labelledby="account-pill-general" aria-expanded="true">
                                        <form method="post" action="{{ route('account-settings.updateGeneral', $user) }}" novalidate>
											@csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('First Name') }}</label>
                                                            <input type="text" class="form-control" name="first_name"
                                                                placeholder="{{ __('First Name') }}" value="{{ $user->first_name }}" required
                                                                data-validation-required-message="{{ __('This first name field is required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('Last Name') }}</label>
                                                            <input type="text" class="form-control" placeholder="{{ __('Last Name') }}" name="last_name"
                                                                value="{{ $user->last_name }}" required
                                                                data-validation-required-message="{{ __('This last name field is required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('Email') }}</label>
                                                            <input type="email" class="form-control" placeholder="{{ __('Email') }}" name="email"
                                                                value="{{ $user->email }}" required
                                                                data-validation-required-message="{{ __('This email field is required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{ __('Company') }}</label>
                                                        <input type="text" class="form-control" value="{{ $company->name }}" name="company"
                                                            placeholder="{{ __('Company name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">{{ __('Save changes') }}</button>
                                                    <button type="reset" class="btn btn-light mb-1">{{ __('Cancel') }}</button>
                                                </div>
                                            </div>
											<input type="hidden" id="id" name="id" value="{{ $user->id }}">
                                        </form>
                                    </div>
                                    <div class="tab-pane fade " id="account-vertical-password" role="tabpanel"
                                        aria-labelledby="account-pill-password" aria-expanded="false">
                                        <form method="post" action="{{ route('account-settings.updatePassword', $user) }}" novalidate>
											@csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('Old Password') }}</label>
                                                            <input type="password" class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }} {{ session()->get( 'message' ) ? ' is-invalid' : '' }}" required name="old_password"
                                                                placeholder="{{ __('Old Password') }}"
                                                                data-validation-required-message="{{ __('This old password field is required') }}">
															@if ($errors->has('old_password'))
															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('old_password') }}</strong>
															</span>
															@endif
															@if (session()->get( 'message' ))
															<span class="invalid-feedback" role="alert">
																<strong>{{ session()->get( 'message' ) }}</strong>
															</span>
															@endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('New Password') }}</label>
                                                            <input type="password" class="form-control {{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password"
                                                                placeholder="{{ __('New Password') }}" required
                                                                data-validation-required-message="{{ __('The password field is required') }}"
                                                                minlength="6">
															@if ($errors->has('new_password'))
															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('new_password') }}</strong>
															</span>
															@endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('Retype new Password') }}</label>
                                                            <input type="password" name="retype_password"
                                                                class="form-control {{ $errors->has('retype_password') ? ' is-invalid' : '' }}" required
                                                                data-validation-match-match="new_password"
                                                                placeholder="{{ __('New Password') }}"
                                                                data-validation-required-message="{{ __('The Confirm password field is required') }}"
                                                                minlength="6">
															@if ($errors->has('retype_password'))
															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('retype_password') }}</strong>
															</span>
															@endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">{{ __('Save changes') }}</button>
                                                    <button type="reset" class="btn btn-light mb-1">{{ __('Cancel') }}</button>
                                                </div>
                                            </div>
											<input type="hidden" id="id" name="id" value="{{ $user->id }}">
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="account-vertical-info" role="tabpanel"
                                        aria-labelledby="account-pill-info" aria-expanded="false">
                                        <form method="post" action="{{ route('account-settings.updateInfo', $user) }}" novalidate>
											@csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('Birth date') }}</label>
                                                            <input type="text" class="form-control birthdate-picker" id="dob" name="dob" value="{{ $user->dob }}"
                                                                required placeholder="{{ __('Birth date') }}"
                                                                data-validation-required-message="{{ __('This birthdate field is required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{ __('Country') }}</label>
                                                        <select class="form-control" id="countrySelect" name="country">
                                                        </select>
                                                    </div>
                                                </div>
												<div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{ __('Currency') }}</label>
                                                        <select class="form-control" id="currencySelect" name="currency">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{ __('Languages') }}</label>
                                                        <select class="form-control" id="languageselect2" name="languages[]"
                                                            multiple="multiple">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>{{ __('Phone') }}</label>
                                                            <input type="text" class="form-control" required name="phone"
                                                                placeholder="{{ __('Phone number') }}" value="{{ $user->phone }}"
                                                                data-validation-required-message="{{ __('This phone number field is required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{ __('Website') }}</label>
                                                        <input type="text" class="form-control" name="website" value="{{ $company->website }}"
                                                            placeholder="{{ __('Website address') }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">{{ __('Save changes') }}</button>
                                                    <button type="reset" class="btn btn-light mb-1">{{ __('Cancel') }}</button>
                                                </div>
                                            </div>
											<input type="hidden" id="id" name="id" value="{{ $user->id }}">
                                        </form>
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
<!-- account setting page ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dropzone.min.js')}}"></script>
@endsection

@section('page-scripts')
<script>
	var tab = "{{ session()->get( 'tab' ) }}";
	var country = "{{ $user->country }}";
	var currency = "{{ $user->currency }}";
	var languages = "{{ $user->languages }}";
	var dob = "{{ $user->dob }}";
	
	$("#dob").val(dob);
</script>
<script src="{{asset('js/scripts/pages/page-account-settings.js')}}"></script>
@endsection

