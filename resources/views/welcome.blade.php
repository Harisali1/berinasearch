<!DOCTYPE html>
<html>
<head>
    <title>Place Autocomplete Address Form</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:400,500"
        rel="stylesheet"
    />

    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script src="./index.js"></script>
</head>
<body>
<!-- Note: The address components in this sample are based on North American address format. You might need to adjust them for the locations relevant to your app. For more information, see
https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform
-->

<form >
    <p class="title">Sample address form for North America</p>
    <p class="note"><em>* = required field</em></p>
    <label class="full-field">
        <!-- Avoid the word "address" in id, name, or label text to avoid browser autofill from conflicting with Place Autocomplete. Star or comment bug https://crbug.com/587466 to request Chromium to honor autocomplete="off" attribute. -->
        <span class="form-label">Deliver to*</span>
        <input
            id="ship-address"
            name="ship-address"
        />
    </label>
    <label class="full-field">
        <span class="form-label">Apartment, unit, suite, or floor #</span>
        <input id="address2" name="address2" />
    </label>
    <label class="full-field">
        <span class="form-label">City*</span>
        <input id="locality" name="locality" required />
    </label>
    <label class="slim-field-left">
        <span class="form-label">State/Province*</span>
        <input id="state" name="state" required />
    </label>
    <label class="slim-field-left">
        <span class="form-label">Latitude*</span>
        <input id="latitude" name="latitude" required />
    </label>
    <label class="slim-field-left">
        <span class="form-label">Longitude*</span>
        <input id="longitude" name="longitude" required />
    </label>
    <label class="slim-field-right" for="postal_code">
        <span class="form-label">Postal code*</span>
        <input id="postcode" name="postcode" required />
    </label>
    <label class="full-field">
        <span class="form-label">Country/Region*</span>
        <input id="country" name="country" required />
    </label>
    <button type="button" class="my-button">Save address</button>

    <!-- Reset button provided for development testing convenience.
Not recommended for user-facing forms due to risk of mis-click when aiming for Submit button. -->
    <input type="reset" value="Clear form" />
</form>
<div id="postal_code"></div>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
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
        address1Field = document.querySelector("#ship-address");
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
                    document.querySelector("#locality").value = component.long_name;
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
</body>
</html>
