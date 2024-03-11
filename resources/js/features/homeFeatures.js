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

export const options = {
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
