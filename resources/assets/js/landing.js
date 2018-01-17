// Landing Page - Venue Map
window.initVenueMap = () => {
    let venue = { lat: 41.559961, lng: -8.397652 };
    let map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: venue,
        scrollwheel: false,
        styles: [{ "featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{ "color": "#74c1e4" }] }, { "featureType": "landscape", "stylers": [{ "color": "#f5f5f5" }] }, { "featureType": "poi", "stylers": [{ "visibility": "off" }] }, { "featureType": "poi.attraction", "elementType": "geometry.fill", "stylers": [{ "visibility": "simplified" }] }, { "featureType": "poi.business", "elementType": "geometry.fill", "stylers": [{ "visibility": "off" }] }, { "featureType": "road", "stylers": [{ "saturation": -100 }, { "lightness": 45 }] }, { "featureType": "road.arterial", "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] }, { "featureType": "road.highway", "stylers": [{ "visibility": "simplified" }] }, { "featureType": "transit", "stylers": [{ "visibility": "off" }] }, { "featureType": "water", "stylers": [{ "color": "#b4d4e1" }, { "visibility": "on" }] }]
    });

    new google.maps.Marker({
        position: venue,
        map: map,
        icon: '/images/marker.svg'
    });
}

// Landing Page - Navbar scroll
$(window).scroll(() => {
    let nav = $('#navbar');
    $(window).scrollTop() >= 50 ? nav.addClass('navbar-small') : nav.removeClass('navbar-small');
});
