@extends('admin.layouts.master')
@push('style')
    <style>
        #map {
            width: 1050px;
            height: 500px;
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://unpkg.com/whatwg-fetch@3.6.2/dist/fetch.umd.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
                    </div><!-- /.col -->
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
                            <option value="TIERRAS MISC">TIERRAS MISC</option>
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
            maxZoom: 15,
            minZoom: 1
        })
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix(
            '<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>'
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
            attribution: '<a href="https://www.openstreetmap.org/copyright">© OpenStreetMap contributors, CC-BY-SA</a>',
            minZoom: 1,
            maxZoom: 15,
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
                console.error('Error al obtener el usuario:', error);
                alert("Error al obtener el usuario.");
                throw error;
            }
        }
        let selectedSoil;

        function editSoil(e) {
            getUser()
                .then(function(currentUser) {
                    console.log("Usuario actual:", currentUser);
                    if (userIsAdminOrSuperadmin(currentUser)) {
                        const selectedSoil = e.target;
                        const currentDescription = selectedSoil.feature.properties.DESC;
                        const currentid = selectedSoil.feature.properties.ID;
                        document.getElementById('idInput').value = currentid;
                        document.getElementById('descripcionInput').value = currentDescription;
                        $('#customModal').modal('show');
                    }
                })
                .catch(function(error) {
                    console.error('Error al obtener el usuario:', error);
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
            console.log('Enviando datos al servidor:', updatedFeatureProperties);
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
                console.error('Error al guardar cambios en el backend:', error);
                console.log('Enviando datos al servidor:', updatedFeatureProperties);
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
        // Modificar la función cargando
        async function cargando(updatedFeatureProperties) {
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

                console.log('Datos de taxonomía recibidos:', responseData.taxonomia);

                // Puedes seguir utilizando cargados o realizar otras acciones según sea necesario
                // cargados(selectedSoil, currentid);
                $('#customModal').modal('hide');
            } catch (error) {
                // Manejar errores como se hace en tu código actual
                console.error('Error al guardar cambios en el backend:', error);
                console.log('Enviando datos al servidor:', updatedFeatureProperties);
                console.log('Detalles de errores de validación:', error.errors);
            }
        }

        function reloadMap(newData) {
            const mapContainer = document.getElementById('map');

            // Eliminar el contenedor del mapa existente si existe
            if (mapContainer) {
                mapContainer.parentNode.removeChild(mapContainer);
            }

            // Crear un nuevo contenedor de mapa
            const newMapContainer = document.createElement('div');
            newMapContainer.id = 'map';
            document.body.appendChild(newMapContainer);

            try {
                // Intentar crear una nueva capa con los datos actualizados
                layer_Taxonomiadesuelos_DeptoCaaguazu_2 = L.geoJson(newData, {
                    style: style_Taxonomiadesuelos_DeptoCaaguazu_2_0,
                    onEachFeature: pop_Taxonomiadesuelos_DeptoCaaguazu_2
                });

                // Asegurarse de que la capa creada sea válida
                if (layer_Taxonomiadesuelos_DeptoCaaguazu_2) {
                    // Agregar la nueva capa al nuevo contenedor
                    layer_Taxonomiadesuelos_DeptoCaaguazu_2.addTo(map);
                } else {
                    console.error('Error al crear la nueva capa. Datos incompatibles.');
                }
            } catch (error) {
                console.error('Error al crear la nueva capa:', error);
            }
        }




        // Llamar a esta función cuando sea necesario, por ejemplo, después de recibir nuevos datos
        // Ejemplo de uso:
        // reloadMap(responseData.taxonomia);


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

        /* async function cargando(updatedFeatureProperties) {
                    const back = '{{ route('cargar') }}';
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    console.log('Enviando datos al servidor:', updatedFeatureProperties);

                    try {
                        const response = await fetch(back, {
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

                        // Recargar la página después de la actualización exitosa
                        location.reload();
                    } catch (error) {
                        console.error('Error al guardar cambios en el backend:', error);
                        console.log('Enviando datos al servidor:', updatedFeatureProperties);
                        console.log('Detalles de errores de validación:', error.errors);
                        // Puedes manejar el error según tus necesidades (por ejemplo, mostrar un mensaje de error).
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('aplicarCambiosBtn').addEventListener('click', async function() {
                        var id = document.getElementById('idInput').value;
                        var orden = document.getElementById('ordenSelect').value;
                        var desc = document.getElementById('descripcionInput').value;

                        await cargando({
                            id: id,
                            orden: orden,
                            desc: desc
                        });
                    });
                });
        */
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
        map.getPane('pane_Distritos_Caaguazucopiar_1').style.zIndex = 401;
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
                                                                                                                                                                                                        <th scope="row">DESC</th>\
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
                                                                                                                                                                                                    </tr>\
                                                                                                                                                                                                    <tr>\
                                                                                                                                                                                                        <td colspan="2">' +
                (
                    feature
                    .properties[
                        'ID'] !==
                    null ?
                    autolinker
                    .link(
                        feature
                        .properties[
                            'ID'].toLocaleString()) : '') +
                '</td>\
                                                                                                                                                                                                    </tr>\
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
        map.getPane('pane_Taxonomiadesuelos_DeptoCaaguazu_2').style.zIndex = 402;
        map.getPane('pane_Taxonomiadesuelos_DeptoCaaguazu_2').style['mix-blend-mode'] = 'normal';
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
        map.addLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_2);

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
        map.getPane('pane_Ciudades_Caaguazu_3').style['mix-blend-mode'] = 'normal';
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
                color: 'rgba(130,126,123,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0,
                fillOpacity: 0,
                interactive: false,
            }
        }
        map.createPane('pane_Distritos_Caaguazu_4');
        map.getPane('pane_Distritos_Caaguazu_4').style.zIndex = 404;
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
        map.getPane('pane_Viasprincipales_Caaguazu_5').style.zIndex = 405;
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
            'Taxonomia de Suelos Departamento de Caaguazú<br /><table><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_AGUA0.png" /></td><td>AGUA</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_ALFISOL1.png" /></td><td>ALFISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_CIUDAD2.png" /></td><td>CIUDAD</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_ENTISOL3.png" /></td><td>ENTISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_INCEPTISOL4.png" /></td><td>INCEPTISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_OXISOL5.png" /></td><td>OXISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_TIERRASMISCELANEAS6.png" /></td><td>TIERRAS MISCELANEAS</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_2_ULTISOL7.png" /></td><td>ULTISOL</td></tr></table>': layer_Taxonomiadesuelos_DeptoCaaguazu_2,
        }, {
            collapsed: false
        }).addTo(map);
        setBounds();
        var i = 0;
        layer_Taxonomiadesuelos_DeptoCaaguazu_2.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['ORDEN'] !== null ? String(
                '<div style="color: #323232; font-size: 5pt; font-weight: bold; font-family: \'Open Sans\', sans-serif;">' +
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
                '<div style="color: #e31a1c; font-size: 6pt; font-weight: bold; font-family: \'Georgia\', sans-serif;">' +
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
                '<div style="color: #28449b; font-size: 5pt; font-weight: bold; font-family: \'Open Sans\', sans-serif;">' +
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
        resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazu_2, layer_Distritos_Caaguazu_4,
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
        map.on('click', function(e) {
            const clickedCoords = e.latlng;
            const hectareaRadius = 100; // Radio en metros para una hectárea
            const boundsAroundClick = clickedCoords.toBounds(hectareaRadius);

            map.fitBounds(boundsAroundClick);
        });
    </script>
@endpush
