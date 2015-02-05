$(document).ready(function() {
    var map = L.map('map').setView([48.76375572, 31.62963867], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);


    function showPoint() {
        var categories;
        $.ajax({
            url: 'http://lost-and-found.work/app_dev.php/get/categories',
            type: 'get',
            dataType: 'JSON',
            success: function(data){
                var latitude = $("#latitude").text();
                var longitude = $("#longitude").text();
                var category = $("#category").text();
                console.log(data);
                var cat;
                var imageName = null;
                $.each(data,function(key, value){
                     if(value.title === category){
                         cat=value;
                     }
                });
                console.log(cat);
                imageName = cat.imageName;
                if(imageName!==null) {
                    var icon = L.icon({
                        iconUrl: imageName,
                        iconSize: [32, 32]
                    });
                    L.marker([latitude,longitude],{icon:icon}).addTo(map);
                } else {
                    L.marker([latitude,longitude]).addTo(map);
                }
            }
        });
    }

    showPoint();
});