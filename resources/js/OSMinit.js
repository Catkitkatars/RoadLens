import {CustomControl} from './features/homeFeatures.js';
import {initializeMap, updateURL, fetchDataAndDisplayMarkers, updateMapData, mouseOverOut} from './functions/homeFuncs.js';




let currentURL = window.location.href;
let urlParts = currentURL.split('/');
let latitude = parseFloat(urlParts[urlParts.length - 3]);
let longitude = parseFloat(urlParts[urlParts.length - 2]);
let zoomLevel = parseInt(urlParts[urlParts.length - 1])


let layerGroups = {
    camerasLayer: L.layerGroup(),
    averageSpeedLayer: L.layerGroup(),
    deletedsLayer: L.layerGroup(),
    
}

let layersControl = L.control.layers(null, {
    "Контроль ПДД": layerGroups.camerasLayer,
    "КСС": layerGroups.averageSpeedLayer,
    "Удалены": layerGroups.deletedsLayer,
})

let map = initializeMap(latitude, longitude, zoomLevel);

updateURL(map);
fetchDataAndDisplayMarkers(map,  layerGroups);
layersControl.addTo(map);
map.addLayer(layerGroups.camerasLayer);
map.addLayer(layerGroups.averageSpeedLayer);
map.addLayer(layerGroups.deletedsLayer);
map.addControl(new CustomControl());
updateMapData(map, layerGroups);

