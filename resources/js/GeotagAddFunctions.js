function calculateNewLatLng(cameraLatLng, distance, bearing) {
    const radiusEarth = 6371000;

    const lat1 = cameraLatLng.lat * Math.PI / 180;
    const lng1 = cameraLatLng.lng * Math.PI / 180;
    const brng = bearing * Math.PI / 180;

    const lat2 = Math.asin(Math.sin(lat1) * Math.cos(distance / radiusEarth) +
        Math.cos(lat1) * Math.sin(distance / radiusEarth) * Math.cos(brng));

    const lng2 = lng1 + Math.atan2(Math.sin(brng) * Math.sin(distance / radiusEarth) * Math.cos(lat1),
        Math.cos(distance / radiusEarth) - Math.sin(lat1) * Math.sin(lat2));

    return L.latLng(lat2 * 180 / Math.PI, lng2 * 180 / Math.PI);
}


function convertSouthZeroToAzimuth(azimuth) {
    azimuth -= 180;

    if (azimuth < -180) {
        azimuth += 360;
    } else if (azimuth >= 180) {
        azimuth -= 360;
    }

    return azimuth;
}