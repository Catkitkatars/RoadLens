import L from 'leaflet';
import 'leaflet-geotag-photo';
import {addInfoBlock, getCenterAndZoom} from './functions/homeFuncs.js';
import {pointsCollection, options} from './features/homeFeatures.js';


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

// Создаем класс пользовательского элемента управления
let CustomControl = L.Control.extend({
    options: {
        position: 'bottomright' // Позиция кнопки на карте
    },

    onAdd: function(map) {
        // Создаем контейнер для кнопки
        let container = L.DomUtil.create('div', 'addButton');

        // Создаем кнопку и добавляем ее в контейнер
        let button = L.DomUtil.create('a', 'button-add', container);
        button.innerHTML = 'Добавить камеру';

     // Обновляем ссылку при перемещении карты
    map.on('move', function() {
        updateLink(map); // Вызываем функцию обновления ссылки
    });

    // Функция обновления ссылки
    function updateLink(map) {

        // Формируем ссылку с текущими координатами и масштабом
        let link = 'http://localhost:8080/edit/' + getCenterAndZoom(map);

        // Устанавливаем ссылку в атрибут href кнопки
        button.setAttribute('href', link);
    }

    // Вызываем функцию обновления ссылки при инициализации контроллера
        updateLink(map);
        return container; // Возвращаем контейнер с кнопкой
    }
});

map.addControl(new CustomControl());

let markersGibdd = L.layerGroup();
let markersVideo = L.layerGroup();


let infoCameraBlock = document.querySelector('.section_camera_info');

let activePoligon = null;

for (let point in pointsCollection) {

    let pointObject = {
        type: 'Feature',
        properties: {
            angle: 20,
            id: pointsCollection[point].id,
            type: pointsCollection[point].type,
            model: pointsCollection[point].model,
            direction: pointsCollection[point].direction,
            speed: pointsCollection[point].speed,
            dateCreate: pointsCollection[point].dateCreate,
            lastUpdate: pointsCollection[point].lastUpdate,
        },
        geometry: {
            type: 'GeometryCollection',
            geometries: [
            {
                type: 'Point',
                coordinates: pointsCollection[point].camera
            },
            {
                type: 'Point',
                coordinates: pointsCollection[point].target
            }
            ]
        }
    }

    let marker1 = L.geotagPhoto.camera(pointObject, options)
    .on('click', function (event) {
        // Проверяем, был ли клик на уже активном полигоне
        if (activePoligon === this) {
            // Если да, сбрасываем стили и сбрасываем активный полигон
            this.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
            activePoligon = null;
            infoCameraBlock.classList.remove('section_camera_info_move');
            infoCameraBlock.innerHTML = '';
        } else {
            // Сбрасываем стили предыдущему активному полигону, если он существует
            if (activePoligon) {
                activePoligon.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
                infoCameraBlock.classList.remove('section_camera_info_move');
                infoCameraBlock.innerHTML = '';
            }
            // Устанавливаем стили для нового активного полигона
            this.setStyle({ fillColor: '#056c71', fillOpacity: 0.7 });
            activePoligon = this;
            infoCameraBlock.classList.add('section_camera_info_move');
            infoCameraBlock.innerHTML = addInfoBlock(pointObject);
            
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


markersGibdd.addTo(map);
markersVideo.addTo(map);

let overlayMaps = {
    'гибдд': markersGibdd,
    'видео': markersVideo,
}

L.control.layers(null, overlayMaps).addTo(map);



