<p class="fs-3 pt-2 text-center">Find a Bookstore</p>
<p class="fs-5 text-danger text-center" id="gps-error" style="display:none;">Place enable your GPS location.</p>
<div class="container mt-3 p-2 border border-dark border-2 rounded" id="map-container">
	<div id="bookstore-map" style="height:600px;">
	</div>
</div>

<script>
let mapView;
let service;

function initMap(position) {
	
	service = new google.maps.places.PlacesService(mapView);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };
			
			const localContextMapView = new google.maps.localContext.LocalContextMapView({
				element: document.getElementById("bookstore-map"),
				placeTypePreferences: [
					{ type: "book_store" },
				],
				maxPlaceCount: 15,
			});
			
			mapView = localContextMapView.map;
			mapView.setOptions({
				center: pos,
				zoom: 14,
			});

        },() => {
            handleLocationError(true);
        });
    } else{
        handleLocationError(false);
    }
	
}

function addPlaces(places, map) {
	for (const place of places) {
		if (place.geometry && place.geometry.location) {
			new google.maps.Marker({
				map,
				title: place.name,
				position: place.geometry.location,
			});
		}
	}
}

function handleLocationError(browserHasGeolocation) {
    if (browserHasGeolocation){
        console.log("Error: The Geolocation service failed.");
    } else {
        console.log("Error: Your browser doesn't support geolocation.");
    }
	document.getElementById("map-container").style.display="none";
	document.getElementById("gps-error").style.display="block";
}

</script>

<script async
    src="https://maps.googleapis.com/maps/api/js?key=apiKey&libraries=localContext,places&v=beta&callback=initMap">
</script>