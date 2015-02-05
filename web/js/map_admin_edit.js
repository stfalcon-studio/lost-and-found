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

    function toolbarState(status) {
        var options;

        switch (status) {
            case 'hide':
                //clearFields();

                options = new L.Control.Draw({
                    draw: {
                        polyline: false,
                        polygon: false,
                        rectangle: false,
                        circle: false,
                        marker: false
                    },
                    edit: {
                        featureGroup: drawnItems
                    }
                });
                break;
            case 'show':
                //clearFields();

                options = new L.Control.Draw({
                    draw: {
                        position: 'topleft',
                        polygon: {
                            shapeOptions: {
                                color: '#000000'
                            },
                            showArea: true
                        },
                        rectangle: {
                            shapeOptions: {
                                color: '#000000'
                            }
                        },
                        polyline: false,
                        circle: {
                            shapeOptions: {
                                color: '#000000'
                            }
                        }
                    },
                    edit: {
                        featureGroup: drawnItems
                    }
                });
                break;
            default:
                console.log('Unknown option \'' + status + '\'');
        }
        return options;
    }

    var drawControl = toolbarState('show');
    map.addControl(drawControl);

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

    map.on('click', function(e){
        var popup = L.popup()
            .setContent("Delete that item? <button id=\"yes\">Yes</button><button id=\"no\">No</button>")
            .setLatLng(center)
            .openOn(map);

        /* TODO: Close popup after delete layer */

        var yes = $('#yes').on('click', function() {
            figureLayer.removeLayer(layer);
        });
    });
});
