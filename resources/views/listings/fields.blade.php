<div class="row">
    <div class="form-group col-sm-12">
        <hr>
        <h3>Basic Information</h3>
        <hr>
    </div>
    <!-- Title Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('title', 'Title:') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
    <!-- Type Id Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('type_id', 'Types:') !!}
        {!! Form::select('type_id', $types, null, ['class' => 'form-control', 'placeholder'=>'Please select ...']) !!}
    </div>
    <!-- Price Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('price', 'Price:') !!}
        {!! Form::number('price', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-12">
        <hr>
        <h3>Attributes</h3>
        <hr>
    </div>

    <!-- No Of Room Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('area', 'Area:') !!}
        {!! Form::text('area', null, ['class' => 'form-control']) !!}
    </div>
    <!-- No Of Room Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('no_of_room', 'No Of Room:') !!}
        {!! Form::number('no_of_room', null, ['class' => 'form-control']) !!}
    </div>
    <!-- No Of Room Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('no_of_bed', 'No Of Bed:') !!}
        {!! Form::number('no_of_bed', null, ['class' => 'form-control']) !!}
    </div>
    <!-- No Of Room Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('no_of_bath', 'No Of Bath:') !!}
        {!! Form::number('no_of_bath', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-12">
        <hr>
        <h3>Gallery</h3>
        <hr>
    </div>
    <!-- Image Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('image', 'Main Image:') !!}
        {!! Form::file('image[]', array('multiple'=>false, 'id'=>'image', 'class' => 'form-control')) !!}
    </div>

    <!-- Image Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('image', 'Image:') !!}
        <span class="alert text-danger" style="font-size: 20px;padding: 0px;font-weight: 700;">*</span>
        <div class="image-gallery-uploader" style="padding-top: .5rem;"></div>
    </div>

    <div class="form-group col-sm-12">
        <hr>
        <h3>Address Detail</h3>
        <hr>
    </div>
    <!-- City Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('city', 'City:') !!}
        {!! Form::text('city', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
    </div>

    <!-- Location Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('location', 'Location:') !!}
        {!! Form::text('location', null, ['class' => 'form-control']) !!}
    </div>
    <!-- Latitude Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('lat', 'Latitude:') !!}
        {!! Form::text('lat', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
    </div>

    <label class="form-group col-sm-6">
        {!! Form::label('state', 'State:') !!}
        {!! Form::text('state', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
    </label>

    <label class="form-group col-sm-6">
        {!! Form::label('country', 'Country:') !!}
        {!! Form::text('country', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
    </label>
    <!-- Longitude Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('lng', 'Longitude:') !!}
        {!! Form::text('lng', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
    </div>

    <label class="form-group col-sm-6" for="postal_code">
        {!! Form::label('postcode', 'Zip Code:') !!}
        {!! Form::text('postcode', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
    </label>

{{--    <!-- Address Field -->--}}
{{--    <div class="form-group col-sm-6">--}}
{{--        {!! Form::label('address', 'Address:') !!}--}}
{{--        {!! Form::textarea('address', null, ['class' => 'form-control']) !!}--}}
{{--    </div>--}}
    <!-- Description Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('description', 'Description:') !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>




</div>

<div class="clearfix"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('listings.index') }}" class="btn btn-secondary">Cancel</a>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6wiAIb_qrtjwkiGoqZd-1lu7-Vt9EJmQ&callback=initAutocomplete&libraries=places&v=weekly"
    async
></script>
<script>
    // This sample uses the Places Autocomplete widget to:
    // 1. Help the user select a place
    // 2. Retrieve the address components associated with that place
    // 3. Populate the form fields with those address components.
    // This sample requires the Places library, Maps JavaScript API.
    // Include the libraries=places parameter when you first load the API.
    // For example: <script
    // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    let autocomplete;
    let address1Field;
    let address2Field;
    let postalField;

    function initAutocomplete() {
        address1Field = document.querySelector("#location");
        address2Field = document.querySelector("#address2");
        postalField = document.querySelector("#postcode");
        // Create the autocomplete object, restricting the search predictions to
        // addresses in the US and Canada.
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: { country: ["pk","us"] },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });



        address1Field.focus();
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();
        let address1 = "";
        let postcode = "";



        $('#latitude').val(place.geometry['location'].lat());
        $('#longitude').val(place.geometry['location'].lng());


        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        // place.address_components are google.maps.GeocoderAddressComponent objects
        // which are documented at http://goo.gle/3l5i5Mr
        for (const component of place.address_components) {
            const componentType = component.types[0];

            switch (componentType) {
                case "street_number": {
                    address1 = `${component.long_name} ${address1}`;
                    break;
                }

                case "route": {
                    address1 += component.short_name;
                    break;
                }

                case "postal_code": {
                    postcode = `${component.long_name}${postcode}`;
                    break;
                }

                case "postal_code_suffix": {
                    postcode = `${postcode}-${component.long_name}`;
                    break;
                }
                case "locality":
                    document.querySelector("#city").value = component.long_name;
                    break;
                case "administrative_area_level_1": {
                    document.querySelector("#state").value = component.short_name;
                    break;
                }
                case "country":
                    document.querySelector("#country").value = component.long_name;
                    break;
            }
        }

        address1Field.value = address1;
        postalField.value = postcode;
        // After filling the form with address components from the Autocomplete
        // prediction, set cursor focus on the second address line to encourage
        // entry of subpremise information such as apartment, unit, or floor number.
        address2Field.focus();
    }
</script>
