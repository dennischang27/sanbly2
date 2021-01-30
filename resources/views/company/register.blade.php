@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','Register Page')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- register section starts -->
<section class="row flexbox-container">
  <div class="col-xl-8 col-10">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- register section left -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="text-center mb-2">Sign Up</h4>
              </div>
            </div>
            <div class="text-center">
              <p> <small> Please enter your details to sign up and be part of our great community</small>
              </p>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form method="POST" action="{{ route('company.activate') }}">
                  @csrf

                    <div class="form-group mb-50">
                    <label class="text-bold-600" for="name">{{ __('Company Name') }}*</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-group mb-50">
                    <label class="text-bold-600" for="password">{{ __('Password') }}*</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="{{ old('retype_password') }}">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group mb-50">
                    <label class="form-control-label" for="retype_password">{{ __('Retype Password') }} </label>
                    <input type="password" name="retype_password" id="retype_password" class="form-control form-control-alternative{{ $errors->has('retype_password') ? ' is-invalid' : '' }}" placeholder="{{ __('') }}" value="{{ old('retype_password') }}" autofocus>
                    <span id="unmatched" style="display:none;color:red;font-size:14px;">* password not match</span>
                </div>  
                    
                  <input type="hidden" name="code" value="{{$code}}">
                  <button type="submit" class="btn btn-primary glow position-relative w-100">SIGN UP<i
                    id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                </form>
                <hr>
                <div class="text-center"><small class="mr-25">Already have an account?</small>
                  <a href="{{asset('login')}}"><small>Sign in</small> </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- image section right -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
            <img class="img-fluid" src="{{asset('images/pages/register.png')}}" alt="branding logo">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- register section endss -->
@endsection
