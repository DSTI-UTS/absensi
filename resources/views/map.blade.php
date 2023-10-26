<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Demo: Add custom markers in Mapbox GL JS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" />
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        .marker {
            background-image: url('https://docs.mapbox.com/help/demos/custom-markers-gl-js/mapbox-icon.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .mapboxgl-popup {
            max-width: 200px;
        }

        .mapboxgl-popup-content {
            text-align: center;
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoidXRzIiwiYSI6ImNsa3cwd2ZybDBndjYzcm4xYTdkN2oxdDkifQ.6zM6x2aivpKiQlDXSU5OSw';

        const geojson = @json($geojson);

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v11',
            center: [-96, 37.8],
            zoom: 3
        });
        map.setProjection({
            name: 'equirectangular',
        });

        // add markers to map
        for (const feature of geojson.features) {
            // create a HTML element for each feature
            const el = document.createElement('div');
            el.className = 'marker';

            // make a marker for each feature and add it to the map
            new mapboxgl.Marker(el)
                .setLngLat(feature.geometry.coordinates)
                .setPopup(
                    new mapboxgl.Popup({
                        offset: 25
                    }) // add popups
                    .setHTML(
                        `<h3>${feature.properties.title}</h3><p>${feature.properties.description}</p>`
                    )
                )
                .addTo(map);
        }
    </script>
</body>

</html>