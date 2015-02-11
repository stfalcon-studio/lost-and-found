$(document).ready(function () {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var points = $("#map").data();

    for (var point in points.items) {
        if (points.items.hasOwnProperty(point)) {
            L.marker([points.items[point].latitude, points.items[point].longitude]).addTo(map);
        }
    }

    function formatDate(dateObject) {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();

        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + "." + month + "." + year;

        return date;
    }

    function showPoints(type) {
        var categories;
        var popupTextArray = [];
        $.ajax({
            url: 'http://lost-and-found.work/app_dev.php/get/categories',
            type: 'get',
            dataType: 'JSON',
            success: function (data) {
                categories = new Object(data);
                $.ajax({
                    url: 'http://lost-and-found.work/app_dev.php/show/' + type + '-points',
                    type: 'get',
                    dataType: 'JSON',
                    success: function (data) {
                        for (var i = 0; i < data.length; i++) {
                            var drawnItems = new L.FeatureGroup();
                            map.addControl(drawnItems);

                            var latitude = data[i].latitude;
                            var longitude = data[i].longitude;
                            var area = data[i].area;
                            var areaType = data[i].areaType;
                            var options = {color: "#000000", weight: 2};

                            var layer = null;
                            var center = null;

                            switch (areaType) {
                                case 'polygon':
                                    area = JSON.parse(area);

                                    var polygon = [];
                                    var summLat = 0, summLng = 0;

                                    for (var j = 0; j < area.length; j++) {
                                        polygon.push([area[j].latitude, area[j].longitude]);
                                        summLat += parseInt(area[j].latitude);
                                        summLng += parseInt(area[j].longitude);
                                    }

                                    layer = L.polygon(polygon, options);
                                    center = [summLat / area.length, summLng / area.length];
                                    map.setView(center, 6);
                                    break;
                                case 'rectangle':
                                    area = JSON.parse(area);
                                    var bounds = [
                                        [area[0].latitude, area[0].longitude], [area[2].latitude, area[2].longitude]
                                    ];

                                    layer = L.rectangle(bounds, options);
                                    center = [area[0].latitude, area[0].longitude];
                                    map.setView([area[0].latitude, area[0].longitude], 6);
                                    break;
                                case 'circle':
                                    area = JSON.parse(area);
                                    layer = L.circle([area[0].latlng.lat, area[0].latlng.lng], area[0].radius,
                                        options);
                                    center = [area[0].latlng.lat, area[0].latlng.lng];
                                    map.setView([area[0].latlng.lat, area[0].latlng.lng], 6);
                                    break;
                                case 'marker':
                                    var cat = categories[data[i].categoryId];
                                    if (cat['imageName'] !== null) {
                                        var icon = L.icon({
                                            iconUrl: cat['imageName'], iconSize: [32, 32]
                                        });
                                        layer = L.marker([data[i].latitude, data[i].longitude], {icon: icon});
                                    } else {
                                        layer = L.marker([data[i].latitude, data[i].longitude]);
                                    }
                                    center = [latitude, longitude];
                                    map.setView([latitude, longitude], 6);

                                    break;
                            }

                            var popupText = "<div><h6 align='center' style='margin-bottom: 0'><b>"
                                            + data[i].title
                                            + "</b></h6></br>"
                                            + "<h3 style='margin: 0' align='center'><a href='"
                                            + data[i].link
                                            + "'>"
                                            + data[i].itemTitle
                                            + "</a></h3></br>"
                                            + "<p style='margin-top: 0' align='right'>Added: "
                                            + formatDate(data[i].date.date)
                                            + "</p></div>";

                            layer.bindPopup(popupText);

                            var figureLayer = L.layerGroup().addLayer(layer).addTo(map);
                        }
                    }
                });
            }
        });
    }

    showPoints($('#page-type').data('type'));
});
