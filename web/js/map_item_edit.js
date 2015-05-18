$(document).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var drawnItems = new L.FeatureGroup();
    map.addControl(drawnItems);


    var latitude = $("input[name*='[latitude]']").val();
    var longitude = $("input[name*='[longitude]']").val();
    var area = $("input[name*='[area]']").val();
    var areaType = $("input[name*='[areaType]']").val();
    var itemType = $("#itemType").data('item-type');
    var options = {color: "#000000", weight: 2};

    function toolbarState(status) {
        var options;
        switch (status) {
            case 'hide':
                options = new L.Control.Draw({
                    draw: {
                        polyline: false,
                        polygon: false,
                        rectangle: false,
                        circle: false,
                        marker: false
                    }
                });
                break;
            case 'show':
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
                    }
                });
                break;
            default:
                console.log('Unknown option \'' + status + '\'');
        }
        return options;
    }

    var drawControl = toolbarState('hide');
    map.addControl(drawControl);

    var layer = null;
    var center = null;

    switch (areaType) {
        case 'polygon':
            area = JSON.parse(area);

            var polygon = [];
            var summLat = 0, summLng = 0;

            for (var i = 0; i < area.length; i++) {
                polygon.push([area[i].latitude, area[i].longitude]);
                summLat += parseInt(area[i].latitude);
                summLng += parseInt(area[i].longitude);
            }

            layer = L.polygon(polygon, options);
            center = [summLat / area.length, summLng / area.length];
            map.setView(center, 6);
            break;
        case 'rectangle':
            area = JSON.parse(area);
            var bounds = [[area[0].latitude, area[0].longitude], [area[2].latitude, area[2].longitude]];

            layer = L.rectangle(bounds, options);
            center = [area[0].latitude, area[0].longitude];
            map.setView([area[0].latitude, area[0].longitude], 6);
            break;
        case 'circle':
            area = JSON.parse(area);

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

    function layerClick() {
        layer.on('click', function(e){
            var popup = L.popup()
                .setContent("Delete that item? <button id=\"yes\">Yes</button><button id=\"no\">No</button>")
                .setLatLng(e.latlng)
                .openOn(map);

            var yes = $('#yes').on('click', function() {
                figureLayer.removeLayer(layer);
                if ('found' === itemType) {
                    drawControl = toolbarState('show');
                }
                map.addControl(drawControl);
                map.closePopup();
            });
        });
    }

    var marker = null;

    var onMapClick = function(e) {
        if (!marker){
            figureLayer.removeLayer(layer);
        }
        $("#item_edit_latitude").val(e.latlng.lat.toString());
        $("#item_edit_longitude").val(e.latlng.lng.toString());

        if (marker) {
            map.removeLayer(marker);
        }

        $("#item_edit_areaType").val('marker');
        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
    };


    if ('found' === itemType) {
        map.on('click', onMapClick);
    }

    function clearInputs() {
        $("input[name*='[latitude]']").val('');
        $("input[name*='[longitude]']").val('');
        $("input[name*='[area]']").val('');
    }

    layerClick();

    map.on('draw:created', function (e) {
        var type = e.layerType,
            createdLayer = e.layer;

        map.removeControl(drawControl);
        drawControl = toolbarState('hide');
        map.addControl(drawControl);
        layer = createdLayer;
        figureLayer.addLayer(layer);

        layerClick();

        function getLatLngs() {
            var customArray = [];

            for (var i = 0; i < createdLayer._latlngs.length; i++) {
                customArray.push({
                    latitude: createdLayer._latlngs[i].lat,
                    longitude: createdLayer._latlngs[i].lng
                });
            }

            $("input[name*='[area]']").val(JSON.stringify(customArray));
        }

        clearInputs();

        switch (type) {
            case 'polygon':
                getLatLngs();
                break;
            case 'rectangle':
                getLatLngs();
                break;
            case 'circle':
                var arr = [{
                    latlng: createdLayer._latlng,
                    radius: createdLayer._mRadius
                }];

                $("input[name*='[area]']").val(JSON.stringify(arr));
                break;
            case 'marker':
                $("input[name*='[latitude]']").val(createdLayer._latlng.lat);
                $("input[name*='[longitude]']").val(createdLayer._latlng.lng);
                break;
            default:
                console.log('wrong type');
        }

        $("input[name*='[areaType]']").val(type);
    });
});
