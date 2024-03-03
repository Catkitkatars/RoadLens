import L from 'leaflet';
import 'leaflet-geotag-photo';


// var map = L.map('map', {
//     center: [52.43369, 6.83442],
//     zoom: 17
// });


// L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: '&copy; <a href="#">RoadLens</a>'
// }).addTo(map);

// var cameraPoint = [56.837942, 60.603636]
// var targetPoint = [56.841568, 60.602252]


var cameraPoint = [6.83442, 52.43369]
var targetPoint = [6.83342, 52.43469]

var cameraPoint2 = [6.83542, 52.43269]
var targetPoint2 = [6.83242, 52.43569]

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

var points2 = {
    type: 'Feature',
    properties: {
        angle: 20
    },
    geometry: {
        type: 'GeometryCollection',
        geometries: [
        {
            type: 'Point',
            coordinates: cameraPoint2
        },
        {
            type: 'Point',
            coordinates: targetPoint2
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


// let markersGibdd = L.layerGroup();
// let markersVideo = L.layerGroup();

// let marker1 = L.geotagPhoto.camera(points, options);
// markersGibdd.addLayer(marker1);

// let marker2 = L.geotagPhoto.camera(points2, options);


// let fieldOfView = marker2.getFieldOfView();
// let cameraLatLng = marker2.getCameraLatLng();


// latitude.value = cameraLatLng.lat.toFixed(6);
// longitude.value = cameraLatLng.lng.toFixed(6);
// direction.value = Math.round(fieldOfView.properties.bearing);
// angle.value = Math.round(fieldOfView.properties.angle);
// distance.value = Math.round(fieldOfView.properties.distance);




// console.log(latLng);



// markersVideo.addLayer(marker2);

// markersGibdd.addTo(map);
// markersVideo.addTo(map);

// let overlayMaps = {
    // 'гибдд': markersGibdd,
    // 'видео': markersVideo,
// }

// L.control.layers(null, overlayMaps).addTo(map);






