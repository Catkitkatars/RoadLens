import L from 'leaflet';
import 'leaflet-geotag-photo';
// import {calculateNewLatLng, convertSouthZeroToAzimuth} from './getPersonalDetails.js'

// Настроить импорт-экспорт

function calculateNewLatLng(cameraLatLng, distance, bearing) {
    const radiusEarth = 6371000;

    const lat1 = cameraLatLng.lat * Math.PI / 180;
    const lng1 = cameraLatLng.lng * Math.PI / 180;
    const brng = bearing * Math.PI / 180;

    const lat2 = Math.asin(Math.sin(lat1) * Math.cos(distance / radiusEarth) +
        Math.cos(lat1) * Math.sin(distance / radiusEarth) * Math.cos(brng));

    const lng2 = lng1 + Math.atan2(Math.sin(brng) * Math.sin(distance / radiusEarth) * Math.cos(lat1),
        Math.cos(distance / radiusEarth) - Math.sin(lat1) * Math.sin(lat2));

    return L.latLng(lat2 * 180 / Math.PI, lng2 * 180 / Math.PI);
}


function convertSouthZeroToAzimuth(azimuth) {
    azimuth -= 180;

    if (azimuth < -180) {
        azimuth += 360;
    } else if (azimuth >= 180) {
        azimuth -= 360;
    }

    return azimuth;
}


//==========================





var cameraPoint = [6.83442, 52.43369]
var targetPoint = [6.83342, 52.43469]

let map = L.map('map', {
    center: [cameraPoint[1], cameraPoint[0]],
    zoom: 17
});


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="#">RoadLens</a>'
}).addTo(map);


var points = {
    type: 'Feature',
    properties: {
        angle: 20
    },
    geometry: {
        type: 'GeometryCollection',
        geometries: [
        {
            type: 'Point',
            coordinates: cameraPoint
        },
        {
            type: 'Point',
            coordinates: targetPoint
        }
        ]
    }
}

var options = {
    draggable: true,
    angleMarker: true, 
    control: false,
    cameraIcon: L.icon({
        iconUrl: '../images/main-pin.png',
        iconSize: [38, 38],
        iconAnchor: [19, 35]
    }),
    targetIcon: L.icon({
        iconUrl: '../images/marker.svg',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    }),
    
    angleIcon: L.icon({
        iconUrl: '../images/marker.svg',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    }),
    outlineStyle: {
        color: '#03e9f4',
        opacity: .3,
        weight: 2,
        dashArray: '1, 1',
        lineCap: 'round',
        lineJoin: 'round'
    },
    fillStyle: {
        weight: 0,
        fillOpacity: 0.3,
        fillColor: '#032b2d'
    }
}

let marker = L.geotagPhoto.camera(points, options).addTo(map);

let fieldOfView = marker.getFieldOfView();
let cameraLatLng = marker.getCameraLatLng();

latitude.value = cameraLatLng.lat.toFixed(6);
longitude.value = cameraLatLng.lng.toFixed(6);
direction.value = Math.round(fieldOfView.properties.bearing);
angle.value = Math.round(fieldOfView.properties.angle);
distance.value = Math.round(fieldOfView.properties.distance);


let inputChanged = false;

latitude.addEventListener('change', function (event){
    inputChanged = true;

    let latLng = L.latLng(latitude.value, longitude.value);

    marker.setCameraLatLng(latLng);

    let dist = distance.value; 
    let bearing = convertSouthZeroToAzimuth(direction.value)  

    let newLatLng = calculateNewLatLng(latLng, dist, bearing);

    marker.setTargetLatLng(newLatLng);

    inputChanged = false;
})

longitude.addEventListener('change', function (event){
    inputChanged = true;
    
    let latLng = L.latLng(latitude.value, longitude.value);

    marker.setCameraLatLng(latLng);

    let dist = distance.value; 
    let bearing = convertSouthZeroToAzimuth(direction.value) 

    let newLatLng = calculateNewLatLng(latLng, dist, bearing);

    marker.setTargetLatLng(newLatLng);

    inputChanged = false;
})

latitude.addEventListener('input', function() {
    // inputChanged = true;
    

    // let latLng = L.latLng(latitude.value, longitude.value);
    // let dist = distance.value; 
    // let bearing = convertSouthZeroToAzimuth(direction.value) 

    // let newLatLng = calculateNewLatLng(latLng, dist, bearing);

    // marker.setTargetLatLng(newLatLng);

    map.setView([latitude.value, longitude.value], 13);
    // inputChanged = false;
});

longitude.addEventListener('input', function() {
    // inputChanged = true;
    

    // let latLng = L.latLng(latitude.value, longitude.value);
    // let dist = distance.value; 
    // let bearing = convertSouthZeroToAzimuth(direction.value) 

    // let newLatLng = calculateNewLatLng(latLng, dist, bearing);

    // marker.setTargetLatLng(newLatLng);

    map.setView([latitude.value, longitude.value], 13);
    // inputChanged = false;
});


angle.addEventListener('input', function (event){
    inputChanged = true;
    
    let markerOptions = marker.getFieldOfView();
    
    markerOptions.properties.distance = Math.round(Number(distance.value));

    if(this.value > 180 || this.value < 5) {
        marker.setAngle(markerOptions.properties.angle);
    }
    else 
    {
        marker.setAngle(Number(this.value));
    }
    
    console.log("ширина луча")
    inputChanged = false;
})

distance.addEventListener('input', function (event){
    inputChanged = true;

    let dist = distance.value; // дистанция в метрах
    let bearing = convertSouthZeroToAzimuth(direction.value)  // направление в градусах

    let newLatLng = calculateNewLatLng(marker.getCameraLatLng(), dist, bearing);

    marker.setTargetLatLng(newLatLng);

    console.log("длина луча")
    inputChanged = false;
})

direction.addEventListener('input', function (event){
    inputChanged = true;

    let dist = distance.value; // дистанция в метрах
    let bearing = convertSouthZeroToAzimuth(direction.value)  // направление в градусах

    let newLatLng = calculateNewLatLng(marker.getCameraLatLng(), dist, bearing);

    marker.setTargetLatLng(newLatLng);

    console.log("длина луча")
    inputChanged = false;
})


marker.on('change', function (event) {
    if (!inputChanged) {
        let fieldOfView = marker.getFieldOfView();
        let cameraLatLng = marker.getCameraLatLng();


        latitude.value = cameraLatLng.lat.toFixed(6);
        longitude.value = cameraLatLng.lng.toFixed(6);
        direction.value = Math.round(fieldOfView.properties.bearing);
        angle.value = Math.round(fieldOfView.properties.angle);
        distance.value = Math.round(fieldOfView.properties.distance);
    }
});