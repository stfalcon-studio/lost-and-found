$( document ).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'examples.map-i875mjb7'
    }).addTo(map);

    var points = $("#map").data();

    console.log(points);

    for (var point in points.items) {
        if(points.items.hasOwnProperty(point)) {
            L.marker([points.items[point].latitude, points.items[point].longitude]).addTo(map);
        }
    }
});


