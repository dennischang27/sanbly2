@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Page Not Found')

@section('content')
<!-- not authorized start -->
<section class="row flexbox-container">
  <div class="col-xl-6 col-md-7 col-9">
    <div class="card bg-transparent shadow-none">
      <div class="card-content">
        <div class="card-body text-center bg-transparent miscellaneous">
          <h1 class="error-title">Page Not Found :(</h1>
          <p class="pb-3">
            we couldn't find the page you are looking for</p>
            <img src="{{asset('images/pages/404.png')}}" class="img-fluid" alt="not authorized" >
         
        </div>
          
          <div class="text-center">
           <a href="{{asset('/')}}" class="btn btn-primary round glow mt-2">BACK
            TO
            HOME</a>
          
          </div>
          
          
      </div>
    </div>
  </div>
</section>


@endsection