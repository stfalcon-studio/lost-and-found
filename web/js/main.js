$(document).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                     '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                     'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'examples.map-i875mjb7'
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
                console.log(categories);
            }
        });
        $.ajax({
            url: 'http://lost-and-found.work/app_dev.php/show/' + type + '-points',
            type: 'get',
            dataType: 'JSON',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    var cat=categories[data[i].categoryId];
                    var icon = L.icon({
                        iconUrl: '../images/categories/'+cat['imageName'],
                        iconSize:     [32, 32]
                         });
                    marker = L.marker([data[i].latitude, data[i].longitude], {icon: icon});
                    markers.addLayer(marker);
                }
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
