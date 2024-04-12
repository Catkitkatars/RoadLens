import L from 'leaflet';
import 'leaflet-geotag-photo';
import './functions/homeFuncs.js';
import {calculateNewLatLng, convertSouthZeroToAzimuth} from './functions/GeotagAddFunctions.js';
import {cameraTypeAndModelData, countries, regions} from './features/homeFeatures.js';
import {options, selectOptions} from './features/editFeatures.js';
import Choices from 'choices.js';
import {updateMapDataEdit, fetchDataAndDisplayMarkersEdit} from "./functions/editFuncs.js";
import {createPolyline} from "./functions/homeFuncs.js";

window.polylines =[];

let cameraPoint = [parseFloat(longitude.value), parseFloat(latitude.value)]
let targetCoords = null;

if(target_latitude.value == '' && target_longitude.value == '') {

    targetCoords = calculateNewLatLng(L.latLng(latitude.value, longitude.value), 300, 90);
}
else
{
    targetCoords = {
        lat: parseFloat(target_latitude.value),
        lng: parseFloat(target_longitude.value)
    };
}


let targetPoint = [targetCoords.lng, targetCoords.lat]

let mapEdit = L.map('map', {
    center: [cameraPoint[1], cameraPoint[0]],
    zoom: 16
});

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="#">RoadLens</a>'
}).addTo(mapEdit);


let angleElement = document.getElementById('angle');

let angleValue = angleElement.value ? angleElement.value : 20;

let point = {
    type: 'Feature',
    properties: {
        angle: parseInt(angleValue),
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

let ulid = document.getElementById('ulid');

if(ulid && ulid.value !== null) {
    point.properties.ulid = ulid.value;
}

let marker = L.geotagPhoto.camera(point, options).addTo(mapEdit);

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

    inputChanged = false;
})

distance.addEventListener('input', function (event){
    inputChanged = true;

    let dist = distance.value;
    let bearing = convertSouthZeroToAzimuth(direction.value)

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

    let dist = distance.value;
    let bearing = convertSouthZeroToAzimuth(direction.value)

    let newLatLng = calculateNewLatLng(marker.getCameraLatLng(), dist, bearing);

    marker.setTargetLatLng(newLatLng);

    target_latitude.value = marker.getTargetLatLng().lat.toFixed(6);
    target_longitude.value = marker.getTargetLatLng().lng.toFixed(6);


    inputChanged = false;
})


marker.on('input', function (event) {
    if (!inputChanged) {
        let fieldOfView = marker.getFieldOfView();
        let cameraLatLng = marker.getCameraLatLng();
        let previousLat = parseFloat(latitude.value);
        let previousLng = parseFloat(longitude.value);

        let newLat = latitude.value = cameraLatLng.lat.toFixed(6);
        let newLng = longitude.value = cameraLatLng.lng.toFixed(6);

        let newCoords = []

        if(isASC.value !== '0'){
            for(let coords in window.polylines[isASC.value].line.getLatLngs()) {
                if(
                    previousLat === window.polylines[isASC.value].line.getLatLngs()[coords].lat
                    &&
                    previousLng === window.polylines[isASC.value].line.getLatLngs()[coords].lng
                )
                {
                    newCoords.push([
                        parseFloat(newLat),
                        parseFloat(newLng)
                    ]);
                    continue;
                }
                newCoords.push([
                    parseFloat(window.polylines[isASC.value].line.getLatLngs()[coords].lat),
                    parseFloat(window.polylines[isASC.value].line.getLatLngs()[coords].lng)
                ]);
            }
            window.polylines[isASC.value].line.remove();
            window.polylines[isASC.value].arrow.remove();
            window.polylines[isASC.value] = createPolyline(newCoords);
            window.polylines[isASC.value].line.addTo(mapEdit);
            window.polylines[isASC.value].arrow.addTo(mapEdit);
        }



        target_latitude.value = marker.getTargetLatLng().lat.toFixed(6);
        target_longitude.value = marker.getTargetLatLng().lng.toFixed(6);

        direction.value = Math.round(fieldOfView.properties.bearing);
        angle.value = Math.round(fieldOfView.properties.angle);
        distance.value = Math.round(fieldOfView.properties.distance);
    }
});


let selectedCountry = selectCountries.options[selectCountries.selectedIndex] ? selectCountries.options[selectCountries.selectedIndex].value : '';
let selectedRegion = selectRegions.options[selectRegions.selectedIndex] ? selectRegions.options[selectRegions.selectedIndex].value : '';
let selectedType = selectType.options[selectType.selectedIndex] ? selectType.options[selectType.selectedIndex].value : '';
let selectedModel = selectModel.options[selectModel.selectedIndex] ? selectModel.options[selectModel.selectedIndex].value : '';


document.addEventListener('DOMContentLoaded', function() {

    //Add Choices on four <selectors>

    new Choices("#selectCountries", selectOptions)
            .setChoices(countries, 'value', 'label', true)
            .setChoiceByValue(selectedCountry)

    let selectRegions = new Choices("#selectRegions", selectOptions)
                                .setChoices([{ value: '', label: '--Выберите регион--' }], 'value', 'label', true)
                                .setChoiceByValue(selectedCountry)

    if(selectCountries.value) {
        selectRegions
            .clearStore()
            .clearChoices()
            .setChoices(regions[selectCountries.value - 1], 'value', 'label')
            .setChoiceByValue(selectedRegion)
    }

    selectCountries.addEventListener('change',function(event) {
        let selectedValue = event.target.value;

        if(selectedValue === '') {
            selectRegions
                .clearStore()
                .clearChoices()
                .setChoices([{ value: '', label: '--Выберите регион--' }], 'value', 'label')
                .setChoiceByValue('')
        }
        else
        {
            selectRegions
                .clearStore()
                .clearChoices()
                .setChoices(regions[selectedValue - 1], 'value', 'label')
                .setChoiceByValue('')
        }

    });


    new Choices("#selectType", selectOptions)
            .setChoices(
                cameraTypeAndModelData[0],
                'value', 'label', true)
            .setChoiceByValue(selectedType)

    new Choices("#selectModel", selectOptions)
            .setChoices(
                cameraTypeAndModelData[1],
                'value', 'label', true)
            .setChoiceByValue(selectedModel)

});


fetchDataAndDisplayMarkersEdit(mapEdit, marker);
updateMapDataEdit(mapEdit, marker)

