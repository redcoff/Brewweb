//Konfigurace mapy
// konstanty
var API = '/api';
var API_MAP = API + '/map';

// Element selector + Lokace
var mymap = L.map('mapid').setView([49.376202, 16.3100952], 7);

// Je uzivatel admin?
isAdmin = false;
$.get(API + '/user-info', function(data) {
    isAdmin = data.isAdmin === '1' ? true : false;
});

// konfigurace
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1Ijoia29yYW5kaSIsImEiOiJjanEydG00bWQwc2tsNDJwN2Z2M2R2bG02In0.uXZLY3Go9LZIX2U5Hdz8OA'
}).addTo(mymap);


// Popup
var popup = L.popup();
function onMapClick(e) {
    //console.log(e);
    var content = `
        <div class="form-group"  onsubmit="return validateMapForm()" name="mapForm">
            <h3>Přidejte kavárnu</h3>
            <form class='form add-marker map-form'> 
                <label for="exampleFormControlInput1">Jméno kavárny</label>
                <input name='name' type='text' class="form-control mb-2" id="exampleFormControlInput1"  required placeholder="The Best Café" />
                
                <label for="exampleFormControlTextarea1">Recenze</label>
                <textarea  class="form-control" id="exampleFormControlTextarea1" rows="3" required name='description' ></textarea>
                
                
                <input type='hidden' name='lat' value='${e.latlng.lat}'>
                <input type='hidden' name='lng' value='${e.latlng.lng}'>
                <button type='submit' class="btn btn-primary mb-2 mt-2">Přidat</button>
            </form>
         </div>
        `;

    var $content = $(content);  //převod do abstraktního html, nevyrenderované
    var $form = $content.find("form")[0];
    $($form).on("submit", function ($event) {     //EventListener
        $event.preventDefault();
        // console.log( $( this ).serializeArray() );
        $.post("/api/map/add", $( this ).serializeArray() ,function (data) {
            window.location.href = '/map';
            // console.log(data);
        });
    })
    popup
        .setLatLng(e.latlng)
        .setContent($content[0])
        .openOn(mymap);
}
mymap.on('click', onMapClick);

// Získávání dat
$.get(API_MAP, function(data, status) {
    // console.log(data,status);
    if(Array.isArray(data)){
        data.forEach(function(element) {

        var deleteEl = isAdmin ? `
            <div class='col-12'>
                <a class='text-primary delete-marker' href='javascript:void();'>
                    <span title='Delete marker'>[X]</span>
                </a>
            </div>
        ` : '';

        var markerView = `
                <div class='row'>

                    ${deleteEl}

                    <div class='col-12'>
                        <h1>${element.name}</h1>
                        <p>${element.description}</p>
                    </div>
                </div>
        `;
        var $markerView = $(markerView);
        $markerViewLink = $markerView.find('a.delete-marker');
        $markerViewLink.on('click', function(e){
            e.preventDefault();
            $.post(API_MAP+'/remove', element , function(data){
               window.location.href = '/map';
            });
        });

        var marker = L.marker([element.lat, element.lng]).addTo(mymap);
            marker.bindPopup($markerView[0]);
        });
    }
});

