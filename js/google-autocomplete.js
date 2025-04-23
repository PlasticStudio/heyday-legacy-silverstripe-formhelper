var placeSearch, autocomplete;
var componentForm = {
	street_number: 'short_name',
	route: 'long_name',
	locality: 'long_name',
	administrative_area_level_1: 'short_name',
	sublocality_level_1: 'short_name',
	country: 'long_name',
	postal_code: 'short_name',
	suburb: 'long_name'
};

function initAutocomplete() {
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	var autocompleteField = document.getElementById('autocomplete');

	autocomplete = new google.maps.places.Autocomplete(autocompleteField, {
		types: ['geocode']
	});

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();
	var fieldHolder = document.getElementById('locationField');
	var autocompleteValueParts = fieldHolder.dataset.autocompleteValues
	var autocompleteValues = [];

	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];

		if (autocompleteValueParts.indexOf(addressType) !== -1) {
			autocompleteValues.push(place.address_components[i][componentForm[addressType]]);
		}
		// First, check if the field has been imported on the template
		if(document.getElementById(addressType)) {
			if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
				document.getElementById(addressType).value = val;
			}
		}
        if (document.getElementById('street_and_number')) {
            var val = place.address_components[0][componentForm['street_number']] + ' ' + place.address_components[1][componentForm['route']];
            document.getElementById('street_and_number').value = val;
        }
	}

	document.getElementById('autocomplete').value = autocompleteValues.join(' ');
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position.coords.accuracy
			});
			autocomplete.setBounds(circle.getBounds());
		});
	}
}
