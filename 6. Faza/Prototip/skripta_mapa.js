//Za Mapu

var map = L.map('mapid').setView([44.272741, 19.890531], 20);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright ">OpenStreetMap</a> contributors'
}).addTo(map);
L.marker([44.272741, 19.890531]).addTo(map)
    .bindPopup('Apartman Aleksandar.')
    .openPopup();
