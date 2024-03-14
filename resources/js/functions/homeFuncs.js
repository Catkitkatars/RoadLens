


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
    object.properties.type = cameraTypeAndModelData[0][parseInt(object.properties.type) - 1]
    object.properties.model = cameraTypeAndModelData[1][parseInt(object.properties.model) - 1]
    object.properties.angle = parseInt(object.properties.angle);
    object.geometry.geometries[0].coordinates = [parseFloat(object.geometry.geometries[0].coordinates[0]),parseFloat(object.geometry.geometries[0].coordinates[1])];
    object.geometry.geometries[1].coordinates = [parseFloat(object.geometry.geometries[1].coordinates[0]),parseFloat(object.geometry.geometries[1].coordinates[1])];


    return object;
}
