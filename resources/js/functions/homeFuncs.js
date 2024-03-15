import L from 'leaflet'; 
import 'leaflet-geotag-photo';
import {options, cameraTypeAndModelData} from '../features/homeFeatures';


export function addInfoBlock(object) {
    return `
    <div class="side_camera_block">
        <span class="icon-closed material-symbols-outlined">
        close
        </span>
        <div class="info-box">
            <h3 class="name-block_h3">Инфо</h3>
            <div class="info-box_specification">
                <p>UUID:</p>
                <div class="line-style"></div>
                <h5>${object.properties.uuid}</h5>
            </div>
            <div class="info-box_specification">
                <p>Тип:</p>
                <div class="line-style"></div>
                <h5>${object.properties.type}</h5>
            </div>
            <div class="info-box_specification">
                <p>Модель:</p>
                <div class="line-style"></div>
                <h5>${object.properties.model}</h5>
            </div>
            <div class="info-box_specification">
                <p>Скорость легковые:</p>
                <div class="line-style"></div>
                <h5>${object.properties.car_speed}</h5>
            </div>
            <div class="info-box_specification">
                <p>Скорость грузовые:</p>
                <div class="line-style"></div>
                <h5>${object.properties.truck_speed}</h5>
            </div>
            <div class="info-box_specification">
                <p>Модератор:</p>
                <div class="line-style"></div>
                <h5>${object.properties.user}</h5>
            </div>
            <div class="info-box_specification">
                <p>Дата создания:</p>
                <div class="line-style"></div>
                <h5>${object.properties.dateCreate}</h5>
            </div>
            <div class="info-box_specification">
                <p>Дата последних изменений:</p>
                <div class="line-style"></div>
                <h5>${object.properties.lastUpdate}</h5>
            </div>
            <div class="edit-submit">
                <a href="localhost:8080/edit/${object.properties.id}">
                    Изменить
                </a>
            </div>
        </div>
    </div>`;
}


export function getCenterAndZoom(map) {

    let center = map.getCenter();
    let zoom = map.getZoom();

    return `${center.lat.toFixed(6)}/${center.lng.toFixed(6)}/${zoom}`;
}

export function updateIcon(cameraType) {
    return L.icon({
        iconUrl: `/dist/images/${cameraType}.png`,
        iconSize: [38, 38],
        iconAnchor: [19, 35]
    });
}

export function transformValuesInObj(object, cameraTypeAndModelData) {
    object.properties.type = cameraTypeAndModelData[0][parseInt(object.properties.type)].label
    object.properties.model = cameraTypeAndModelData[1][parseInt(object.properties.model)].label
    object.properties.angle = parseInt(object.properties.angle);
    object.geometry.geometries[0].coordinates = [parseFloat(object.geometry.geometries[0].coordinates[0]),parseFloat(object.geometry.geometries[0].coordinates[1])];
    object.geometry.geometries[1].coordinates = [parseFloat(object.geometry.geometries[1].coordinates[0]),parseFloat(object.geometry.geometries[1].coordinates[1])];


    return object;
}

export function initializeMap(latitude, longitude, zoomLevel) {
    let map = L.map('map', {
        center: [latitude, longitude],
        zoom: zoomLevel
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="#">RoadLens</a>'
    }).addTo(map);

    return map;
}

export function updateURL(map) {
    map.on('moveend', function(event){
        let newUrl = `http://localhost:8080/map/` + getCenterAndZoom(map);
        window.history.replaceState({}, '', newUrl);
    });
}

window.uuids = [];

function checkUuid(array, uuid) {
    return array.includes(uuid); 
}

export function fetchDataAndDisplayMarkers(map, infoCameraBlock) {
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
            if(checkUuid(window.uuids, cameras[cameraObj].properties.uuid)){
                continue;
            }
            window.uuids.push(cameras[cameraObj].properties.uuid)

            options.cameraIcon = updateIcon(cameras[cameraObj].properties.type);
            let handleCameraObj = transformValuesInObj(cameras[cameraObj], cameraTypeAndModelData); 

            let marker = L.geotagPhoto.camera(handleCameraObj, options)
            
                if(infoCameraBlock === null) {
                    marker.addTo(map)
                }
                else 
                {
                    marker.on('click', function (event) {
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
                    })
        
                   .addTo(map)
                }
            
            
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

export function updateMapData(map, infoCameraBlock) {
    map.on('moveend', function(event) {
        fetchDataAndDisplayMarkers(map, infoCameraBlock);
    });

    map.on('zoomend', function(event) {
        fetchDataAndDisplayMarkers(map, infoCameraBlock);
    });
}