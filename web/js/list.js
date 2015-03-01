var layerGroup = new L.FeatureGroup();

$(document).ready(function () {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    $('#list a').each(function(index) {
        var options = { color: "#000000", weight: 2 };
        var areaType = $(this).data('area-type');
        var area = null;
        var center = null;

        switch (areaType) {
            case 'polygon':
                area = $(this).data('area');

                console.log(areaType + area);

                var polygon = [];
                var summLat = 0, summLng = 0;

                for (var j = 0; j < area.length; j++) {
                    polygon.push([area[j].latitude, area[j].longitude]);
                    summLat += parseInt(area[j].latitude);
                    summLng += parseInt(area[j].longitude);
                }

                layer = L.polygon(polygon, options);
                center = [summLat / area.length, summLng / area.length];
                break;
            case 'rectangle':
                area = $(this).data('area');

                console.log(area);

                var bounds = [
                    [area[0].latitude, area[0].longitude],
                    [area[2].latitude, area[2].longitude]
                ];

                layer = L.rectangle(bounds, options);
                center = [area[0].latitude, area[2].longitude];
                break;
            case 'circle':
                area = $(this).data('area')[0];

                layer = L.circle([area.latlng.lat, area.latlng.lng], area.radius, options);
                center = [area.latlng.lat, area.latlng.lng];
                break;
            case 'marker':
                var latitude  = $(this).data('latitude');
                var longitude = $(this).data('longitude');

                var imageUrl = $(this).data('category-image');

                if (imageUrl !== '') {
                    var icon = L.icon({
                        iconUrl: imageUrl, iconSize: [32, 32]
                    });

                    layer = L.marker([latitude, longitude], {
                        icon: icon
                    });
                } else {
                    layer = L.marker([latitude, longitude]);
                }

                center = [latitude, longitude];
                break;
        }

        map.setView(center, 6);

        var popupText =
            "<div>" +
                "<h6 align='center' style='margin-bottom: 0'>" +
                    "<b>" + $(this).data('category-title') + "</b>" +
                "</h6>" +
                "<br />" +
                "<h3 style='margin: 0' align='center'>" +
                    "<a href='" + $(this).attr('href') + "'>" + $(this).text() + "</a>" +
                "</h3>" +
                "<br />" +
                "<p style='margin-top: 0' align='right'>Added: " + $(this).data('date')+ "</p>" +
            "</div>";

        layer.bindPopup(popupText);
        layerGroup.addLayer(layer).addTo(map);
    });

    map.addLayer(layerGroup);
});
