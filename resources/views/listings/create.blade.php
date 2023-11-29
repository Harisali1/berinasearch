@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('listings.index') !!}">Listing</a>
      </li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create Listing</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'listings.store', 'files' => true]) !!}

                                   @include('listings.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
    @push('scripts')
        <script src='https://maps.googleapis.com/maps/api/js?key={{ config('services.googleMap.api_key') }}&#038;libraries=places' id='mapsjs-js'></script>
        <script src="{{ asset('assets/js/app.js') }}" defer></script>
        <script>
            $(document).ready(function(){
                $('.image-gallery-uploader').imageUploader();
            });
        </script>
    @endpush
@endsection
