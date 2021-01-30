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
           <img src="{{asset('images/pages/500.png')}}" class="img-fluid" alt="server error" >
            
           <h1 class="error-title mt-1">Internal Server Error!</h1>
           <p class="p-2">
            Restart the browser after clearing the cache and deleting the cookies. <br> Issues triggered by wrong file
            and directory permissions.
          </p>
           
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