import {getCenterAndZoom} from '../functions/homeFuncs.js';

export let CustomControl = L.Control.extend({
    options: {
        position: 'bottomright'
    },

    onAdd: function(map) {
        let container = L.DomUtil.create('div', 'addButton');

        let button = L.DomUtil.create('a', 'button-add', container);
        button.innerHTML = 'Добавить камеру';

    map.on('move', function() {
        updateLink(map);
    });

    function updateLink(map) {

        let link = '#'

        button.setAttribute('href', link);
    }

        updateLink(map);
        return container;
    }
});


export let pointsCollection = {
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

export let options =
[
    {
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
    },
    {
        draggable: false,
        control: false,
        cameraIcon: L.icon({
            iconUrl: '/dist/images/deleted.png',
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
            fillOpacity: 0,
            fillColor: '#032b2d'
        }
    },
]




export let cameraTypeAndModelData = [
    [
        { value: '', label: '--Выберите тип--' },
        { value: '1', label: 'Безрадарный(не шумит)' },
        { value: '2', label: 'Радарный(шумит)' },
        { value: '3', label: 'Видеоблок' },
        { value: '4', label: 'Контроль остановки' },
        { value: '5', label: 'Муляж' },
        { value: '6', label: 'Контроль светофора' },
        { value: '7', label: 'Мобильная камера' },
    ],
    [
        { value: '', label: '--Выберите модель--' },
        { value: '1', label: 'Кордон' },
        { value: '2', label: 'Арена' },
        { value: '3', label: 'Крис' },
        { value: '4', label: 'Скат' },
        { value: '7', label: 'Интегра-КДД' },
        { value: '6', label: 'Мангуст' },
        { value: '8', label: 'Азимут' },
    ]
];

export const countries = [
    { value: '', label: '--Выберите страну--' },
    { value: '1', label: 'Россия'},
    { value: '2', label: 'Беларусь'},
    { value: '3', label: 'Казахстан'},
    { value: '4', label: 'Узбекистан'},
]

export const regions = [
    [
        { value: '', label: '--Выберите регион--' },
        { value: '1', label: '1 Республика Адыгея (Адыгея)' },
        { value: '2', label: '2 Республика Башкортостан' },
        { value: '3', label: '3 Республика Бурятия' },
        { value: '4', label: '4 Республика Алтай' },
        { value: '5', label: '5 Республика Дагестан' },
        { value: '6', label: '6 Республика Ингушетия' },
        { value: '7', label: '7 Кабардино-Балкарская Республика' },
        { value: '8', label: '8 Республика Калмыкия' },
        { value: '9', label: '9 Карачаево-Черкесская Республика' },
        { value: '10', label: '10 Республика Карелия' },
        { value: '11', label: '11 Республика Коми' },
        { value: '12', label: '12 Республика Марий Эл' },
        { value: '13', label: '13 Республика Мордовия' },
        { value: '14', label: '14 Республика Саха (Якутия)' },
        { value: '15', label: '15 Республика Северная Осетия - Алания' },
        { value: '16', label: '16 Республика Татарстан (Татарстан)' },
        { value: '17', label: '17 Республика Тыва' },
        { value: '18', label: '18 Удмуртская Республика' },
        { value: '19', label: '19 Республика Хакасия' },
        { value: '20', label: '20 Чеченская Республика' },
        { value: '21', label: '21 Чувашская Республика - Чувашия' },
        { value: '22', label: '22 Алтайский край' },
        { value: '23', label: '23 Краснодарский край' },
        { value: '24', label: '24 Красноярский край' },
        { value: '25', label: '25 Приморский край' },
        { value: '26', label: '26 Ставропольский край' },
        { value: '27', label: '27 Хабаровский край' },
        { value: '28', label: '28 Амурская область' },
        { value: '29', label: '29 Архангельская область' },
        { value: '30', label: '30 Астраханская область' },
        { value: '31', label: '31 Белгородская область' },
        { value: '32', label: '32 Брянская область' },
        { value: '33', label: '33 Владимирская область' },
        { value: '34', label: '34 Волгоградская область' },
        { value: '35', label: '35 Вологодская область' },
        { value: '36', label: '36 Воронежская область' },
        { value: '37', label: '37 Ивановская область' },
        { value: '38', label: '38 Иркутская область' },
        { value: '39', label: '39 Калининградская область' },
        { value: '40', label: '40 Калужская область' },
        { value: '41', label: '41 Камчатский край' },
        { value: '42', label: '42 Кемеровская область' },
        { value: '43', label: '43 Кировская область' },
        { value: '44', label: '44 Костромская область' },
        { value: '45', label: '45 Курганская область' },
        { value: '46', label: '46 Курская область' },
        { value: '47', label: '47 Ленинградская область' },
        { value: '48', label: '48 Липецкая область' },
        { value: '49', label: '49 Магаданская область' },
        { value: '50', label: '50 Московская область' },
        { value: '51', label: '51 Мурманская область' },
        { value: '52', label: '52 Нижегородская область' },
        { value: '53', label: '53 Новгородская область' },
        { value: '54', label: '54 Новосибирская область' },
        { value: '55', label: '55 Омская область' },
        { value: '56', label: '56 Оренбургская область' },
        { value: '57', label: '57 Орловская область' },
        { value: '58', label: '58 Пензенская область' },
        { value: '59', label: '59 Пермский край' },
        { value: '60', label: '60 Псковская область' },
        { value: '61', label: '61 Ростовская область' },
        { value: '62', label: '62 Рязанская область' },
        { value: '63', label: '63 Самарская область' },
        { value: '64', label: '64 Саратовская область' },
        { value: '65', label: '65 Сахалинская область' },
        { value: '66', label: '66 Свердловская область' },
        { value: '67', label: '67 Смоленская область' },
        { value: '68', label: '68 Тамбовская область' },
        { value: '69', label: '69 Тверская область' },
        { value: '70', label: '70 Томская область' },
        { value: '71', label: '71 Тульская область' },
        { value: '72', label: '72 Тюменская область' },
        { value: '73', label: '73 Ульяновская область' },
        { value: '74', label: '74 Челябинская область' },
        { value: '75', label: '75 Забайкальский край' },
        { value: '76', label: '76 Ярославская область' },
        { value: '77', label: '77 Москва' },
        { value: '78', label: '78 Санкт-Петербург' },
        { value: '79', label: '79 Еврейская автономная область' },
        { value: '80', label: '80 Чукотский автономный округ' },
        { value: '81', label: '81 Ненецкий автономный округ' },
        { value: '82', label: '82 Ханты-Мансийский автономный округ - Югра' },
        { value: '83', label: '83 Ямало-Ненецкий автономный округ' },
        { value: '84', label: '84 Республика Крым' },
        { value: '85', label: '85 Севастополь' }
    ],
    [
        { value: '', label: '--Выберите регион--' },
        { value: '1', label: '1 Брестская область' },
        { value: '2', label: '2 Витебская область' },
        { value: '3', label: '3 Гомельская область' },
        { value: '4', label: '4 Гродненская область' },
        { value: '5', label: '5 Минская область' },
        { value: '6', label: '6 Могилёвская область' },
        { value: '7', label: '7 г. Минск' }
    ],
    [
        { value: '', label: '--Выберите регион--' },
        { value: '1', label: '1 Акмолинская область' },
        { value: '2', label: '2 Актюбинская область' },
        { value: '3', label: '3 Алматинская область' },
        { value: '4', label: '4 Атырауская область' },
        { value: '5', label: '5 Восточно-Казахстанская область' },
        { value: '6', label: '6 Жамбылская область' },
        { value: '7', label: '7 Западно-Казахстанская область' },
        { value: '8', label: '8 Карагандинская область' },
        { value: '9', label: '9 Костанайская область' },
        { value: '10', label: '10 Кызылординская область' },
        { value: '11', label: '11 Мангистауская область' },
        { value: '12', label: '12 Павлодарская область' },
        { value: '13', label: '13 Северо-Казахстанская область' },
        { value: '14', label: '14 Туркестанская область' },
        { value: '15', label: '15 г. Алматы' },
        { value: '16', label: '16 г. Нур-Султан (Астана)' }
    ],
    [
        { value: '', label: '--Выберите регион--' },
        { value: '1', label: '1 Андижанская область' },
        { value: '2', label: '2 Бухарская область' },
        { value: '3', label: '3 Джизакская область' },
        { value: '4', label: '4 Кашкадарьинская область' },
        { value: '5', label: '5 Навоийская область' },
        { value: '6', label: '6 Наманганская область' },
        { value: '7', label: '7 Республика Каракалпакстан' },
        { value: '8', label: '8 Самаркандская область' },
        { value: '9', label: '9 Сурхандарьинская область' },
        { value: '10', label: '10 Сырдарьинская область' },
        { value: '11', label: '11 Ташкентская область' },
        { value: '12', label: '12 Ферганская область' },
        { value: '13', label: '13 Хорезмская область' },
        { value: '14', label: '14 г. Ташкент' }
    ]
]
