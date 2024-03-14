import L from 'leaflet';
import 'leaflet-geotag-photo';
import {addInfoBlock, getCenterAndZoom, transformValuesInObj, updateIcon} from './functions/homeFuncs.js';
import {pointsCollection, options, cameraTypeAndModelData, CustomControl} from './features/homeFeatures.js';


var map = L.map('map', {
    center: [52.43369, 6.83442],
    zoom: 17
});


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="#">RoadLens</a>'
}).addTo(map);

let newUrl = `http://localhost:8080/map/${latitude.toFixed(6)}/${longitude.toFixed(6)}/${zoom}`;
window.history.replaceState({}, '', newUrl);

map.on('moveend', function(event){
    let newUrl = `http://localhost:8080/map/` + getCenterAndZoom(map);

    window.history.replaceState({}, '', newUrl);
});

map.addControl(new CustomControl());

let markersGibdd = L.layerGroup();
let markersVideo = L.layerGroup();


let infoCameraBlock = document.querySelector('.section_camera_info');

let bounds = map.getBounds();

let requestData = {
    northEastLat: bounds._northEast.lat,
    northEastLng: bounds._northEast.lng,
    southWestLat: bounds._southWest.lat,
    southWestLng: bounds._southWest.lng
};

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

fetch(`/getCameras`, {
    method: "POST",
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(requestData)
})
    .then(response => {
        if (!response.ok) {
            throw new Error('Беда');
        }
        return response.json();
    })
    .then(cameras => {
        let activePoligon = null;

        for (let cameraObj in cameras) {
            
            options.cameraIcon = updateIcon(cameras[cameraObj].properties.type);
            let handleCameraObj = transformValuesInObj(cameras[cameraObj], cameraTypeAndModelData);

            let marker1 = L.geotagPhoto.camera(handleCameraObj, options)
            .on('click', function (event) {
                if (activePoligon === this) {
                    this.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
                    activePoligon = null;
                    infoCameraBlock.classList.remove('section_camera_info_move');
                    infoCameraBlock.innerHTML = '';
                } else {
                    if (activePoligon) {
                        activePoligon.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
                        infoCameraBlock.classList.remove('section_camera_info_move');
                        infoCameraBlock.innerHTML = '';
                    }
                    this.setStyle({ fillColor: '#056c71', fillOpacity: 0.7 });
                    activePoligon = this;
                    infoCameraBlock.classList.add('section_camera_info_move');
                    infoCameraBlock.innerHTML = addInfoBlock(handleCameraObj);
                    
                    let btnClose = document.querySelector('.icon-closed');

                    btnClose.addEventListener('click', () => {
                        infoCameraBlock.classList.remove('section_camera_info_move');
                        infoCameraBlock.innerHTML = '';
                        activePoligon.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
                        activePoligon = null;
                    })
                }
            })
            .on('mouseover', function (e) {
                if(activePoligon != this) {
                    this.setStyle({ fillOpacity: 0.6 });
                }
            })
            .on('mouseout', function (e) {
                if(activePoligon != this) {
                    this.setStyle({ fillOpacity: 0.3 });
                }
            });

            markersGibdd.addLayer(marker1);
        }
        

    })
    .catch(error => {
        console.error('Error:', error);
    });




markersGibdd.addTo(map);
markersVideo.addTo(map);

let overlayMaps = {
    'гибдд': markersGibdd,
    'видео': markersVideo,
}

L.control.layers(null, overlayMaps).addTo(map);



