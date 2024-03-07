


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
                <h5>${object.properties.id}</h5>
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
                <p>Направление:</p>
                <div class="line-style"></div>
                <h5>${object.properties.direction}</h5>
            </div>
            <div class="info-box_specification">
                <p>Скорость:</p>
                <div class="line-style"></div>
                <h5>${object.properties.speed}</h5>
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
                <a href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Изменить
                </a>
            </div>
        </div>
    </div>`;
}