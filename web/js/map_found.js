$(function() {
    var map = L.map('map');

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    map.locate({ setView : true, maxZoom : 12 });

    var marker = null;

    var onMapClick = function(e) {
        $("#found_item_latitude").val(e.latlng.lat.toString());
        $("#found_item_longitude").val(e.latlng.lng.toString());

        if (marker) {
            map.removeLayer(marker);
        }

        $("#found_item_areaType").val('marker');
        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
    };

    map.on('click', onMapClick);
});
