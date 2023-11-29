@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('listings.index') !!}">Listing</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Listing</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($listing, ['route' => ['listings.update', $listing->id], 'method' => 'patch', 'files' => true]) !!}

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
            $(document).ready(function () {
                var images = @json(isset($gallaries) ? $gallaries : []);

                $('.image-gallery-uploader').imageUploader({
                    preloaded: images
                });

                $('.delete-image').click( function(e){
                    e.preventDefault();
                    let id = $(this).siblings('input').val();
                    var url = '{{ route("image.delete", ":id") }}';
                    location.href = url.replace(':id', id);
                })

            });
        </script>
    @endpush
@endsection
