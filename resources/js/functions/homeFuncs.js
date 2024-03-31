import L from 'leaflet'; 
import 'leaflet-geotag-photo';
import 'leaflet-polylinedecorator';
import {options, cameraTypeAndModelData} from '../features/homeFeatures';


export function createPolyline(coords) {
    let polyline = L.polyline(coords, {
        color: 'red',
        opacity: .5,
        weight: 3
    })

    
    let decorator = L.polylineDecorator(polyline, {
        patterns: [
            {offset: 50, repeat: 50, symbol: L.Symbol.arrowHead({pixelSize: 8, polygon: false, pathOptions: {stroke: true, color: 'red', opacity: 0.5}})}
        ]
    })

    return {
        line: polyline,
        arrow: decorator,
    };
}
export function addInfoBlock(object, cameraTypeAndModelData) {
    let ASC = '';
    if(object.properties.ASC){
        let ASCNext = '';
        let ASCPrevious = '';
        let ASCSpeed =  '';
        if(object.properties.ASC.next) {
            ASCNext = `
            <div class="info-box_specification" style="padding: 1em 0; display:flex; justify-content: space-between;">
                <p>Следующая:</p>
                <p style="color:#ffffffc5">${object.properties.ASC.next}</p>
            </div>
            `;
            ASCSpeed = `
            <div class="info-box_specification" style="padding: 1em 0; display:flex; justify-content: space-between;" >
                <p>Средняя скорость:</p>
                <p style="color:#ffffffc5">${object.properties.ASC.speed}</p>
            </div>
            `;
        }
        if(object.properties.ASC && object.properties.ASC.previous) {
            ASCPrevious = `
            <div class="info-box_specification" style="padding: 1em 0; display:flex; justify-content: space-between;">
                <p>Предыдущая:</p>
                <p style="color:#ffffffc5">${object.properties.ASC.previous}</p>
            </div>
            
            `;
        }

        ASC = `
        <div style="border: 2px solid #03e9f4; position: relative; padding: 0 5px; margin: 25px 0 10px;">
        <div style="font-size: .9rem; font-family: Russo One, sans-serif; position: absolute; top:-18px; left:1.25em; padding:5px; color:#1B2A3F; background-color: #03e9f4";text-transform: uppercase; >Контроль средней скорости</div>
            ${ASCPrevious}
            ${ASCSpeed}
            ${ASCNext}
        </div>
        
        `;
    }
    


    return `
    <div class="side_camera_block">
        <span class="icon-closed material-symbols-outlined">
        close
        </span>
            <div class="info-box">
                <div style="border: 2px solid #03e9f4; position: relative; padding: 0 5px; margin: 25px 0 10px;">
                <div style="font-size: .9rem; font-family: Russo One, sans-serif; position: absolute; top:-18px; left:1.25em; padding:5px; color:#1B2A3F; background-color: #03e9f4";text-transform: uppercase; >
                    <span>ID:</span>
                    ${object.properties.ulid}
                </div>
                    <div class="info-box_specification">
                        <p>Тип:</p>
                        <h5>${cameraTypeAndModelData[0][object.properties.type].label}</h5>
                    </div>
                    <div class="line-style"></div>
                    <div class="info-box_specification">
                        <p>Модель:</p>
                        <h5>${cameraTypeAndModelData[1][object.properties.model].label}</h5>
                    </div>
                    <div class="line-style"></div>
                    <div class="info-box_specification">
                        <p>Скорость легковые:</p>
                        <h5>${object.properties.car_speed}</h5>
                    </div>
                    <div class="line-style"></div>
                    <div class="info-box_specification">
                        <p>Скорость грузовые:</p>
                        <h5>${object.properties.truck_speed}</h5>
                    </div>
                    <div class="line-style"></div>
                    <div class="info-box_specification">
                        <p>Модератор:</p>
                        <h5>${object.properties.user}</h5>
                    </div>
                    <div class="line-style"></div>
                    <div class="info-box_specification">
                        <p>Дата создания:</p>
                        <h5>${object.properties.dateCreate}</h5>
                    </div>
                    <div class="line-style"></div>
                    <div class="info-box_specification">
                        <p>Дата последних изменений:</p>
                        <h5>${object.properties.lastUpdate}</h5>
                    </div>
                    <div class="line-style"></div>
                </div>
            ${ASC}
            <div class="edit-submit">
                <a href="/edit/${object.properties.ulid}">
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




function addListeners(marker) {
    let infoCameraBlock = document.querySelector('.section_camera_info');
    marker.on('click', function(event) {
        if (window.activePoligon === this) {
            this.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
            window.activePoligon = null;
            infoCameraBlock.classList.remove('section_camera_info_move');
            infoCameraBlock.innerHTML = '';
        } else {
            if (window.activePoligon) {
                window.activePoligon.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
                infoCameraBlock.classList.remove('section_camera_info_move');
                infoCameraBlock.innerHTML = '';
            }
            this.setStyle({ fillColor: '#056c71', fillOpacity: 0.7 });
            window.activePoligon = this;
            infoCameraBlock.classList.add('section_camera_info_move');
            infoCameraBlock.innerHTML = addInfoBlock(marker, cameraTypeAndModelData);

            let btnClose = document.querySelector('.icon-closed');
            btnClose.addEventListener('click', function() {
                infoCameraBlock.classList.remove('section_camera_info_move');
                infoCameraBlock.innerHTML = '';
                window.activePoligon.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
                window.activePoligon = null;
            });
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
}

window.activePoligon = null;

function checkUlid(array, ulid) {
    return array.includes(ulid); 
}

export function fetchDataAndDisplayMarkers(map, layerGroups) {
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
            throw new Error('Response error');
        }
        return response.json();
    })
    .then(cameras => {
        let marker = null;
        for (let cameraObj in cameras) {
            if(Array.isArray(cameras[cameraObj])) {
                for(let sectionCamera in cameras[cameraObj]) {
                    let coordsForPolyline = [];
                
                    cameras[cameraObj][sectionCamera].forEach(element => {
                        if(checkUlid(window.ulids, element.properties.ulid)){
                            return;
                        }
                        window.ulids.push(element.properties.ulid)

                        options[0].cameraIcon = updateIcon(element.properties.type);
                        marker = L.geotagPhoto.camera(element, options[0]);

                        coordsForPolyline.push([marker.getCameraLatLng().lat, marker.getCameraLatLng().lng]);
                        marker.properties = element.properties;
                        layerGroups.averageSpeedLayer.addLayer(marker);
                        addListeners(marker);
                    });

                    let polyline = createPolyline(coordsForPolyline)

                    layerGroups.averageSpeedLayer.addLayer(polyline.line);
                    layerGroups.averageSpeedLayer.addLayer(polyline.arrow);

                    
                    
                }
                continue;
            }
            if(checkUlid(window.ulids, cameras[cameraObj].properties.ulid)){
                continue;
            }
            window.ulids.push(cameras[cameraObj].properties.ulid)

            if(cameras[cameraObj].properties.isDeleted == '0') 
            {
                options[0].cameraIcon = updateIcon(cameras[cameraObj].properties.type);
                marker = L.geotagPhoto.camera(cameras[cameraObj], options[0])
                marker.properties = cameras[cameraObj].properties;
                layerGroups.camerasLayer.addLayer(marker);

            }
            else if(cameras[cameraObj].properties.isDeleted == '1')
            {
                marker = L.geotagPhoto.camera(cameras[cameraObj], options[1])
                marker.properties = cameras[cameraObj].properties;
                layerGroups.deletedsLayer.addLayer(marker);

            }
            addListeners(marker);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


export function updateMapData(map, layerGroups) {
    map.on('moveend', function(event) {
        fetchDataAndDisplayMarkers(map, layerGroups);
    });

    map.on('zoomend', function(event) {
        fetchDataAndDisplayMarkers(map, layerGroups);
    });
}