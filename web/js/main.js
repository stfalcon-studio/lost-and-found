$(document).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var points = $("#map").data();

    for (var point in points.items) {
        if(points.items.hasOwnProperty(point)) {
            L.marker([points.items[point].latitude, points.items[point].longitude]).addTo(map);
        }
    }

    var markers = new L.FeatureGroup();

    function showPoints(type) {
        var categories;
        $.ajax({
            url: 'http://lost-and-found.work/app_dev.php/get/categories',
            type: 'get',
            dataType: 'JSON',
            success: function(data){
                   categories=new Object(data);
                $.ajax({
                    url: 'http://lost-and-found.work/app_dev.php/show/' + type + '-points',
                    type: 'get',
                    dataType: 'JSON',
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            var cat=categories[data[i].categoryId];
                            if(cat['imageName']!==null) {
                                var icon = L.icon({
                                    iconUrl: cat['imageName'],
                                    iconSize: [32, 32]
                                });
                                marker = L.marker([data[i].latitude, data[i].longitude], {icon: icon});
                            } else {
                                marker = L.marker([data[i].latitude, data[i].longitude]);
                            }
                            markers.addLayer(marker);
                        }
                    }
                });
            }
        });
        map.addLayer(markers);
    }

    showPoints('found');

    $('#show-found-items').on('click', function() {
        markers.clearLayers();
        showPoints('found');
    });

    $('#show-lost-items').on('click', function() {
        markers.clearLayers();
        showPoints('lost');
    });
});
