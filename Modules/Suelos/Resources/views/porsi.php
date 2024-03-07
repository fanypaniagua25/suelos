@extends('admin.layouts.master')
@push('style')
    <style>
        #map {
            width: 1366px;
            height: 534px;

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
    <link rel="stylesheet" href="/css/leaflet-measure.css">
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

        </div>
        <div class="modal" id="customModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <label for="ordenSelect">Tipo de Suelo:</label>
                        <select id="ordenSelect" class="form-control">
                            <option value="" selected>Seleccionar suelo</option>
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
                        <button type="button" class="btn btn-primary" onclick="applyChanges()">Aplicar Cambios</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    <script src="https://unpkg.com/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.js"></script>
    <script src="/js/leaflet-control-geocoder.Geocoder.js"></script>
    <script src="/js/leaflet-measure.js"></script>
    <script src="/js/leaflet.markercluster.js"></script>
    <script src="/js/data/Distritos_Caaguazu_2.js"></script>
    <script src="/js/data/Taxonomiadesuelos_DeptoCaaguazu_0.js"></script>
    <script src="/js/data/Ciudades_Caaguazu_1.js"></script>
    <script src="/js/data/Viasprincipales_Caaguazu_3.js"></script>

    <script>
        var highlightLayer;

        function highlightFeature(e) {
            highlightLayer = e.target;
            highlightLayer.openPopup();
        }
        var map = L.map('map', {
            zoomControl: true,
            maxZoom: 28,
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
        L.control.locate({
            locateOptions: {
                maxZoom: 19
            }
        }).addTo(map);
        var bounds_group = new L.featureGroup([]);

        function setBounds() {
            if (bounds_group.getLayers().length) {
                map.fitBounds(bounds_group.getBounds());
            }
            map.setMaxBounds(map.getBounds());
        }

        function pop_Taxonomiadesuelos_DeptoCaaguazu_0(feature, layer) {
            layer.on({
                mouseout: function(e) {
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
                                                                                                                                                </table>';
            layer.bindPopup(popupContent, {
                maxHeight: 400
            });
        }

        function style_Taxonomiadesuelos_DeptoCaaguazu_0_0(feature) {
            switch (String(feature.properties['ORDEN'])) {
                case 'AGUA':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(0,0,0,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(9,134,223,1.0)',
                            interactive: true,
                    }
                    break;
                case 'ALFISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(63,62,62,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(237,230,27,1.0)',
                            interactive: true,
                    }
                    break;
                case 'CIUDAD':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(0,0,0,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(255,41,41,1.0)',
                            interactive: true,
                    }
                    break;
                case 'El Oxisol es un suelo de color rojo a amarillo y es ideal para cultivos como soja, maíz, caña de azúcar y yerba mate en Paraguay.':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(195,116,31,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(255,255,255,1.0)',
                            interactive: true,
                    }
                    break;
                case 'ENTISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(0,0,0,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(232,34,146,1.0)',
                            interactive: true,
                    }
                    break;
                case 'INCEPTISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(0,0,0,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(10,10,10,1.0)',
                            interactive: true,
                    }
                    break;
                case 'OXISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(0,0,0,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(246,198,171,1.0)',
                            interactive: true,
                    }
                    break;
                case 'TIERRAS MISCELANEAS':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(0,0,0,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(212,150,22,1.0)',
                            interactive: true,
                    }
                    break;
                case 'ULTISOL':
                    return {
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
                            opacity: 1,
                            color: 'rgba(0,0,0,1.0)',
                            dashArray: '',
                            lineCap: 'butt',
                            lineJoin: 'miter',
                            weight: 1.0,
                            fill: true,
                            fillOpacity: 1,
                            fillColor: 'rgba(50,225,50,1.0)',
                            interactive: true,
                    }
                    break;
            }
        }
        map.createPane('pane_Taxonomiadesuelos_DeptoCaaguazu_0');
        map.getPane('pane_Taxonomiadesuelos_DeptoCaaguazu_0').style.zIndex = 400;
        map.getPane('pane_Taxonomiadesuelos_DeptoCaaguazu_0').style['mix-blend-mode'] = 'normal';
        var layer_Taxonomiadesuelos_DeptoCaaguazu_0 = new L.geoJson(json_Taxonomiadesuelos_DeptoCaaguazu_0, {
            attribution: '',
            interactive: true,
            dataVar: 'json_Taxonomiadesuelos_DeptoCaaguazu_0',
            layerName: 'layer_Taxonomiadesuelos_DeptoCaaguazu_0',
            pane: 'pane_Taxonomiadesuelos_DeptoCaaguazu_0',
            onEachFeature: pop_Taxonomiadesuelos_DeptoCaaguazu_0,
            style: style_Taxonomiadesuelos_DeptoCaaguazu_0_0,
        });
        bounds_group.addLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_0);
        map.addLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_0);

        function pop_Ciudades_Caaguazu_1(feature, layer) {
            layer.on({
                mouseout: function(e) {
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
        async function getUser() {
            try {
                const response = await $.ajax({
                    url: '{{}',
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

        function editSoil(e) {
            getUser()
                .then(function(currentUser) {
                    console.log("Usuario actual:", currentUser);
                    if (userIsAdminOrSuperadmin(currentUser)) {
                        const selectedSoil = e.target;
                        const currentDescription = selectedSoil.feature.properties.DESC;
                        document.getElementById('descripcionInput').value = currentDescription;
                        $('#customModal').modal('show');

                        // Actualización en tiempo real
                        $('#customModal').on('hidden.bs.modal', function() {
                            applyChanges(selectedSoil);
                        });
                    }
                })
                .catch(function(error) {
                    console.error('Error al obtener el usuario:', error);
                    alert("Error al obtener el usuario.");
                });
        }

        async function saveChangesToBackend(updatedFeature) {
            const backendURL = '{{ route("guardarcambios") }}';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            console.log('Enviando datos al servidor:', updatedFeature);
            const requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(updatedFeature),
            };

            console.log('Objeto a enviar al servidor:', updatedFeature);

            try {
                const response = await fetch(backendURL, requestOptions);
                if (!response.ok) {
                    throw new Error('Error en la solicitud al servidor');
                }

                const contentType = response.headers.get('content-type');
                if (contentType && contentType.indexOf('application/json') !== -1) {
                    const data = await response.json();
                    console.log('Respuesta del servidor:', data);
                    // Hacer algo con 'data'

                    // Actualiza el mapa con los datos actualizados desde el servidor
                    const updatedGeoJSON = await getUser();
                    const layer = L.geoJSON(updatedGeoJSON);
                    map.eachLayer(function(leafletLayer) {
                        if (leafletLayer instanceof L.GeoJSON) {
                            map.removeLayer(leafletLayer);
                        }
                    });
                    layer.addTo(map);
                } else {
                    console.error('La respuesta del servidor no es un JSON válido.');
                    throw new Error('Error en la solicitud al servidor');
                }
            } catch (error) {
                console.error('Error al guardar cambios en el backend:', error);
                // Resto del manejo de errores
            }
        }

        function applyChanges(selectedSoil) {
            const newOrden = document.getElementById('ordenSelect').value;
            const newDesc = document.getElementById('descripcionInput').value;

            if (newOrden && newDesc && selectedSoil !== undefined) {
                // Actualiza las propiedades y el contenido del popup
                selectedSoil.feature.properties.ORDEN = newOrden;
                selectedSoil.feature.properties.DESC = newDesc;
                selectedSoil.bindPopup("ORDEN: " + newOrden + "<br>DESC: " + newDesc);

                // Actualiza el objeto GeoJSON con los nuevos valores
                const geoJSONFeature = layer_Taxonomiadesuelos_DeptoCaaguazu_0.toGeoJSON();
                const featureIndex = geoJSONFeature.features.findIndex(feature => feature.properties.ORDEN === selectedSoil
                    .feature.properties.ORDEN);

                if (featureIndex !== -1) {
                    geoJSONFeature.features[featureIndex].properties.ORDEN = newOrden;
                    geoJSONFeature.features[featureIndex].properties.DESC = newDesc;
                    saveChangesToBackend(geoJSONFeature.features[featureIndex]);
                    const newLayer = L.geoJSON(geoJSONFeature.features[featureIndex]);
                }

                // Limpiar la variable global después de aplicar los cambios
                selectedSoil = undefined;
            }

            $('#customModal').modal('hide');
        }

        // Función para verificar si el usuario es admin o superadmin
        function userIsAdminOrSuperadmin(currentUser) {
            return currentUser && (currentUser.role === 'admin' || currentUser.role === 'superadmin');
        }

        // Document ready
        $(document).ready(function() {
            // Asigna la función de edición a los polígonos
            layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function(layer) {
                layer.on('click', editSoil);
            });

            // Cierra el modal al hacer clic en el botón cerrarModalBtn
            $('#cerrarModalBtn').on('click', function() {
                $('#customModal').modal('hide');
            });
        });


        function style_Ciudades_Caaguazu_1_0() {
            return {
                pane: 'pane_Ciudades_Caaguazu_1',
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
        map.createPane('pane_Ciudades_Caaguazu_1');
        map.getPane('pane_Ciudades_Caaguazu_1').style.zIndex = 401;
        map.getPane('pane_Ciudades_Caaguazu_1').style['mix-blend-mode'] = 'normal';
        var layer_Ciudades_Caaguazu_1 = new L.geoJson(json_Ciudades_Caaguazu_1, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Ciudades_Caaguazu_1',
            layerName: 'layer_Ciudades_Caaguazu_1',
            pane: 'pane_Ciudades_Caaguazu_1',
            onEachFeature: pop_Ciudades_Caaguazu_1,
            pointToLayer: function(feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_Ciudades_Caaguazu_1_0(feature));
            },
        });
        var cluster_Ciudades_Caaguazu_1 = new L.MarkerClusterGroup({
            showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2
        });
        cluster_Ciudades_Caaguazu_1.addLayer(layer_Ciudades_Caaguazu_1);

        bounds_group.addLayer(layer_Ciudades_Caaguazu_1);
        cluster_Ciudades_Caaguazu_1.addTo(map);

        function pop_Distritos_Caaguazu_2(feature, layer) {
            layer.on({
                mouseout: function(e) {
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

        function style_Distritos_Caaguazu_2_0() {
            return {
                pane: 'pane_Distritos_Caaguazu_2',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0,
                fillOpacity: 0,
                interactive: false,
            }
        }
        map.createPane('pane_Distritos_Caaguazu_2');
        map.getPane('pane_Distritos_Caaguazu_2').style.zIndex = 402;
        map.getPane('pane_Distritos_Caaguazu_2').style['mix-blend-mode'] = 'normal';
        var layer_Distritos_Caaguazu_2 = new L.geoJson(json_Distritos_Caaguazu_2, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Distritos_Caaguazu_2',
            layerName: 'layer_Distritos_Caaguazu_2',
            pane: 'pane_Distritos_Caaguazu_2',
            onEachFeature: pop_Distritos_Caaguazu_2,
            style: style_Distritos_Caaguazu_2_0,
        });
        bounds_group.addLayer(layer_Distritos_Caaguazu_2);
        map.addLayer(layer_Distritos_Caaguazu_2);

        function pop_Viasprincipales_Caaguazu_3(feature, layer) {
            layer.on({
                mouseout: function(e) {
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

        function style_Viasprincipales_Caaguazu_3_0() {
            return {
                pane: 'pane_Viasprincipales_Caaguazu_3',
                opacity: 1,
                color: 'rgba(141,78,18,1.0)',
                dashArray: '',
                lineCap: 'square',
                lineJoin: 'bevel',
                weight: 2.0,
                fillOpacity: 0,
                interactive: false,
            }
        }
        map.createPane('pane_Viasprincipales_Caaguazu_3');
        map.getPane('pane_Viasprincipales_Caaguazu_3').style.zIndex = 403;
        map.getPane('pane_Viasprincipales_Caaguazu_3').style['mix-blend-mode'] = 'normal';
        var layer_Viasprincipales_Caaguazu_3 = new L.geoJson(json_Viasprincipales_Caaguazu_3, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Viasprincipales_Caaguazu_3',
            layerName: 'layer_Viasprincipales_Caaguazu_3',
            pane: 'pane_Viasprincipales_Caaguazu_3',
            onEachFeature: pop_Viasprincipales_Caaguazu_3,
            style: style_Viasprincipales_Caaguazu_3_0,
        });
        bounds_group.addLayer(layer_Viasprincipales_Caaguazu_3);
        map.addLayer(layer_Viasprincipales_Caaguazu_3);
        var baseMaps = {};
        L.control.layers(baseMaps, {
            '<img src="/images/legend/Viasprincipales_Caaguazu_3.png" /> Vias principales_Caaguazu': layer_Viasprincipales_Caaguazu_3,
            '<img src="/images/legend/Distritos_Caaguazu_2.png" /> Distritos_Caaguazu': layer_Distritos_Caaguazu_2,
            '<img src="/images/legend/Ciudades_Caaguazu_1.png" /> Ciudades_Caaguazu': cluster_Ciudades_Caaguazu_1,
            'Taxonomia de suelos_Depto Caaguazu<br /><table><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_AGUA0.png" /></td><td>AGUA</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_ALFISOL1.png" /></td><td>ALFISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_CIUDAD2.png" /></td><td>CIUDAD</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_ElOxisolesunsuelodecolorrojoaamarilloyesidealparacultivoscomosojamaízcañadeazúcaryyerbamateenParaguay3.png" /></td><td>El Oxisol es un suelo de color rojo a amarillo y es ideal para cultivos como soja, maíz, caña de azúcar y yerba mate en Paraguay.</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_ENTISOL4.png" /></td><td>ENTISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_INCEPTISOL5.png" /></td><td>INCEPTISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_OXISOL6.png" /></td><td>OXISOL</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_TIERRASMISCELANEAS7.png" /></td><td>TIERRAS MISCELANEAS</td></tr><tr><td style="text-align: center;"><img src="/images/legend/Taxonomiadesuelos_DeptoCaaguazu_0_ULTISOL8.png" /></td><td>ULTISOL</td></tr></table>': layer_Taxonomiadesuelos_DeptoCaaguazu_0,
        }).addTo(map);
        map.on("zoomend", function() {

            if (map.hasLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_0)) {
                if (map.getZoom() <= 19 && map.getZoom() >= 19) {
                    layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function(layer) {
                        layer.openTooltip();
                    });
                } else {
                    layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function(layer) {
                        layer.closeTooltip();
                    });
                }
            }
        });
        setBounds();
        var i = 0;
        layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['ORDEN'] !== null ? String(
                '<div style="color: #323232; font-size: 5pt; font-weight: bold; font-family: \'Open Sans\', sans-serif;">' +
                layer.feature.properties['ORDEN']) + '</div>' : ''), {
                permanent: true,
                offset: [-0, -16],
                className: 'css_Taxonomiadesuelos_DeptoCaaguazu_0'
            });
            labels.push(layer);
            totalMarkers += 1;
            layer.added = true;
            addLabel(layer, i);
            i++;
        });
        var i = 0;
        layer_Distritos_Caaguazu_2.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['DIST_DESC'] !== null ? String(
                '<div style="color: #ff3333; font-size: 6pt; font-family: \'Forte\', sans-serif;">' +
                layer.feature.properties['DIST_DESC']) + '</div>' : ''), {
                permanent: true,
                offset: [-0, -16],
                className: 'css_Distritos_Caaguazu_2'
            });
            labels.push(layer);
            totalMarkers += 1;
            layer.added = true;
            addLabel(layer, i);
            i++;
        });
        var i = 0;
        layer_Viasprincipales_Caaguazu_3.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['NOMBRE'] !== null ? String(
                '<div style="color: #28449b; font-size: 5pt; font-weight: bold; font-family: \'Open Sans\', sans-serif;">' +
                layer.feature.properties['NOMBRE']) + '</div>' : ''), {
                permanent: true,
                offset: [-0, -16],
                className: 'css_Viasprincipales_Caaguazu_3'
            });
            labels.push(layer);
            totalMarkers += 1;
            layer.added = true;
            addLabel(layer, i);
            i++;
        });
        if (map.hasLayer(layer_Taxonomiadesuelos_DeptoCaaguazu_0)) {
            if (map.getZoom() <= 19 && map.getZoom() >= 19) {
                layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function(layer) {
                    layer.openTooltip();
                });
            } else {
                layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function(layer) {
                    layer.closeTooltip();
                });
            }
        }
        resetLabels([layer_Taxonomiadesuelos_DeptoCaaguazu_0, layer_Distritos_Caaguazu_2,
            layer_Viasprincipales_Caaguazu_3
        ]);
        map.on("zoomend", function() {
            resetLabels([layer_Taxonomiadesuelos_DeptoCaaguazu_0, layer_Distritos_Caaguazu_2,
                layer_Viasprincipales_Caaguazu_3
            ]);
        });
        map.on("layeradd", function() {
            resetLabels([layer_Taxonomiadesuelos_DeptoCaaguazu_0, layer_Distritos_Caaguazu_2,
                layer_Viasprincipales_Caaguazu_3
            ]);
        });
        map.on("layerremove", function() {
            resetLabels([layer_Taxonomiadesuelos_DeptoCaaguazu_0, layer_Distritos_Caaguazu_2,
                layer_Viasprincipales_Caaguazu_3
            ]);
        });
    </script>
@endpush
