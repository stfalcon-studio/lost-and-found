$(document).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var drawnItems = new L.FeatureGroup();
    map.addControl(drawnItems);

    var latitude = $('#latitude').data('latitude');
    var longitude = $('#longitude').data('longitude');
    var area = $('#area').data('area');
    var areaType = $('#areaType').data('areaType');

    var options = {color: "#000000", weight: 2};

    var layer = null;
    var center = null;

    switch (areaType) {
        case 'polygon':
            area = JSON.parse(JSON.parse(area));

            var polygon = [];
            var summLat = 0, summLng = 0;

            for (var i = 0; i < area.length; i++) {
                polygon.push([area[i].latitude, area[i].longitude]);
                summLat += parseInt(area[i].latitude);
                summLng += parseInt(area[i].longitude);
            }

            layer = L.polygon(polygon, options)
            center = [summLat / area.length, summLng / area.length];
            map.setView(center, 6);
            break;
        case 'rectangle':
            area = JSON.parse(JSON.parse(area));
            console.log(area[0]);

            var bounds = [[area[0].latitude, area[0].longitude], [area[2].latitude, area[2].longitude]];

            layer = L.rectangle(bounds, options);
            center = [area[0].latitude, area[0].longitude];
            map.setView([area[0].latitude, area[0].longitude], 6);
            break;
        case 'circle':
            area = JSON.parse(JSON.parse(area));

            layer = L.circle([area[0].latlng.lat, area[0].latlng.lng], area[0].radius, options);
            center = [area[0].latlng.lat, area[0].latlng.lng];
            map.setView([area[0].latlng.lat, area[0].latlng.lng], 6);
            break;
        case 'marker':
            layer = L.marker([latitude, longitude]);
            center = [latitude, longitude];
            map.setView([latitude, longitude], 6);
            break;
    }

    var figureLayer = L.layerGroup().addLayer(layer).addTo(map);
});

$('#contact-with-author').on('click', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'http://lost-and-found.work/app_dev.php/item/' + $('#itemId').data('item-id') + '/request-user',
        type: 'get',
        dataType: 'JSON',
        success: function (data) {
            $('#contact-with-author').hide();
            document.getElementById('facebook-profile').href = 'https://www.facebook.com/' + data;
            $("#facebook-profile").toggle();
        }
    });
});

