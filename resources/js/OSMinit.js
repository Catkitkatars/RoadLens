import L from 'leaflet';
import 'leaflet-geotag-photo';


var map = L.map('map', {
    center: [52.43369, 6.83442],
    zoom: 17
});


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="#">RoadLens</a>'
}).addTo(map);

// let newZoom = L.control.zoom({ position: 'topright' });
// newZoom.addTo(map);


// Создаем класс пользовательского элемента управления
var CustomControl = L.Control.extend({
    options: {
        position: 'bottomleft' // Позиция кнопки на карте
    },

    onAdd: function(map) {
        // Создаем контейнер для кнопки
        var container = L.DomUtil.create('div', 'addButton');

        // Создаем кнопку и добавляем ее в контейнер
        let button = L.DomUtil.create('a', 'custom-button', container);
        button.innerHTML = 'Добавить камеру';

        // Обработчик события клика на кнопку
        L.DomEvent.on(button, 'click', function() {
            alert('Вы нажали кнопку!');
        });

        return container; // Возвращаем контейнер с кнопкой
    }
});

// Добавляем пользовательский элемент управления на карту
map.addControl(new CustomControl());

let pointsCollection = {
    point1: {
        id: 1,
        camera: [6.82775, 52.43377],
        target: [6.83085, 52.43385]
    },
    point2: {
        id: 2,
        camera: [6.83003, 52.43382],
        target: [6.82691, 52.43369]
    },
    point3: {
        id: 3,
        camera: [6.83146, 52.43525],
        target: [6.83241, 52.43388]
    },
    point4: {
        id: 4,
        camera: [6.83489, 52.43356],
        target: [6.83276, 52.43377]
    },
    point5: {
        id: 5,
        camera: [6.83337, 52.43309],
        target: [6.83428, 52.43131]
    }
}




var options = {
    draggable: false,
    control: false,
    cameraIcon: L.icon({
        iconUrl: '../images/main-pin.png',
        iconSize: [38, 38],
        iconAnchor: [19, 35]
    }),
    targetIcon: L.icon({
        iconUrl: '../images/marker.svg',
        iconSize: [0, 0],
        iconAnchor: [16, 16]
    }),
    
    angleIcon: L.icon({
        iconUrl: '../images/marker.svg',
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


let activePoligon = null;

for (let point in pointsCollection) {

    let pointObject = {
        type: 'Feature',
        properties: {
            angle: 20,
            id: pointsCollection[point].id
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
        console.log(pointObject);
    
        // Проверяем, был ли клик на уже активном полигоне
        if (activePoligon === this) {
            // Если да, сбрасываем стили и сбрасываем активный полигон
            this.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
            activePoligon = null;
        } else {
            // Сбрасываем стили предыдущему активному полигону, если он существует
            if (activePoligon) {
                activePoligon.setStyle({ fillColor: '#032b2d', fillOpacity: 0.3 });
            }
            // Устанавливаем стили для нового активного полигона
            this.setStyle({ fillColor: '#056c71', fillOpacity: 0.7 });
            activePoligon = this;
        }
    })
    .on('mouseover', function (e) {
        if(activePoligon != this) {
            this.setStyle({ fillColor: '#056c71' });
        }
    })
    .on('mouseout', function (e) {
        if(activePoligon != this) {
            this.setStyle({ fillColor: '#032b2d' });
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



