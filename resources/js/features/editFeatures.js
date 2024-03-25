
export let options = {
    draggable: true,
    angleMarker: true, 
    control: false,
    cameraIcon: L.icon({
        iconUrl: '/dist/images/main-pin.png',
        iconSize: [38, 38],
        iconAnchor: [19, 35]
    }),
    targetIcon: L.icon({
        iconUrl: '/dist/images/marker.svg',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    }),
    
    angleIcon: L.icon({
        iconUrl: '/dist/images/marker.svg',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    }),
    outlineStyle: {
        color: '#03e9f4',
        opacity: .5,
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


export const selectOptions = {
    allowHTML: true,
    placeholder: true,
    searchEnabled: true,
    searchPlaceholderValue: 'Поиск',
    removeItemButton: false,
    shouldSort: false, 
    itemSelectText: 'Выбрать',
    removeItems: true
};