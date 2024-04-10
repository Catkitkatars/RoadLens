import {cameraTypeAndModelData, options} from "../features/homeFeatures.js";
import L from "leaflet";
import {addInfoBlock, createPolyline, updateIcon} from "./homeFuncs.js";
export function checkUlidEdit(array, ulid) {
    return array.includes(ulid);
}

export function changePolyline() {

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
export function fetchDataAndDisplayMarkersEdit(map, editedCamera) {
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
                        let sectionId = null;
                        let coordsForPolyline = [];

                        cameras[cameraObj][sectionCamera].forEach(element => {
                            if(checkUlidEdit(window.ulids, element.properties.ulid)){
                                return;
                            }
                            window.ulids.push(element.properties.ulid)
                            if(editedCamera._fieldOfView.properties.ulid === element.properties.ulid) {
                                coordsForPolyline.push(
                                    [
                                        editedCamera._fieldOfView.geometry.geometries[0].coordinates[1],
                                        editedCamera._fieldOfView.geometry.geometries[0].coordinates[0]
                                    ]
                                );
                                return;
                            }
                            options[0].cameraIcon = updateIcon(element.properties.type);
                            marker = L.geotagPhoto.camera(element, options[0]);

                            coordsForPolyline.push([marker.getCameraLatLng().lat, marker.getCameraLatLng().lng]);
                            marker.properties = element.properties;
                            marker.addTo(map);
                            addListeners(marker);
                        });
                        sectionId = Number(cameras[cameraObj][sectionCamera][0].properties.isASC);
                        let flag = false;
                        for(let key in window.polylines) {
                            if(Number(key) === sectionId) {
                                flag = true;
                            }
                        }

                        if(flag) {
                            continue;
                        }

                        let polyline = createPolyline(coordsForPolyline)

                        polyline.line.addTo(map);
                        polyline.arrow.addTo(map);

                        window.polylines[sectionId] = polyline;
                    }
                    continue;
                }

                if(editedCamera._fieldOfView.properties.ulid === cameras[cameraObj].properties.ulid) {
                    continue;
                }
                if(checkUlidEdit(window.ulids, cameras[cameraObj].properties.ulid)){
                    continue;
                }

                window.ulids.push(cameras[cameraObj].properties.ulid)

                if(cameras[cameraObj].properties.isDeleted == '0')
                {
                    options[0].cameraIcon = updateIcon(cameras[cameraObj].properties.type);
                    marker = L.geotagPhoto.camera(cameras[cameraObj], options[0])
                    marker.properties = cameras[cameraObj].properties;
                    marker.addTo(map);
                }
                else if(cameras[cameraObj].properties.isDeleted == '1')
                {
                    marker = L.geotagPhoto.camera(cameras[cameraObj], options[1])
                    marker.properties = cameras[cameraObj].properties;
                    marker.addTo(map);
                }
                addListeners(marker);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
export function updateMapDataEdit(map, editedCamera) {
    map.on('moveend', function(event) {
        fetchDataAndDisplayMarkersEdit(map, editedCamera);
    });

    map.on('zoomend', function(event) {
        fetchDataAndDisplayMarkersEdit(map, editedCamera);
    });
}
