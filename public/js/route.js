window.addEventListener("load", function () {

    let places = window.placesData || [];
 
    places = places.filter(p =>
        p.attraction &&
        p.attraction.lat !== null && p.attraction.lat !== undefined &&
        p.attraction.lng !== null && p.attraction.lng !== undefined
    );

    const routeInfoEl  = document.getElementById("routeInfo");
    const legDetailsEl = document.getElementById("legDetails");
    const summaryEl    = document.getElementById("routeSummary");
    const startBadgeEl = document.getElementById("startBadge");
    const searchStatus = document.getElementById("searchStatus");
    const btnSearch    = document.getElementById("btnSearch");
    const townSelect   = document.getElementById("townSelect");

    let map          = null;
    let currentStart = null;   

    // Initialise map  
    function initMap(centerLat, centerLng, zoom) {
        if (map) { map.remove(); map = null; }

        map = L.map('map', { zoomControl: true })
            .setView([centerLat, centerLng], zoom || 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        return map;
    }

    //  Full route: town → ordered stops 
    function drawRoute(startPoint) {

        if (!map) initMap(startPoint.lat, startPoint.lng, 12);

        // Clear existing layers except tile layer
        map.eachLayer(layer => {
            if (!(layer instanceof L.TileLayer)) map.removeLayer(layer);
        });
 
        legDetailsEl.innerHTML  = '';
        summaryEl.style.display = 'none';

        // Build ordered list: town ,attraction stops
        const allPoints = [
            { lat: startPoint.lat, lng: startPoint.lng, name: startPoint.name, isTown: true }
        ].concat(
            places.map(p => ({
                lat:  parseFloat(p.attraction.lat),
                lng:  parseFloat(p.attraction.lng),
                name: p.attraction.name,
                loc:  p.attraction.location || '',
                isTown: false
            }))
        );

        // Numbered marker icon  
        function makeIcon(num, isTown) {
            const bg = isTown ? '#e67e22' : '#1a3c2b';
            return L.divIcon({
                className: '',
                html: `
                    <div style="
                        width:32px;height:32px;
                        background:${bg};color:#fff;
                        border:2.5px solid #fff;
                        border-radius:50% 50% 50% 0;
                        transform:rotate(-45deg);
                        display:flex;align-items:center;justify-content:center;
                        font-weight:700;font-size:13px;font-family:sans-serif;
                        box-shadow:0 3px 10px rgba(0,0,0,.35);">
                        <span style="transform:rotate(45deg)">${num}</span>
                    </div>`,
                iconSize:    [32, 32],
                iconAnchor:  [10, 32],
                popupAnchor: [6, -34]
            });
        }

        //  Place markers 
        const leafletMarkers = [];

        allPoints.forEach((pt, i) => {
            const label  = pt.isTown ? '★' : i;    
            const marker = L.marker([pt.lat, pt.lng], { icon: makeIcon(label, pt.isTown) })
                .addTo(map)
                .bindPopup(`
                    <div class="popup-inner">
                        <span class="pop-num ${pt.isTown ? 'start-pop' : ''}">
                            ${pt.isTown ? 'Start' : 'Stop ' + i}
                        </span>
                        <strong>${pt.name}</strong>
                        <span>${pt.loc || ''}</span>
                    </div>
                `, { maxWidth: 220 });

            // Click marker → highlight sidebar row
            marker.on('click', () => highlightSidebarStop(i));
            leafletMarkers.push(marker);
        });

        // Fit map to all markers
        const group = L.featureGroup(leafletMarkers);
        map.fitBounds(group.getBounds().pad(0.18));

        //  Rebuild sidebar stop list  
        const stopListEl = document.getElementById('stopList');
        stopListEl.innerHTML = '';

        allPoints.forEach((pt, i) => {
            const li = document.createElement('li');
            li.dataset.lat = pt.lat;
            li.dataset.lng = pt.lng;
            if (pt.isTown) li.classList.add('town-start');

            li.innerHTML = `
                <span class="stop-num ${pt.isTown ? 'start-num' : ''}">${pt.isTown ? '★' : i}</span>
                <span>
                    <span class="stop-name">${pt.name}</span>
                    <span class="stop-loc">${pt.isTown ? 'Starting point' : (pt.loc || '')}</span>
                </span>`;

            li.addEventListener('click', () => {
                map.setView([pt.lat, pt.lng], 15, { animate: true });
                leafletMarkers[i] && leafletMarkers[i].openPopup();
                highlightSidebarStop(i);
            });

            stopListEl.appendChild(li);
        });

        function highlightSidebarStop(index) {
            stopListEl.querySelectorAll('li').forEach((el, i) => {
                el.classList.toggle('active', i === index);
            });
        }

        // route 
        const coords = allPoints.map(pt => `${pt.lng},${pt.lat}`).join(';');

        fetch(`https://router.project-osrm.org/route/v1/driving/${coords}?overview=full&geometries=geojson&steps=false`)
            .then(res => {
                if (!res.ok) throw new Error('Network error ' + res.status);
                return res.json();
            })
            .then(data => {

                if (data.code !== 'Ok' || !data.routes || data.routes.length === 0) {
                    routeInfoEl.innerHTML = 'Route not found. OSRM: ' + (data.message || data.code);
                    return;
                }

                const route = data.routes[0];

                // Draw route polyline
                L.geoJSON(route.geometry, {
                    style: { color: '#1a3c2b', weight: 5, opacity: .85 }
                }).addTo(map);

                // Dashed overlay for direction feel
                L.geoJSON(route.geometry, {
                    style: { color: '#fff', weight: 2, opacity: .45, dashArray: '8 14' }
                }).addTo(map);

                // ── Summary stats ──
                const totalKm  = (route.distance / 1000).toFixed(2);
                const totalMin = Math.round(route.duration / 60);
                const h        = Math.floor(totalMin / 60);
                const m        = totalMin % 60;
                const timeStr  = h > 0 ? `${h}h ${m}m` : `${totalMin} min`;

                document.getElementById('statStops').textContent = allPoints.length;
                document.getElementById('statDist').textContent  = totalKm + ' km';
                document.getElementById('statTime').textContent  = timeStr;

                // "Starting from" badge
                if (startBadgeEl) {
                    startBadgeEl.textContent = 'Starting from: ' + startPoint.name;
                    startBadgeEl.style.display = '';
                }

                summaryEl.style.display = '';
                routeInfoEl.innerHTML   = 'Route loaded';
                setTimeout(() => { routeInfoEl.style.display = 'none'; }, 3000);

                // Per-leg breakdown 
                if (route.legs && route.legs.length > 0) {
                    let html = '<h4>Route Breakdown</h4>';
                    route.legs.forEach((leg, i) => {
                        const from   = allPoints[i].name;
                        const to     = allPoints[i + 1].name;
                        const legKm  = (leg.distance / 1000).toFixed(2);
                        const legMin = Math.round(leg.duration / 60);
                        html += `
                            <div class="leg-item">
                                <span class="leg-route">${i + 1} → ${i + 2} &nbsp; ${from} → ${to}</span>
                                <span class="leg-stats">🛣 ${legKm} km &nbsp;·&nbsp; ⏱ ${legMin} min</span>
                            </div>`;
                    });
                    legDetailsEl.innerHTML = html;
                }

                searchStatus.textContent  = '';  
                searchStatus.style.display = 'none'; 
                searchStatus.className    = 'search-status ok';
                btnSearch.disabled        = false;
            })
            .catch(err => {
                console.error('OSRM error:', err);
                routeInfoEl.innerHTML = 'Could not reach routing server. Check your internet connection.';
                searchStatus.textContent = 'Routing failed. Try again.';
                searchStatus.className   = 'search-status err';
                btnSearch.disabled       = false;
            });
    }

    // Search button  
    btnSearch.addEventListener('click', function () {

        const selected = townSelect.options[townSelect.selectedIndex];

        if (!selected || !selected.dataset.lat) {
            searchStatus.textContent = 'Please select a town first!';
            searchStatus.className   = 'search-status err';
            searchStatus.style.display = 'inline';
            return;
        }

        if (places.length === 0) {
            searchStatus.textContent = 'No stops with coordinates found in your plan.';
            searchStatus.className   = 'search-status err';
            return;
        }

        currentStart = {
            lat:  parseFloat(selected.dataset.lat),
            lng:  parseFloat(selected.dataset.lng),
            name: selected.value
        };

        searchStatus.textContent = '';    
        searchStatus.style.display = 'none'; 
        searchStatus.className   = 'search-status';
        btnSearch.disabled       = true;
        routeInfoEl.style.display = '';

        // Init map centred on selected town, then draw
        initMap(currentStart.lat, currentStart.lng, 12);
        drawRoute(currentStart);
    });

    // Default map on page load  
    if (places.length > 0) {
        initMap(places[0].attraction.lat, places[0].attraction.lng, 12);

        // Place plain markers so map is not empty before a town is chosen
        places.forEach((p, i) => {
            const lat  = parseFloat(p.attraction.lat);
            const lng  = parseFloat(p.attraction.lng);
            const name = p.attraction.name;
            const loc  = p.attraction.location || '';

            const icon = L.divIcon({
                className: '',
                html: `
                    <div style="
                        width:32px;height:32px;
                        background:#1a3c2b;color:#fff;
                        border:2.5px solid #fff;
                        border-radius:50% 50% 50% 0;
                        transform:rotate(-45deg);
                        display:flex;align-items:center;justify-content:center;
                        font-weight:700;font-size:13px;font-family:sans-serif;
                        box-shadow:0 3px 10px rgba(0,0,0,.35);">
                        <span style="transform:rotate(45deg)">${i + 1}</span>
                    </div>`,
                iconSize:    [32, 32],
                iconAnchor:  [10, 32],
                popupAnchor: [6, -34]
            });

            L.marker([lat, lng], { icon })
                .addTo(map)
                .bindPopup(`
                    <div class="popup-inner">
                        <span class="pop-num">Stop ${i + 1}</span>
                        <strong>${name}</strong>
                        <span>${loc}</span>
                    </div>
                `, { maxWidth: 220 });
        });

        const group = L.featureGroup(
            places.map(p => L.marker([p.attraction.lat, p.attraction.lng]))
        );
        map.fitBounds(group.getBounds().pad(0.18));
    } else {
        initMap(7.15, 80.10, 11);
        routeInfoEl.innerHTML = 'No places with coordinates in your plan.';
    }

});
