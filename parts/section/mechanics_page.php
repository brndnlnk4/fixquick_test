	<section class="google-map map-holder">
		<div id="map" class="map center"></div>
		<form role="form" class="get-direction">
			<div class="container">
				<div class="row">
					<div class="center-block col-lg-10">
						<div class="input-group">
							<input type="text" id='autocomplete' class="le-input input-lg form-control" placeholder="Enter your Zip Postal Code">
							<span class="input-group-btn">
								<button class="btn btn-lg le-button" type="button">Find Mechanic</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
				</div><!-- /.row -->
			</div>
		</form>
	</section>
	
	<script>
		function initialize() {
		  initAutocomplete();
		}
		var map, marker;

		var placeSearch, autocomplete;
		var componentForm = {
		  street_number: 'short_name',
		  route: 'long_name',
		  locality: 'long_name',
		  administrative_area_level_1: 'short_name',
		  country: 'long_name',
		  postal_code: 'short_name'
		};

		function initAutocomplete() {
			map = new google.maps.Map(document.getElementById('map'), {
			  center: {
				lat: 37.090240,
				lng: -95.712891
			  },
			  zoom: 5
			});
		  // Create the autocomplete object, restricting the search to geographical
		  // location types.
		  autocomplete = new google.maps.places.Autocomplete(
			/** @type {!HTMLInputElement} */
			(document.getElementById('autocomplete')), {
			  types: ['geocode']
			});

		  // When the user selects an address from the dropdown, populate the address
		  // fields in the form.
		  autocomplete.addListener('place_changed', fillInAddress);
		}

		function fillInAddress() {
		  // Get the place details from the autocomplete object.
		  var place = autocomplete.getPlace();
		  if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		  } else {
			map.setCenter(place.geometry.location);
			map.setZoom(17); // Why 17? Because it looks good.
		  }
		  if (!marker) {
			marker = new google.maps.Marker({
			  map: map,
			  anchorPoint: new google.maps.Point(0, -29)
			});
		  } else marker.setMap(null);
		  marker.setOptions({
			position: place.geometry.location,
			map: map
		  });

		  for (var component in componentForm) {
			document.getElementById(component).value = '';
			document.getElementById(component).disabled = false;
		  }

		  // Get each component of the address from the place details
		  // and fill the corresponding field on the form.
		  for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			if (componentForm[addressType]) {
			  var val = place.address_components[i][componentForm[addressType]];
			  document.getElementById(addressType).value = val;
			}
		  }
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
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDu_6_gxC4_s41ZtSSvRkAMvttzJwGSGmY&libraries=places&callback=initialize" async defer></script>	
