


//Konfigurace mapy
// Konstanty
var API = '/api';
var API_MAP = API + '/map';

// Element selector + Lokace
var mymap = L.map('mapid').setView([49.376202, 16.3100952], 7);

// Konfigurace
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1Ijoia29yYW5kaSIsImEiOiJjanEydG00bWQwc2tsNDJwN2Z2M2R2bG02In0.uXZLY3Go9LZIX2U5Hdz8OA'
}).addTo(mymap);

// Zkouška Markeru a Popupu
// Marker
// var marker = L.marker([50.08804, 14.42076]).addTo(mymap);

// Marker popup HTML
// marker.bindPopup("<b>Hello world!</b><br>I am a popup.");

// Popup
// var popup = L.popup();
// function onMapClick(e) {
//     popup
//         .setLatLng(e.latlng)
//         .setContent("You clicked the map at " + e.latlng.toString())
//         .openOn(mymap);
// }
// mymap.on('click', onMapClick);

// Získávání dat
$.get(API_MAP, function(data, status) {
    // console.log(data,status);
    if(Array.isArray(data)){
        console.log('data is array');
        data.forEach(function(element) {
            var marker = L.marker([element.lat, element.lng]).addTo(mymap);
            marker.bindPopup(`
			<h1>${element.name}</h1>
			<p>${element.description}</p>
			`);
        });
    }
});