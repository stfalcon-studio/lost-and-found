$(document).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var drawnItems = new L.FeatureGroup();
    map.addControl(drawnItems);

    var latitude = $('#lost_item_latitude');
    var longitude = $('#lost_item_longitude');
    var area = $('#lost_item_area');

    function clearFields() {
        latitude.val('0');
        longitude.val('0');
        area.val('0');
    }

    function toolbarState(status) {
        var options;

        switch (status) {
            case 'hide':
                clearFields();

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
                clearFields();

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

    map.on('draw:created', function (e) {
        var type = e.layerType,
            layer = e.layer;

        map.removeControl(drawControl);
        drawControl = toolbarState('hide');
        map.addControl(drawControl);

        drawnItems.addLayer(layer);

        function getLatLngs(input) {
            var customArray = [];

            for (var i = 0; i < layer._latlngs.length; i++) {
                customArray.push({
                    latitude: layer._latlngs[i].lat,
                    longitude: layer._latlngs[i].lng
                });
            }
            input.val(JSON.stringify(customArray));
        }

        switch (type) {
            case "polygon":
                getLatLngs(area);
                break;
            case 'rectangle':
                getLatLngs(area);
                break;
            case 'circle':
                var arr = [{
                    latlng: layer._latlng,
                    radius: layer._mRadius
                }];

                area.val(JSON.stringify(arr));
                break;
            case 'marker':
                latitude.val(layer._latlng.lat);
                longitude.val(layer._latlng.lng);
                break;
            default:
                console.log('wrong type');
        }
    });

    map.on('draw:deleted', function (e) {
        var layers = e.layers._layers;

        if (!jQuery.isEmptyObject(layers)) {
            map.removeControl(drawControl);
            drawControl = toolbarState('show');
            map.addControl(drawControl)

            drawnItems = new L.FeatureGroup();
            map.addControl(drawnItems);
        } else {
            alert('You not delete');
        }
    });
});
