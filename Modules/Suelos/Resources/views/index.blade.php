@extends('admin.layouts.master')
@push('style')
    <style>
        #map {
            width: 1100px;
            height: 500px;
        }

        .breadcrumb {
            margin-right: 20px;
            /* Ajusta este valor según el espacio deseado */
        }
    </style>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="/css/leaflet.css">
    <link rel="stylesheet" href="/css/qgis2web.css">
    <link rel="stylesheet" href="/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="/css/MarkerCluster.css">
    <link rel="stylesheet" href="/css/MarkerCluster.Default.css">
    <link rel="stylesheet" href="/css/leaflet-control-geocoder.Geocoder.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://unpkg.com/whatwg-fetch@3.6.2/dist/fetch.umd.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div><!-- /.col -->

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                        <div class="breadcrumb float-sm-right">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" title="Descargar archivos de las Capas">
                                    <i class="fas fa-download"></i> </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="z-index: 9999;">
                                    <a class="dropdown-item" href="/download/taxonomia.zip" download>Taxonom&iacute;a de
                                        Suelos</a>
                                    <a class="dropdown-item" href="/download/distritos.zip" download>Distritos</a>
                                    <a class="dropdown-item" href="/download/ciudades.zip" download>Ciudades</a>
                                    <a class="dropdown-item" href="/download/viasprincipales.zip" download>V&iacute;as
                                        Principales</a>
                                </div>
                            </div>
                        </div>
                        <!-- Opciones del menú desplegable -->
                        <div class="breadcrumb float-sm-right">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle"type="button"
                                    id="visualizationDropdown" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" title="Gráficos">
                                    <i class="fas fa-chart-line "></i> </button>
                                <div class="dropdown-menu" aria-labelledby="visualizationDropdown">
                                    <a class="dropdown-item" href="#" id="showBarChart">Gráfico de barras</a>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="visualizationModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Visualización</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Contenedor para el gráfico de barras -->
                                        <div id="barChartContainer" style="width: 100%; height: 60vh; display: none;">
                                            <canvas id="barChartCanvas" width="800" height="400"></canvas>
                                        </div>

                                        <!-- Contenedor para el mapa de calor -->
                                        <div id="heatmapContainer" style="width: 800px; height: 400px; display: none;">
                                            <canvas id="heatmapCanvas" width="800" height="400"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div><!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div>

            <div id="map"></div>
            <div id="selection-box"></div>
        </div>
        <div class="modal" id="customModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <input type="hidden" id="idInput" value="">
                        <label for="ordenSelect">Tipo de Suelo:</label>
                        <select id="ordenSelect" class="form-control">
                            <option value="ordenSelect" selected>Seleccionar suelo</option>
                            <option value="ALFISOL">ALFISOL</option>
                            <option value="ENTISOL">ENTISOL</option>
                            <option value="INCEPTISOL">INCEPTISOL</option>
                            <option value="OXISOL">OXISOL</option>
                            <option value="TIERRAS MISCELANEAS">TIERRAS MISCELANEAS</option>
                            <option value="ULTISOL">ULTISOL</option>
                        </select>
                        <label for="descripcionInput">Nueva Descripción:</label>
                        <input type="text" id="descripcionInput" class="form-control">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="aplicarCambiosBtn">Aplicar Cambios</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('script')
    <script src="/js/qgis2web_expressions.js"></script>
    <script src="/js/leaflet.js"></script>
    <script src="/js/leaflet.rotatedMarker.js"></script>
    <script src="/js/leaflet.pattern.js"></script>
    <script src="/js/leaflet-hash.js"></script>
    <script src="/js/Autolinker.min.js"></script>
    <script src="/js/rbush.min.js"></script>
    <script src="/js/labelgun.min.js"></script>
    <script src="/js/labels.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <script src="/js/leaflet-control-geocoder.Geocoder.js"></script>
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
    <script src="/js/leaflet.markercluster.js"></script>
    <script src="/js/data/Distritos_Caaguazucopiar_1.js"></script>
    <!--<script src="/js/data/Taxonomiadesuelos_DeptoCaaguazu_2.js"></script>-->
    <script src="/js/data/Ciudades_Caaguazu_3.js"></script>
    <script src="/js/data/Distritos_Caaguazu_4.js"></script>
    <script src="/js/data/Viasprincipales_Caaguazu_5.js"></script>
    <script>
        var highlightLayer;
        var json_Taxonomiadesuelos_DeptoCaaguazu_2 = @json($taxonomia);

        function highlightFeature(e) {
            highlightLayer = e.target;

            if (e.target.feature.geometry.type === 'LineString') {
                highlightLayer.setStyle({
                    color: '#ffff00',
                });
            } else {
                highlightLayer.setStyle({
                    fillColor: '#ffff00',
                    fillOpacity: 1
                });
            }
            highlightLayer.openPopup();
        }
        var map = L.map('map', {
            zoomControl: true,
            maxZoom: 12,
            minZoom: 1
        })
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix(
            '<a href="https://github.com/tomchadwin/qgis2web" target="_blank"><a href="https://leafletjs.com" title="A JS library for interactive maps"></a><a href="https://qgis.org"></a>'
        );
        var autolinker = new Autolinker({
            truncate: {
                length: 30,
                location: 'smart'
            }
        });
        var bounds_group = new L.featureGroup([]);

        function setBounds() {
            if (bounds_group.getLayers().length) {
                map.fitBounds(bounds_group.getBounds());
            }
        }
        map.createPane('pane_OSMStandard_0');
        map.getPane('pane_OSMStandard_0').style.zIndex = 400;
        var layer_OSMStandard_0 = L.tileLayer('http://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            pane: 'pane_OSMStandard_0',
            opacity: 1.0,
            attribution: '<a href="https://www.openstreetmap.org/copyright"></a>',
            minZoom: 1,
            maxZoom: 19,
            minNativeZoom: 0,
            maxNativeZoom: 19
        });
        layer_OSMStandard_0;
        map.addLayer(layer_OSMStandard_0);
        function pop_Distritos_Caaguazucopiar_1(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature) {
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent =
                '<table>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DPTO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'DPTO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DISTRITO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['DISTRITO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DPTO_DESC'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['DPTO_DESC'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2"><strong>DIST_DESC</strong><br />' +
                (
                    feature
                    .properties[
                        'DIST_DESC'] !==
                    null ?
                    autolinker.link(feature.properties['DIST_DESC'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'CLAVE'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'CLAVE'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </table>';
            layer.bindPopup(popupContent, {
                maxHeight: 400
            });
        }
        async function getUser() {
            try {
                const response = await $.ajax({
                    url: '{{ route('obtener') }}',
                    type: 'GET',
                    dataType: 'json',
                });
                return response;
            } catch (error) {
                //console.error('Error al obtener el usuario:', error);
                alert("Error al obtener el usuario.");
                throw error;
            }
        }
        let selectedSoil;

        function editSoil(e) {
            getUser()
                .then(function(currentUser) {
                    //console.log("Usuario actual:", currentUser);
                    if (userIsAdminOrSuperadmin(currentUser)) {
                        const selectedSoil = e.target;
                        const currentDescription = selectedSoil.feature.properties.DESC;
                        const currentid = selectedSoil.feature.properties.ID;
                        const currentOrden = selectedSoil.feature.properties.ORDEN;
                        document.getElementById('idInput').value = currentid;
                        document.getElementById('descripcionInput').value = currentDescription;
                        document.getElementById('ordenSelect').value = currentOrden;
                        $('#customModal').modal('show');
                    }
                })
                .catch(function(error) {
                    //console.error('Error al obtener el usuario:', error);
                    alert("Error al obtener el usuario.");
                });
        }

        function applyChanges(selectedSoil, currentid) {
            const newOrden = document.getElementById('ordenSelect').value;
            const newDesc = document.getElementById('descripcionInput').value;
            if (newOrden && newDesc && currentid) {
                // Llama a la función para guardar cambios en la base de datos
                saveChangesToBackend({
                    id: currentid, // Utiliza
                    orden: newOrden,
                    desc: newDesc
                });
            }
            $('#customModal').modal('hide');
        }
        async function saveChangesToBackend(updatedFeatureProperties) {
            const backendURL = '{{ route('guardarcambios') }}';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            //console.log('Enviando datos al servidor:', updatedFeatureProperties);
            try {
                const response = await fetch(backendURL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        id: updatedFeatureProperties.id,
                        orden: updatedFeatureProperties.orden,
                        desc: updatedFeatureProperties.desc,
                    }),
                });
                const responseData = await response.json();
                console.log('Respuesta del servidor:', responseData);


            } catch (error) {
                //console.error('Error al guardar cambios en el backend:', error);
                //console.log('Enviando datos al servidor:', updatedFeatureProperties);
                console.log('Detalles de errores de validación:', error
                    .errors); // Agregado para mostrar detalles de errores
            }
        }
        // Función para verificar si el usuario es admin o superadmin
        function userIsAdminOrSuperadmin(currentUser) {
            return currentUser && (currentUser.role === 'admin' || currentUser.role === 'superadmin');
        }
        $(document).ready(function() {
            layer_Taxonomiadesuelos_DeptoCaaguazu_2.eachLayer(function(layer) {
                layer.on('contextmenu', editSoil);
            });
            $('#cerrarModalBtn').on('click', function() {
                $('#customModal').modal('hide');
            });
            $('#aplicarCambiosBtn').on('click', function() {
                const currentid = $('#idInput').val();
                applyChanges(selectedSoil, currentid);
                cargados(selectedSoil, currentid);
            });
        });
        async function cargando(updatedFeatureProperties) {
            //console.log('Iniciando función cargando');
            const carg = '{{ route('cargar') }}';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch(carg, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(updatedFeatureProperties),
                });

                const responseData = await response.json();

                // Llama a la función reloadMap con los nuevos datos
                reloadMap(responseData.taxonomia);

                // Asignar etiquetas y modal de click derecho después de recargar el mapa
                asignarEtiquetas();
                asignarModalClickDerecho();
                //console.log('Datos de taxonomía recibidos:', responseData.taxonomia);


                // Puedes seguir utilizando cargados o realizar otras acciones según sea necesario
                // cargados(selectedSoil, currentid);
                $('#customModal').modal('hide');
            } catch (error) {
                // Manejar errores como se hace en tu código actual
                //console.error('Error al guardar cambios en el backend:', error);
                //console.log('Enviando datos al servidor:', updatedFeatureProperties);
                console.log('Detalles de errores de validación:', error.errors);
            }
        }

        function clearTaxonomiaLayer() {
            if (layer_Taxonomiadesuelos_DeptoCaaguazu_2) {
                map.removeLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_2);
            }
        }

        function reloadMap(newData) {
            //console.log('Iniciando función reloadMap');
            try {
                // Limpiar capas existentes en el mapa
                clearTaxonomiaLayer();
                // Crear una nueva capa con los datos actualizados
                layer_Taxonomiadesuelos_DeptoCaaguazu_2 = L.geoJson(newData, {
                    attribution: '',
                    interactive: true,
                    dataVar: 'json_Taxonomiadesuelos_DeptoCaaguazu_2',
                    layerName: 'layer_Taxonomiadesuelos_DeptoCaaguazu_2',
                    pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                    onEachFeature: pop_Taxonomiadesuelos_DeptoCaaguazu_2,
                    style: style_Taxonomiadesuelos_DeptoCaaguazu_2_0,
                });
                bounds_group.addLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_2);
                map.addLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_2);
                // Agregar el siguiente código aquí
                var i = 0;
                layer_Taxonomiadesuelos_DeptoCaaguazu_2.eachLayer(function(layer) {
                    // ...
                });

            } catch (error) {
                console.error('Error al recargar el mapa:', error);
            }
        }

        function asignarEtiquetas() {
            var i = 0;
            layer_Taxonomiadesuelos_DeptoCaaguazu_2.eachLayer(function(layer) {
                var context = {
                    feature: layer.feature,
                    variables: {}
                };
                layer.bindTooltip((layer.feature.properties['ORDEN'] !== null ? String(
                    '<div style="color: #323232; font-size: 5pt; font-weight: extra-bold; font-family: \'Open Sans\', sans-serif;">' +
                    layer.feature.properties['ORDEN']) + '</div>' : ''), {
                    permanent: true,
                    offset: [-0, -16],
                    className: 'css_Taxonomiadesuelos_DeptoCaaguazu_2'
                });
                labels.push(layer);
                totalMarkers += 1;
                layer.added = true;
                addLabel(layer, i);
                i++;
            });
        }

        function asignarModalClickDerecho() {
            layer_Taxonomiadesuelos_DeptoCaaguazu_2.eachLayer(function(layer) {
                layer.on('contextmenu', editSoil);
            });
        }
        /*$(document).ready(function() {
                    if (typeof map !== 'undefined' && typeof layer_Taxonomiadesuelos_DeptoCaaguazu_2 !== 'undefined') {
                        // Adjuntar evento de clic a la capa de taxonomía
                        layer_Taxonomiadesuelos_DeptoCaaguazu_2.on('click', function(event) {
                            console.log('Se hizo clic en la capa de taxonomía. Coordenadas:', event.latlng);
                            aplicarCirculo(event.latlng, layer_Taxonomiadesuelos_DeptoCaaguazu_2);
                        });
                    } else {
                        console.error('El mapa o la capa no están definidos');
                    }
                });

                let previousCircle = null;
                var circleLayer = L.layerGroup();
                map.addLayer(circleLayer);

                let currentCircle = null; // Variable global para almacenar el círculo actual

                function aplicarCirculo(latlng, layer) {
                    if (map) {
                        // Eliminar el círculo anterior solo si existe
                        if (currentCircle) {
                            circleLayer.removeLayer(currentCircle);
                        }

                        const latLng = L.latLng(latlng.lat, latlng.lng);
                        const circle = L.circle(latLng, {
                            color: 'blue',
                            fillColor: 'blue',
                            fillOpacity: 0.5,
                            radius: 100,
                            zIndex: 10000 // Valor alto de zIndex para que el círculo aparezca encima de las capas
                        });

                        map.addLayer(circle);
                        currentCircle = circle; // Almacenar el círculo actual
                        map.setView(latLng, 11);
                    } else {
                        console.error('El mapa no está definido');
                    }
                }
        */
        $(document).ready(function() {
            // Mostrar el gráfico de barras cuando se selecciona la opción correspondiente
            $("#showBarChart").click(function() {
                generateBarChart();
                $("#visualizationModal").modal('show');
            });

            // Mostrar el mapa de calor cuando se selecciona la opción correspondiente
            $("#showHeatmap").click(function() {
                generateHeatmap();
                $("#visualizationModal").modal('show');
            });
        });

        function generateBarChart() {
            document.getElementById('barChartContainer').style.display = 'block';
            document.getElementById('heatmapContainer').style.display = 'none';

            // Destruir el gráfico existente si lo hay
            if (window.barChart) {
                window.barChart.destroy();
            }

            var taxonomiaData = @json($taxonomia);
            var ordenCounts = {};
            var colorPalette = ['#FF5733', '#33FF57', '#5733FF', '#FF33F5', '#33F5FF',
            '#F5FF33']; // Ejemplo de una paleta de colores

            // Contar la cantidad de cada orden de suelo
            var totalOrdenes = 0;
            taxonomiaData.features.forEach(function(feature) {
                var orden = feature.properties.ORDEN;
                ordenCounts[orden] = (ordenCounts[orden] || 0) + 1;
                totalOrdenes++;
            });

            // Preparar los datos para el gráfico
            var labels = [];
            var data = [];
            var percentages = [];
            var backgroundColors = [];
            Object.keys(ordenCounts).forEach(function(orden, index) {
                labels.push(orden);
                data.push(ordenCounts[orden]);
                percentages.push(((ordenCounts[orden] / totalOrdenes) * 100).toFixed(2) + '%');
                backgroundColors.push(colorPalette[index % colorPalette
                .length]); // Asignar un color de la paleta a cada orden
            });

            // Crear el gráfico
            var canvas = document.getElementById('barChartCanvas');
            var ctx = canvas.getContext('2d');
            window.barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels.map(function(label, index) {
                        return label + " (" + percentages[index] + ")";
                    }),
                    datasets: [{
                        label: 'Cantidad de suelos por orden',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }



        function generateHeatmap() {
            document.getElementById('barChartContainer').style.display = 'none';
            document.getElementById('heatmapContainer').style.display = 'block';

            // Obtener el contenedor del mapa de calor
            var heatmapContainer = document.getElementById('heatmapContainer');

            // Limpiar el contenedor si ya había un mapa de calor
            heatmapContainer.innerHTML = '';

            // Crear un nuevo lienzo (canvas) para el mapa de calor
            var heatmapCanvas = document.createElement('canvas');
            heatmapCanvas.width = heatmapContainer.offsetWidth;
            heatmapCanvas.height = heatmapContainer.offsetHeight;
            heatmapContainer.appendChild(heatmapCanvas);

            // Establecer la propiedad willReadFrequently para optimizar el rendimiento
            heatmapCanvas.willReadFrequently = true;

            var taxonomiaData = @json($taxonomia);
            var heatmapData = [];

            // Recorrer las características (features) del GeoJSON
            taxonomiaData.features.forEach(function(feature) {
                var coordinates = feature.geometry.coordinates;
                if (coordinates && coordinates.length > 0) {
                    coordinates.forEach(function(polygon) {
                        polygon.forEach(function(ring) {
                            ring.forEach(function(coordPair) {
                                if (coordPair.length === 2 && coordPair[0] !== null &&
                                    coordPair[1] !== null) {
                                    heatmapData.push([coordPair[1], coordPair[
                                        0]]); // [lat, lon]
                                } else {
                                    console.warn('Coordenadas inválidas encontradas:',
                                        coordPair);
                                }
                            });
                        });
                    });
                } else {
                    console.log('Coordenadas no definidas para la característica:', feature);
                }
            });

            console.log('Longitud de heatmapData:', heatmapData.length);

            var heatmap = L.heatLayer(heatmapData, {
                radius: 25,
                blur: 15,
                max: 1.0
            }).addTo(map);
        }
        var capaAreasResaltadas = L.layerGroup().addTo(map);

        function handleTaxonomiaClick() {
            layer_Taxonomiadesuelos_DeptoCaaguazu_2.on('click', function(evento) {
                console.log('Evento de click detectado');
                capaAreasResaltadas.clearLayers();
                var latitud = evento.latlng.lat;
                var longitud = evento.latlng.lng;
                console.log('Latitud:', latitud);
                console.log('Longitud:', longitud);
                var areaHectareas = 20;
                var areaMetrosCuadrados = areaHectareas * 10000; // 1 hectárea = 10,000 metros cuadrados
                var radioCirculo = Math.sqrt(areaMetrosCuadrados / Math.PI);
                console.log('Radio del círculo:', radioCirculo);
                try {
                    L.circle([latitud, longitud], {
                        color: 'blue',
                        fillColor: 'blue',
                        fillOpacity: 0.5,
                        radius: 5000,
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2'
                    }).addTo(capaAreasResaltadas);
                } catch (error) {
                    console.error('Error al crear y agregar el círculo:', error);
                }
                map.setView([latitud, longitud], 10);
                console.log('Final del evento de click');
            });
        }

        // Llama a la función handleTaxonomiaClick cuando la capa se haya cargado
        map.on('layeradd', function(event) {
            if (event.layer === layer_Taxonomiadesuelos_DeptoCaaguazu_2) {
                handleTaxonomiaClick();
            }
        });

        function updateUI(responseData) {
            const mapContainer = document.getElementById('map');

            if (mapContainer) {
                // Eliminar el contenedor existente
                mapContainer.parentNode.removeChild(mapContainer);

                // Crear un nuevo contenedor de mapa
                const newMapContainer = document.createElement('div');
                newMapContainer.id = 'map';
                document.body.appendChild(newMapContainer);

                // Actualizar el contenido del nuevo elemento
                newMapContainer.innerHTML = responseData.taxonomia;

                // Actualizar solo la parte del mapa usando AJAX
            } else {
                console.error('Elemento #map no encontrado en el DOM.');

                // Si el elemento no existe, crea uno nuevo y agrégalo al cuerpo del documento
                const newMapContainer = document.createElement('div');
                newMapContainer.id = 'map';
                document.body.appendChild(newMapContainer);

                // Actualiza el contenido del nuevo elemento
                newMapContainer.innerHTML = responseData.taxonomia;

                // Actualizar solo la parte del mapa usando AJAX
            }
        }

        function cargados(selectedSoil, currentid) {
            const newOrden = document.getElementById('ordenSelect').value;
            const newDesc = document.getElementById('descripcionInput').value;

            if (newOrden && newDesc && currentid) {
                cargando({
                    id: currentid,
                    orden: newOrden,
                    desc: newDesc
                });
            }

            $('#customModal').modal('hide');
        }

        function style_Distritos_Caaguazucopiar_1_0() {
            return {
                pane: 'pane_Distritos_Caaguazucopiar_1',
                opacity: 1,
                color: 'rgba(130,126,123,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(235,219,191,1.0)',
                interactive: false,
            }
        }
        map.createPane('pane_Distritos_Caaguazucopiar_1');
        map.getPane('pane_Distritos_Caaguazucopiar_1').style
            .zIndex = 401;
        map.getPane('pane_Distritos_Caaguazucopiar_1').style['mix-blend-mode'] = 'normal';
        var layer_Distritos_Caaguazucopiar_1 = new L.geoJson(json_Distritos_Caaguazucopiar_1, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Distritos_Caaguazucopiar_1',
            layerName: 'layer_Distritos_Caaguazucopiar_1',
            pane: 'pane_Distritos_Caaguazucopiar_1',
            onEachFeature: pop_Distritos_Caaguazucopiar_1,
            style: style_Distritos_Caaguazucopiar_1_0,
        });
        bounds_group.addLayer(layer_Distritos_Caaguazucopiar_1);
        map.addLayer(layer_Distritos_Caaguazucopiar_1);

        function pop_Taxonomiadesuelos_DeptoCaaguazu_2(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature) {
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent =
                '<table>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'ORDEN'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'ORDEN'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="row"></th>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td>' +
                (
                    feature
                    .properties[
                        'DESC'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'DESC']
                        .toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           </table>';
            layer.bindPopup(popupContent, {
                maxHeight: 400
            });
        }

        function style_Taxonomiadesuelos_DeptoCaaguazu_2_0(feature) {
            switch (String(feature.properties['ORDEN'])) {
                case 'AGUA':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                            opacity: 1,
                            color: 'rgba(35,35,35,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(166,206,227,1.0)',
                            interactive: true,
                    }
                    break;
                case 'ALFISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                            opacity: 1,
                            color: 'rgba(130,126,123,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(235,219,191,1.0)',
                            interactive: true,
                    }
                    break;
                case 'CIUDAD':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                            opacity: 1,
                            color: 'rgba(130,126,123,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(240,165,157,1.0)',
                            interactive: true,
                    }
                    break;
                case 'ENTISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                            opacity: 1,
                            color: 'rgba(130,126,123,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(253,241,240,1.0)',
                            interactive: true,
                    }
                    break;
                case 'INCEPTISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                            opacity: 1,
                            color: 'rgba(130,126,123,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(156,74,78,1.0)',
                            interactive: true,
                    }
                    break;
                case 'OXISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                            opacity: 1,
                            color: 'rgba(130,126,123,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(247,209,166,1.0)',
                            interactive: true,
                    }
                    break;
                case 'TIERRAS MISCELANEAS':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                            opacity: 1,
                            color: 'rgba(130,126,123,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(193,163,143,1.0)',
                            interactive: true,
                    }
                    break;
                case 'ULTISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
                            opacity: 1,
                            color: 'rgba(130,126,123,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(187,223,178,1.0)',
                            interactive: true,
                    }
                    break;
            }
        }
        map.createPane('pane_Taxonomiadesuelos_DeptoCaaguazu_2');
        map.getPane(
            'pane_Taxonomiadesuelos_DeptoCaaguazu_2').style.zIndex = 402;
        map.getPane(
            'pane_Taxonomiadesuelos_DeptoCaaguazu_2').style['mix-blend-mode'] = 'normal';
        var layer_Taxonomiadesuelos_DeptoCaaguazu_2 = new L.geoJson(json_Taxonomiadesuelos_DeptoCaaguazu_2, {
            attribution: '',
            interactive: true,
            dataVar: 'json_Taxonomiadesuelos_DeptoCaaguazu_2',
            layerName: 'layer_Taxonomiadesuelos_DeptoCaaguazu_2',
            pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_2',
            onEachFeature: pop_Taxonomiadesuelos_DeptoCaaguazu_2,
            style: style_Taxonomiadesuelos_DeptoCaaguazu_2_0,
        });
        bounds_group.addLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_2);
        map.addLayer(
            layer_Taxonomiadesuelos_DeptoCaaguazu_2);

        function pop_Ciudades_Caaguazu_3(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature) {
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent =
                '<table>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DPTO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'DPTO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DPTO_DESC'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['DPTO_DESC'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DISTRITO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['DISTRITO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DIST_DESC'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['DIST_DESC'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'CLAVE'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'CLAVE'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </table>';
            layer.bindPopup(popupContent, {
                maxHeight: 400
            });
        }

        function style_Ciudades_Caaguazu_3_0() {
            return {
                pane: 'pane_Ciudades_Caaguazu_3',
                radius: 4.0,
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(255,63,25,1.0)',
                interactive: false,
            }
        }
        map.createPane('pane_Ciudades_Caaguazu_3');
        map.getPane('pane_Ciudades_Caaguazu_3').style.zIndex = 403;
        map
            .getPane('pane_Ciudades_Caaguazu_3').style['mix-blend-mode'] = 'normal';
        var layer_Ciudades_Caaguazu_3 = new L.geoJson(json_Ciudades_Caaguazu_3, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Ciudades_Caaguazu_3',
            layerName: 'layer_Ciudades_Caaguazu_3',
            pane: 'pane_Ciudades_Caaguazu_3',
            onEachFeature: pop_Ciudades_Caaguazu_3,
            pointToLayer: function(feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_Ciudades_Caaguazu_3_0(feature));
            },
        });
        var cluster_Ciudades_Caaguazu_3 = new L.MarkerClusterGroup({
            showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2
        });
        cluster_Ciudades_Caaguazu_3.addLayer(layer_Ciudades_Caaguazu_3);

        bounds_group.addLayer(layer_Ciudades_Caaguazu_3);
        cluster_Ciudades_Caaguazu_3.addTo(map);

        function pop_Distritos_Caaguazu_4(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature) {
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent =
                '<table>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DPTO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'DPTO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DISTRITO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['DISTRITO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'DPTO_DESC'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['DPTO_DESC'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2"><strong>DIST_DESC</strong><br />' +
                (
                    feature
                    .properties[
                        'DIST_DESC'] !==
                    null ?
                    autolinker.link(feature.properties['DIST_DESC'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'CLAVE'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'CLAVE'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </table>';
            layer.bindPopup(popupContent, {
                maxHeight: 400
            });
        }

        function style_Distritos_Caaguazu_4_0() {
            return {
                pane: 'pane_Distritos_Caaguazu_4',
                opacity: 1,
                color: 'rgba(74,94,142,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.2,
                fillOpacity: 0,
                interactive: false,
            }
        }
        map.createPane('pane_Distritos_Caaguazu_4');
        map.getPane('pane_Distritos_Caaguazu_4').style.zIndex =
            404;
        map.getPane('pane_Distritos_Caaguazu_4').style['mix-blend-mode'] = 'normal';
        var layer_Distritos_Caaguazu_4 = new L.geoJson(json_Distritos_Caaguazu_4, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Distritos_Caaguazu_4',
            layerName: 'layer_Distritos_Caaguazu_4',
            pane: 'pane_Distritos_Caaguazu_4',
            onEachFeature: pop_Distritos_Caaguazu_4,
            style: style_Distritos_Caaguazu_4_0,
        });
        bounds_group.addLayer(layer_Distritos_Caaguazu_4);
        map.addLayer(layer_Distritos_Caaguazu_4);

        function pop_Viasprincipales_Caaguazu_5(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature) {
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent =
                '<table>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'NOMBRE'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['NOMBRE'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'LONG_KM_EN'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['LONG_KM_EN'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'RUTA_NRO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['RUTA_NRO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'ANCHO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'ANCHO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'TIPO'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'TIPO'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                (
                    feature
                    .properties[
                        'LONG_MTS'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties['LONG_MTS'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </table>';
            layer.bindPopup(popupContent, {
                maxHeight: 400
            });
        }

        function style_Viasprincipales_Caaguazu_5_0() {
            return {
                pane: 'pane_Viasprincipales_Caaguazu_5',
                opacity: 1,
                color: 'rgba(248,38,38,1.0)',
                dashArray: '',
                lineCap: 'square',
                lineJoin: 'bevel',
                weight: 2.0,
                fillOpacity: 0,
                interactive: false,
            }
        }
        map.createPane('pane_Viasprincipales_Caaguazu_5');
        map.getPane('pane_Viasprincipales_Caaguazu_5').style
            .zIndex = 405;
        map.getPane('pane_Viasprincipales_Caaguazu_5').style['mix-blend-mode'] = 'normal';
        var layer_Viasprincipales_Caaguazu_5 = new L.geoJson(json_Viasprincipales_Caaguazu_5, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Viasprincipales_Caaguazu_5',
            layerName: 'layer_Viasprincipales_Caaguazu_5',
            pane: 'pane_Viasprincipales_Caaguazu_5',
            onEachFeature: pop_Viasprincipales_Caaguazu_5,
            style: style_Viasprincipales_Caaguazu_5_0,
        });
        bounds_group.addLayer(layer_Viasprincipales_Caaguazu_5);
        map.addLayer(layer_Viasprincipales_Caaguazu_5);
        var osmGeocoder = new L.Control.Geocoder({
            collapsed: true,
            position: 'topleft',
            text: 'Search',
            title: 'Testing'
        }).addTo(map);
        document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
            .className += ' fa fa-search';
        document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
            .title += 'Search for a place';

        var baseMaps = {};
        L.control.layers(baseMaps, {
            '<img src="/images/legend/Viasprincipales_Caaguazu_5.png" /> Vias principales Caaguazu': layer_Viasprincipales_Caaguazu_5,
            '<img src="/images/legend/Distritos_Caaguazu_4.png" /> Distritos Caaguazu': layer_Distritos_Caaguazu_4,
            '<img src="/images/legend/Ciudades_Caaguazu_3.png" /> Ciudades Caaguazu': cluster_Ciudades_Caaguazu_3,
            'Taxonom&iacute;a de Suelos<br /><table><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_AGUA0.png" /></td><td>AGUA</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_ALFISOL1.png" /></td><td>ALFISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_CIUDAD2.png" /></td><td>CIUDAD</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_ENTISOL3.png" /></td><td>ENTISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_INCEPTISOL4.png" /></td><td>INCEPTISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_OXISOL5.png" /></td><td>OXISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_TIERRASMISCELANEAS6.png" /></td><td>TIERRAS MISCELANEAS</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_ULTISOL7.png" /></td><td>ULTISOL</td></tr></table>': layer_Taxonomiadesuelos_DeptoCaaguazu_2,
        }).addTo(map);
        setBounds();

        var i = 0;
        layer_Taxonomiadesuelos_DeptoCaaguazu_2.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['ORDEN'] !== null ? String(
                '<div style="color: #000; font-size: 4pt; font-weight: 900; font-family: \'Open Sans\', sans-serif;">' +
                layer.feature.properties['ORDEN']) + '</div>' : ''), {
                permanent: true,
                offset: [-0, -16],
                className: 'css_Taxonomiadesuelos_DeptoCaaguazu_2'
            });
            labels.push(layer);
            totalMarkers += 1;
            layer.added = true;
            addLabel(layer, i);
            i++;
        });
        var i = 0;
        layer_Distritos_Caaguazu_4.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['DIST_DESC'] !== null ? String(
                '<div style="color: #0c0cf2; font-size: 5pt; font-weight: bold; font-family: \'Georgia\', sans-serif;">' +
                layer.feature.properties['DIST_DESC']) + '</div>' : ''), {
                permanent: true,
                offset: [-0, -16],
                className: 'css_Distritos_Caaguazu_4'
            });
            labels.push(layer);
            totalMarkers += 1;
            layer.added = true;
            addLabel(layer, i);
            i++;
        });
        var i = 0;
        layer_Viasprincipales_Caaguazu_5.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['NOMBRE'] !== null ? String(
                '<div style="color: #e60909; font-size: 4pt; font-weight: bold; font-family: \'Open Sans\', sans-serif;">' +
                layer.feature.properties['NOMBRE']) + '</div>' : ''), {
                permanent: true,
                offset: [-0, -16],
                className: 'css_Viasprincipales_Caaguazu_5'
            });
            labels.push(layer);
            totalMarkers += 1;
            layer.added = true;
            addLabel(layer, i);
            i++;
        });
        resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazu_2,
            layer_Distritos_Caaguazu_4,
            layer_Viasprincipales_Caaguazu_5
        ]);
        map.on("zoomend", function() {
            resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazu_2,
                layer_Distritos_Caaguazu_4, layer_Viasprincipales_Caaguazu_5
            ]);
        });
        map.on("layeradd", function() {
            resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazu_2,
                layer_Distritos_Caaguazu_4, layer_Viasprincipales_Caaguazu_5
            ]);
        });
        map.on("layerremove", function() {
            resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazu_2,
                layer_Distritos_Caaguazu_4, layer_Viasprincipales_Caaguazu_5
            ]);
        });
    </script>
@endpush
