function map() {
    var lat = 56.649933;
    var lng = -2.883092;

    var mapProp= {
        center:new google.maps.LatLng(lat, lng),
        zoom:15,
    };

    var map=new google.maps.Map(document.getElementById("map"),mapProp);

    var marker = new google.maps.Marker({
        position:new google.maps.LatLng(lat, lng),
        map: map,
        title: 'Whitehill Motors'
    });
}
