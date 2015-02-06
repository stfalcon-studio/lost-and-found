$(document).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = null;

    function onMapClick(e) {
        $("#item_edit_latitude").val(e.latlng.lat.toString());
        $("#item_edit_longitude").val(e.latlng.lng.toString());

        if (marker) {
            map.removeLayer(marker);
        }

        $("#item_edit_areaType").val('marker');
        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
    }

    function showPoint() {
        var categories;
        $.ajax({
            url: 'http://lost-and-found.work/app_dev.php/get/categories',
            type: 'get',
            dataType: 'JSON',
            success: function(data){
                var latitude = $("#item_edit_latitude").val();
                var longitude = $("#item_edit_longitude").val();
                    marker = L.marker([latitude,longitude]).addTo(map);
            }
        });
    }

    showPoint();
    map.on('click', onMapClick);
});