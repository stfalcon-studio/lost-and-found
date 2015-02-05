$(document).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = null;

    function onMapClick(e) {
        $("#found_item_latitude").val(e.latlng.lat.toString());
        $("#found_item_longitude").val(e.latlng.lng.toString());

        if (marker) {
            map.removeLayer(marker);
        }

        $("#found_item_areaType").val('marker');
        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
    }

    map.on('click', onMapClick);
});
