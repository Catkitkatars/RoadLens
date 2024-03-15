import {CustomControl} from './features/homeFeatures.js';
import {initializeMap, updateURL, fetchDataAndDisplayMarkers, updateMapData} from './functions/homeFuncs.js';




let currentURL = window.location.href;
let urlParts = currentURL.split('/');
let infoCameraBlock = document.querySelector('.section_camera_info');
let latitude = parseFloat(urlParts[urlParts.length - 3]);
let longitude = parseFloat(urlParts[urlParts.length - 2]);
let zoomLevel = parseInt(urlParts[urlParts.length - 1])

let map = initializeMap(latitude, longitude, zoomLevel);
updateURL(map);
fetchDataAndDisplayMarkers(map, infoCameraBlock);
map.addControl(new CustomControl());
updateMapData(map, infoCameraBlock);
