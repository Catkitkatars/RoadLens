import L from 'leaflet';
import 'leaflet-geotag-photo';
import {calculateNewLatLng, convertSouthZeroToAzimuth} from './functions/GeotagAddFunctions.js';
import {options} from './features/editFeatures.js';
import Choices from 'choices.js';


var cameraPoint = [6.83442, 52.43369]
var targetPoint = [6.83342, 52.43469]

let mapEdit = L.map('map', {
    center: [cameraPoint[1], cameraPoint[0]],
    zoom: 17
});


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="#">RoadLens</a>'
}).addTo(mapEdit);


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

let marker = L.geotagPhoto.camera(points, options).addTo(mapEdit);

let fieldOfView = marker.getFieldOfView();
let cameraLatLng = marker.getCameraLatLng();

target_latitude.value = marker.getTargetLatLng().lat.toFixed(6);
target_longitude.value = marker.getTargetLatLng().lng.toFixed(6);
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
    mapEdit.setView([latitude.value, longitude.value], 17);
});

longitude.addEventListener('input', function() {
    mapEdit.setView([latitude.value, longitude.value], 17);
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

    target_latitude.value = marker.getTargetLatLng().lat.toFixed(6);
    target_longitude.value = marker.getTargetLatLng().lng.toFixed(6);

    inputChanged = false;
})

direction.addEventListener('input', function (event){
    inputChanged = true;
    if(direction.value >= 360){
        direction.value = 0;
    }

    let dist = distance.value; // дистанция в метрах
    let bearing = convertSouthZeroToAzimuth(direction.value)  // направление в градусах

    let newLatLng = calculateNewLatLng(marker.getCameraLatLng(), dist, bearing);

    marker.setTargetLatLng(newLatLng);

    target_latitude.value = marker.getTargetLatLng().lat.toFixed(6);
    target_longitude.value = marker.getTargetLatLng().lng.toFixed(6);


    inputChanged = false;
})


marker.on('change', function (event) {
    if (!inputChanged) {
        let fieldOfView = marker.getFieldOfView();
        let cameraLatLng = marker.getCameraLatLng();


        latitude.value = cameraLatLng.lat.toFixed(6);
        longitude.value = cameraLatLng.lng.toFixed(6);

        target_latitude.value = marker.getTargetLatLng().lat.toFixed(6);
        target_longitude.value = marker.getTargetLatLng().lng.toFixed(6);

        direction.value = Math.round(fieldOfView.properties.bearing);
        angle.value = Math.round(fieldOfView.properties.angle);
        distance.value = Math.round(fieldOfView.properties.distance);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    let selectCountry = () => {
        let elemCountry = document.getElementById('countries');
        let choicesCountry = new Choices(elemCountry, {
            silent: true,
            allowHTML: true,
            searchResultLimit: 1,
            searchFields: ['label'],
            itemSelectText: 'Выбрать',
        });
    }
    selectCountry();

    let selectRegion = () => {
        let elemRegion = document.getElementById('regions');
        let choicesRegion = new Choices(elemRegion, {
            silent: true,
            allowHTML: true,
            searchResultLimit: 3,
            searchFields: ['label'],
            itemSelectText: 'Выбрать',
        });
    }
    selectRegion();

    let selectType = () => {
        let elemType = document.getElementById('type');
        let choicesType = new Choices(elemType, {
            allowHTML: true,
            searchResultLimit: 1,
            searchFields: ['label'],
            itemSelectText: 'Выбрать',
        });
    }
    selectType();

    let selectModel = () => {
        let elemModel = document.getElementById('model');
        let choicesModel= new Choices(elemModel, {
            allowHTML: true,
            searchResultLimit: 1,
            searchFields: ['label'],
            itemSelectText: 'Выбрать',
        });
    }
    selectModel();


});


