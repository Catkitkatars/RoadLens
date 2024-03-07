import L from 'leaflet';
import 'leaflet-geotag-photo';
import {addInfoBlock} from './homeFunc.js';


var map = L.map('map', {
    center: [52.43369, 6.83442],
    zoom: 17
});


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="#">RoadLens</a>'
}).addTo(map);

let center = map.getCenter();
let zoom = map.getZoom();
let newUrl = `http://localhost:8080/map/${center.lat.toFixed(6)}/${center.lng.toFixed(6)}/${zoom}`;
window.history.replaceState({}, '', newUrl);

map.on('moveend', function(event){
    // Получаем текущие координаты центра карты
    var center = map.getCenter();
    // Получаем текущий уровень масштабирования (zoom)
    var zoom = map.getZoom();
    
    // Формируем новую ссылку на основе текущих координат и уровня масштабирования
    var newUrl = `http://localhost:8080/map/${center.lat.toFixed(6)}/${center.lng.toFixed(6)}/${zoom}`;
    
    // Устанавливаем новый URL
    window.history.replaceState({}, '', newUrl);
});

// Создаем класс пользовательского элемента управления
var CustomControl = L.Control.extend({
    options: {
        position: 'bottomright' // Позиция кнопки на карте
    },

    onAdd: function(map) {
        // Создаем контейнер для кнопки
        var container = L.DomUtil.create('div', 'addButton');

        // Создаем кнопку и добавляем ее в контейнер
        let button = L.DomUtil.create('a', 'button-add', container);
        button.innerHTML = 'Добавить камеру';

        // Обработчик события клика на кнопку
        L.DomEvent.on(button, 'click', function() {
            alert('Вы нажали кнопку!');
        });

        return container; // Возвращаем контейнер с кнопкой
    }
});


map.addControl(new CustomControl());

let pointsCollection = {
    point1: {
        id: 1,
        type: "Маломощный",
        model: "Автоураган",
        direction: "В спину",
        speed: 60,
        dateCreate: "18.02.2024",
        lastUpdate: "20.02.2024",
        camera: [6.82775, 52.43377],
        target: [6.83085, 52.43385]
    },
    point2: {
        id: 2,
        type: "Стационарный",
        model: "Кордон",
        direction: "В лоб",
        speed: 80,
        dateCreate: "16.02.2024",
        lastUpdate: "22.02.2024",
        camera: [6.83003, 52.43382],
        target: [6.82691, 52.43369]
    },
    point3: {
        id: 3,
        type: "Контроль светофора",
        model: "Кордон",
        direction: "В лоб",
        speed: 40,
        dateCreate: "10.02.2024",
        lastUpdate: "10.02.2024",
        camera: [6.83146, 52.43525],
        target: [6.83241, 52.43388]
    },
    point4: {
        id: 4,
        type: "Видеоблок",
        model: "Стрелка",
        direction: "В спину",
        speed: 0,
        dateCreate: "14.02.2024",
        lastUpdate: "14.02.2024",
        camera: [6.83489, 52.43356],
        target: [6.83276, 52.43377]
    },
    point5: {
        id: 5,
        type: "Тренога",
        model: "Скат",
        direction: "В спину",
        speed: 90,
        dateCreate: "01.02.2024",
        lastUpdate: "13.02.2024",
        camera: [6.83337, 52.43309],
        target: [6.83428, 52.43131]
    }
}




var options = {
    draggable: false,
    control: false,
    cameraIcon: L.icon({
        iconUrl: '/dist/images/main-pin.png',
        iconSize: [38, 38],
        iconAnchor: [19, 35]
    }),
    targetIcon: L.icon({
        iconUrl: '/dist/images/marker.svg',
        iconSize: [0, 0],
        iconAnchor: [16, 16]
    }),
    
    angleIcon: L.icon({
        iconUrl: '/dist/images/marker.svg',
        iconSize: [0, 0],
        iconAnchor: [16, 16]
    }),
    outlineStyle: {
        color: '#03e9f4',
        opacity: 0,
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



