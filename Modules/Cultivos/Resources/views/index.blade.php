@extends('admin.layouts.master')
@push('style')
    <style>
        #map {
            width: 1366px;
            height: 573px;
        }

        .cultivos-columna {
            height: 300px;
            /* Ajusta la altura según tus necesidades */
            overflow-y: auto;
            /* Agrega una barra de desplazamiento vertical si los elementos exceden la altura */
            padding-right: 5px;
            /* Agrega un espacio para la numeración */
        }

        #cultivosRecomendados {
            display: none;
        }

        .cultivos-columna .list-group-item {
            padding-left: 5px;
            /* Espacio para la numeración */
            position: relative;
            /* Necesario para posicionar el número */
            white-space: nowrap;
            /* Evita que los elementos de la lista se dividan en varias líneas */
            overflow: hidden;
            /* Oculta el texto que exceda el ancho del elemento */
            text-overflow: ellipsis;
            /* Muestra puntos suspensivos para el texto truncado */
        }


        .css_Taxonomiadesuelos_DeptoCaaguazucopiar_2 {
            background-color: white;
            padding: 2px 5px;
            border-radius: 3px;
            line-height: 1;
            margin-bottom: 3px;
            /* Agrega sombreado blanco alrededor del texto */
            box-shadow: 0 0 5px white, 0 0 5px rgba(0, 0, 0, 0.3);
            /* Ajusta el valor según tu preferencia */
        }

        .breadcrumb {
            margin-right: 20px;
            /* Ajusta este valor según el espacio deseado */
        }

        .card-body-scroll {
            max-height: 400px;
            /* Ajusta la altura máxima según tus necesidades */
            overflow-y: auto;
            /* Agrega la barra de desplazamiento vertical */
            padding-right: 15px;
            /* Agrega un espacio a la derecha para que la barra no se superponga al contenido */
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="/css2/leaflet.css">
    <link rel="stylesheet" href="/css2/L.Control.Layers.Tree.css">
    <link rel="stylesheet" href="/css2/L.Control.Locate.min.css">
    <link rel="stylesheet" href="/css2/qgis2web.css">
    <link rel="stylesheet" href="/css2/fontawesome-all.min.css">
    <link rel="stylesheet" href="/css2/leaflet-control-geocoder.Geocoder.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
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
                        <div class="modal fade" id="sueloModal" tabindex="-1" role="dialog"
                            aria-labelledby="sueloModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="sueloModalLabel">Resultados de Evaluación de Suelos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Aquí irá el contenido del modal -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal para la rotación de cultivos -->
                        <div class="modal fade" id="modalRotacionCultivos" tabindex="-1" role="dialog"
                            aria-labelledby="modalRotacionCultivosLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalRotacionCultivosLabel">Rotación de Cultivos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="distritoSelect">Seleccionar Distrito</label>
                                            <select class="form-control" id="distritoSelect">
                                                <option value="">Seleccionar Distrito</option>
                                                <!-- Opciones de distritos se cargarán dinámicamente -->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="ordenSueloSelect">Seleccionar Orden de Suelo</label>
                                            <select class="form-control" id="ordenSueloSelect" disabled>
                                                <option value="">Selecciona un distrito primero</option>
                                                <!-- Opciones de órdenes de suelo se cargarán dinámicamente -->
                                            </select>
                                        </div>
                                    </div>
                                    <div id="cultivosRecomendados" class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Cultivos Recomendados</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row cultivos-container">
                                                <div class="col-md-6">
                                                    <ul class="list-group list-group-flush cultivos-columna">
                                                        <!-- Aquí se mostrarán los cultivos recomendados de la primera columna -->
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul class="list-group list-group-flush cultivos-columna">
                                                        <!-- Aquí se mostrarán los cultivos recomendados de la segunda columna -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="btnCalcularRotacion"
                                            disabled>Calcular
                                            Rotación</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalIngresoDatos" tabindex="-1" role="dialog"
                            aria-labelledby="modalIngresoDatosLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalIngresoDatosLabel">Ingresar datos de suelo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="inputPH">pH</label>
                                                <input type="text" class="form-control" id="inputPH">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputMO">M.O.</label>
                                                <input type="text" class="form-control" id="inputMO">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputAl3">Al+3</label>
                                                <input type="text" class="form-control" id="inputAl3">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputFosforo">Fósforo</label>
                                                <input type="text" class="form-control" id="inputFosforo">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputCalcio">Calcio</label>
                                                <input type="text" class="form-control" id="inputFosforo">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputMagnesio">Magnesio</label>
                                                <input type="text" class="form-control" id="inputFosforo">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputSales">Sales</label>
                                                <input type="text" class="form-control" id="inputFosforo">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputSodio">Sodio</label>
                                                <input type="text" class="form-control" id="inputFosforo">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputCationesIntercambiables">Cationes Intercambiables</label>
                                                <input type="text" class="form-control" id="inputFosforo">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary"
                                            id="btnCalcularResultados">Calcular</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                    <div id="map"></div>
                    <div id="selection-box"></div>
                </div>
            @endsection
            @push('script')
                <script src="/js2/qgis2web_expressions.js"></script>
                <script src="/js2/leaflet.js"></script>
                <script src="/js2/L.Control.Layers.Tree.min.js"></script>
                <script src="/js2/L.Control.Locate.min.js"></script>
                <script src="/js2/leaflet.rotatedMarker.js"></script>
                <script src="/js2/leaflet.pattern.js"></script>
                <script src="/js2/leaflet-hash.js"></script>
                <script src="/js2/Autolinker.min.js"></script>
                <script src="/js2/rbush.min.js"></script>
                <script src="/js2/labelgun.min.js"></script>
                <script src="/js2/labels.js"></script>
                <script src="/js2/leaflet-control-geocoder.Geocoder.js"></script>
                <script src="/js2/data/Distritos_Caaguazucopiar_1.js"></script>
                <script src="/js2/data/Taxonomiadesuelos_DeptoCaaguazucopiar_2.js"></script>
                <script src="/js2/data/Ciudades_Caaguazu_3.js"></script>
                <script src="/js2/data/Distritos_Caaguazu_4.js"></script>
                <script src="/js2/data/cultivos.json"></script>
                <script src="/js2/Leaflet.opacity.js"></script>
                <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
                <script>
                    var highlightLayer;

                    function highlightFeature(e) {
                        highlightLayer = e.target;
                        highlightLayer.openPopup();
                    }
                    var map = L.map('map', {
                        zoomControl: true,
                        maxZoom: 15,
                        minZoom: 1
                    }).fitBounds([
                        [-25.623907375757902, -57.13184809789239],
                        [-24.744947521447436, -55.0321961867199]
                    ]);

                    var hash = new L.Hash(map);
                    var autolinker = new Autolinker({
                        truncate: {
                            length: 30,
                            location: 'smart'
                        }
                    });

                    function removeEmptyRowsFromPopupContent(content, feature) {
                        var tempDiv = document.createElement('div');
                        tempDiv.innerHTML = content;
                        var rows = tempDiv.querySelectorAll('tr');
                        for (var i = 0; i < rows.length; i++) {
                            var td = rows[i].querySelector('td.visible-with-data');
                            var key = td ? td.id : '';
                            if (td && td.classList.contains('visible-with-data') && feature.properties[key] == null) {
                                rows[i].parentNode.removeChild(rows[i]);
                            }
                        }
                        return tempDiv.innerHTML;
                    }

                    document.querySelector(".leaflet-popup-pane").addEventListener("load", function(event) {
                        var tagName = event.target.tagName,
                            popup = map._popup;
                        // Also check if flag is already set.
                        if (tagName === "IMG" && popup && !popup._updated) {
                            popup._updated = true; // Set flag to prevent looping.
                            popup.update();
                        }
                    }, true);

                    var bounds_group = new L.featureGroup([]);

                    function setBounds() {}

                    map.createPane('pane_OSMStandard_0');

                    map.getPane('pane_OSMStandard_0').style.zIndex = 400;

                    var layer_OSMStandard_0 = L.tileLayer('http://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        pane: 'pane_OSMStandard_0',
                        opacity: 1.0,
                        attribution: '<a href="https://www.openstreetmap.org/copyright"></a>',
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'M.O.'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties[
                                        'M.O.'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                        <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'ph'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties[
                                        'ph'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'Al+3'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties[
                                        'Al+3'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'Fosforo'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties['Fosforo'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'Fertilidad'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties['Fertilidad'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </table>';
                        layer.bindPopup(popupContent, {
                            maxHeight: 400
                        });
                        var popup = layer.getPopup();
                        var content = popup.getContent();
                        var updatedContent = removeEmptyRowsFromPopupContent(content, feature);
                        popup.setContent(updatedContent);
                    }
                    L.control.locate({
                        locateOptions: {
                            maxZoom: 9
                        }
                    }).addTo(map);
                    // Agregar botón en la esquina superior derecha
                    var controlContainer = map.getContainer().querySelector('.leaflet-top.leaflet-right');
                    var statisticsButton = L.control({
                        position: 'topright'
                    });

                    statisticsButton.onAdd = function(map) {
                        var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                        div.innerHTML =
                            '<a href="#" class="leaflet-control-button" title="Datos de cultivos"><i class="fas fa-chart-line style="font-size: 24px;"></i></a>';
                        div.onclick = function() {
                            var datos = obtenerDatosDelPunto(map.getCenter()); // Obtener datos del punto central del mapa
                            cargarContenidoModal(datos);
                            $('#sueloModal').modal('show');
                        };
                        return div;
                    };

                    statisticsButton.addTo(map);
                    // Agregar botón de rotación de cultivos
                    var rotacionButton = L.control({
                        position: 'topright'
                    });

                    rotacionButton.onAdd = function(map) {
                        var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                        div.innerHTML =
                            '<a href="#" class="leaflet-control-button" title="Rotacion de cultivos"><i class="fas fa-sync-alt" style="font-size: 24px;"></i></a>';
                        div.onclick = function() {
                            $('#modalRotacionCultivos').modal('show');
                        };
                        return div;
                    };

                    rotacionButton.addTo(map);

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

                    function obtenerDatosClima(latitud, longitud) {
                        const apiKey = 'aedb1cd9a3c291f93c99f4935328edee';
                        const url =
                            `https://api.openweathermap.org/data/2.5/weather?lat=${latitud}&lon=${longitud}&appid=${apiKey}&units=metric`;

                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                // Procesar los datos climáticos aquí
                                const temperatura = data.main.temp;
                                const humedad = data.main.humidity;
                                const descripcion = data.weather[0].description;
                                // Puedes guardar estos datos en variables o en el objeto de datos del distrito
                            })
                            .catch(error => {
                                console.error('Error al obtener datos climáticos:', error);
                            });
                    }

                    function calcularRiesgo(m_o, ph, al_plus3, fosforo, fertilidad) {
                        let riesgo = 'Bajo';

                        // Definir los rangos de valores para cada factor
                        const m_oRangos = {
                            'baja': 0.25,
                            'media': 0.5,
                            'alta': 1
                        };
                        const phRangos = {
                            'baja': 0.25,
                            'media': 0.5,
                            'alta': 1
                        };
                        const al_plus3Rangos = {
                            'baja': 0.25,
                            'media': 0.5,
                            'alta': 1
                        };
                        const fosforoRangos = {
                            'baja': 0.25,
                            'media': 0.5,
                            'alta': 1
                        };
                        const fertilidadRangos = {
                            'baja': 0.40,
                            'media': 0.5,
                            'alta': 1
                        };

                        // Calcular el puntaje final de riesgo
                        const puntajeRiesgo = (m_oRangos[m_o] + phRangos[ph] + al_plus3Rangos[al_plus3] + fosforoRangos[fosforo] +
                            fertilidadRangos[fertilidad]) / 5;

                        // Asignar el nivel de riesgo en función del puntaje
                        if (puntajeRiesgo <= 0.4) {
                            riesgo = 'Bajo';
                        } else if (puntajeRiesgo > 0.4 && puntajeRiesgo <= 0.7) {
                            riesgo = 'Medio';
                        } else {
                            riesgo = 'Alto';
                        }
                        return riesgo;
                    }

                    function obtenerDatosDelPunto(latLng) {
                        // Obtener los datos de distritos
                        var distritosData = json_Distritos_Caaguazu_4.features;

                        // Obtener los datos de taxonomía de suelos
                        var suelosData = json_Taxonomiadesuelos_DeptoCaaguazucopiar_2.features;

                        // Procesar los datos y construir el objeto a devolver
                        var datos = {
                            distritos: distritosData.map(distrito => ({
                                DIST_DESC: distrito.properties.DIST_DESC,
                                Fertilidad: distrito.properties.Fertilidad,
                                DISTRITO: distrito.properties.DISTRITO,
                                //Riesgo: 'Bajo' // Puedes calcular el riesgo en función de otros datos
                                Riesgo: calcularRiesgo(distrito.properties['M.O.'], distrito.properties[
                                    'ph'], distrito.properties['Al+3'], distrito.properties[
                                    'Fosforo'], distrito.properties['Fertilidad'])
                            })),
                            ordenesSuelo: suelosData.map(suelo => ({
                                ORDEN: suelo.properties.ORDEN,
                                DESC: suelo.properties.DESC,
                                cultivos: suelo.properties.cultivos,
                                //Riesgo: suelo.properties.Riesgo || 'Desconocido' // Agrega la propiedad Riesgo

                            }))
                        };

                        return datos;
                    }
                    var sueloModal = $('#sueloModal');

                    // Asignar el evento de clic al mapa

                    function getBadgeColor(value) {
                        // Define la lógica para obtener el color de la etiqueta en función del valor
                        if (value === 'Bajo') {
                            return 'success';
                        } else if (value === 'Medio') {
                            return 'warning';
                        } else if (value === 'Alto') {
                            return 'danger';
                        } else {
                            return 'secondary';
                        }
                    }

                    function cargarContenidoModal(datos) {
                        // Obtener los datos de la capa Taxonomiadesuelos_DeptoCaaguazucopiar_2
                        var suelosData = json_Taxonomiadesuelos_DeptoCaaguazucopiar_2.features;

                        // Obtener los datos de la capa Distritos_Caaguazu_4
                        var distritosData = json_Distritos_Caaguazu_4.features;

                        // Buscar el distrito seleccionado en los datos de Distritos_Caaguazu_4
                        var distritoSeleccionado = distritosData.find(distrito => distrito.properties.DIST_DESC === datos.distritos[0]
                            .DIST_DESC);

                        // Filtrar los datos de órdenes de suelo por el distrito seleccionado
                        var ordenesDelDistrito = suelosData.filter(suelo => {
                            // Aquí puedes agregar la lógica para filtrar los suelos por distrito
                            // Por ejemplo, si tienes una propiedad "DISTRITO" en la capa de suelos,
                            // puedes hacer:
                            return suelo.properties.DISTRITO === distritoSeleccionado.properties.DISTRITO;
                        });

                        // Obtener los riesgos de los órdenes de suelo
                        var riesgosDelDistrito = ordenesDelDistrito.map(orden => ({
                            ORDEN: orden.properties.ORDEN,
                            Riesgo: calcularRiesgo(distritoSeleccionado.properties['M.O.'], distritoSeleccionado.properties[
                                'ph'], distritoSeleccionado.properties['Al+3'], distritoSeleccionado.properties[
                                'Fosforo'], distritoSeleccionado.properties['Fertilidad'])
                        }));


                        // Construir el HTML de la vista suelos.resultados con los datos filtrados
                        var contenidoModal = `
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Distritos</h5>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-hover datatable"  id="suelostable">
                                        <thead>
                                            <tr>
                                                <th>Distrito</th>
                                                <th>Fertilidad</th>
                                                <th>Riesgo</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${datos.distritos.map(distrito => `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr data-distrito="${distrito.DIST_DESC}" onclick="filtrarOrdeneSuelo(this)">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style="font-size: 13px; font-weight: normal;">${distrito.DIST_DESC}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td><span class="badge badge-${getBadgeColor(distrito.Fertilidad)}">${distrito.Fertilidad}</span></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td><span class="badge badge-${getBadgeColor(distrito.Riesgo)}">${distrito.Riesgo}</span></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Órdenes de Suelo y Cultivos</h5>
                                </div>
                                <div class="card-body card-body-scroll">
                                    ${ordenesDelDistrito.map(orden => `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="mb-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                <h6>${orden.properties.ORDEN}</h6>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <p>${orden.properties.desc_cult}</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <p><strong>Cultivos Recomendados:</strong> ${orden.properties.cultivos}</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <p><strong>Riesgo:</strong> <span class="badge badge-${getBadgeColor(riesgosDelDistrito.find(r => r.ORDEN === orden.properties.ORDEN).Riesgo)}">${riesgosDelDistrito.find(r => r.ORDEN === orden.properties.ORDEN).Riesgo}</span></p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                        // Cargar el contenido en el modal
                        $('#sueloModal .modal-body').html(contenidoModal);
                        $('#sueloModal').modal('show');

                        $('#suelostable').DataTable({
                            pageLength: 4,
                            lengthChange: false,
                            searching: true,
                            info: false,
                            pagingType: 'simple_numbers',
                            language: {
                                paginate: {
                                    previous: '<i class="fas fa-chevron-left"></i>',
                                    next: '<i class="fas fa-chevron-right"></i>'
                                }
                            }
                        });
                    }


                    function calcularCalidadSuelo(Fertilidad, Riesgo) {
                        let calidadSuelo;
                        if (Fertilidad === 'alta' && Riesgo === 'Bajo') {
                            calidadSuelo = 'Excelente';
                        } else if (Fertilidad === 'media' && Riesgo === 'Medio') {
                            calidadSuelo = 'Moderada';
                        } else if (Fertilidad === 'baja' && Riesgo === 'Alto') {
                            calidadSuelo = 'Pobre';
                        } else if (Fertilidad === 'baja' && Riesgo === 'Medio') {
                            calidadSuelo = 'Moderada';
                        } else if (Fertilidad === 'baja' && Riesgo === 'Bajo') {
                            calidadSuelo = 'Pobre';
                        } else {
                            calidadSuelo = 'Desc';
                        }
                        return calidadSuelo;
                    }

                    // Líneas 233 a 283
                    function filtrarOrdeneSuelo(fila) {
                        var distritoSeleccionado = fila.getAttribute('data-distrito');
                        var suelosData = json_Taxonomiadesuelos_DeptoCaaguazucopiar_2.features;
                        var distritosData = json_Distritos_Caaguazu_4.features;

                        // Buscar el distrito seleccionado en los datos de Distritos_Caaguazu_4
                        var distritoObj = distritosData.find(distrito => distrito.properties.DIST_DESC === distritoSeleccionado);
                        if (!distritoObj) {
                            console.error(`No se encontró el distrito seleccionado: ${distritoSeleccionado}`);
                            return;
                        }
                        var ordenesUnicas = {};
                        // Filtrar los datos de órdenes de suelo por el distrito seleccionado
                        var ordenesDelDistrito = suelosData.filter(suelo => {
                            // Aquí se compara la propiedad 'DISTRITO' con la descripción del distrito seleccionado
                            if (suelo.properties.DISTRITO === distritoObj.properties.DISTRITO) {
                                // Si el orden de suelo no está en el objeto ordenesUnicas, lo agrega
                                if (!ordenesUnicas[suelo.properties.ORDEN]) {
                                    ordenesUnicas[suelo.properties.ORDEN] = suelo;
                                    return true; // Solo retornar true si es un suelo único
                                }
                            }
                            return false;
                        });

                        // Obtener los riesgos de los órdenes de suelo
                        var riesgosDelDistrito = ordenesDelDistrito.map(orden => ({
                            ORDEN: orden.properties.ORDEN,
                            Riesgo: calcularRiesgo(
                                distritoObj.properties['M.O.'],
                                distritoObj.properties['ph'],
                                distritoObj.properties['Al+3'],
                                distritoObj.properties['Fosforo'],
                                distritoObj.properties['Fertilidad']
                            )
                        }));

                        // Construir el HTML de la vista de órdenes de suelo
                        var contenidoOrdeneSuelo = `
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Órdenes de Suelo y Cultivos</h5>
            </div>
            <div class="card-body card-body-scroll">
                ${Object.values(ordenesUnicas).map(orden => `
                                                                                                    <div class="mb-3">
                                                                                                        <h6>${orden.properties.ORDEN}</h6>
                                                                                                        <p>${orden.properties.desc_cult}</p>
                                                                                                        <p><strong>Cultivos Recomendados:</strong> ${orden.properties.cultivos}</p>
                                                                                                        <p><strong>Riesgo:</strong> <span class="badge badge-${getBadgeColor(riesgosDelDistrito.find(r => r.ORDEN === orden.properties.ORDEN).Riesgo)}">${riesgosDelDistrito.find(r => r.ORDEN === orden.properties.ORDEN).Riesgo}</span></p>
                                                                                                    </div>
                                                                                                `).join('')}
            </div>
        </div>
    `;

                        // Actualizar el contenido de la sección de órdenes de suelo en el modal
                        $('#sueloModal .modal-body .col-md-6:last-child').html(contenidoOrdeneSuelo);
                    }

                    // Obtener datos de distritos y órdenes de suelo
                    var distritosData = json_Distritos_Caaguazu_4.features;
                    var suelosData = json_Taxonomiadesuelos_DeptoCaaguazucopiar_2.features;

                    // Función para cargar las opciones de distrito
                    function cargarOpcionesDistrito() {
                        var distritoSelect = $('#distritoSelect');
                        distritoSelect.empty();
                        distritoSelect.append('<option value="">Seleccionar Distrito</option>');

                        distritosData.forEach(function(distrito) {
                            distritoSelect.append('<option value="' + distrito.properties.DISTRITO + '">' + distrito.properties
                                .DIST_DESC + '</option>');
                        });
                    }

                    function cargarOpcionesOrdenSuelo(distritoId) {
                        var ordenSueloSelect = $('#ordenSueloSelect');
                        ordenSueloSelect.empty();
                        ordenSueloSelect.append('<option value="">Seleccionar Orden de Suelo</option>');

                        // Filtrar los suelos por distrito
                        var ordenesSuelo = suelosData.filter(function(suelo) {
                            return suelo.properties.DISTRITO === distritoId;
                        });

                        // Crear un objeto para almacenar los órdenes de suelo únicos
                        var ordenesUnicas = {};

                        // Recorrer las órdenes de suelo y agregar solo una vez cada orden
                        ordenesSuelo.forEach(function(suelo) {
                            if (!ordenesUnicas[suelo.properties.ORDEN]) {
                                ordenesUnicas[suelo.properties.ORDEN] = suelo.properties.ORDEN;
                                ordenSueloSelect.append('<option value="' + suelo.properties.ORDEN + '">' + suelo.properties
                                    .ORDEN + '</option>');
                            }
                        });

                        ordenSueloSelect.prop('disabled', false);
                        $('#btnCalcularRotacion').prop('disabled', true);
                    }

                    // Evento change para el select de distrito
                    $('#distritoSelect').change(function() {
                        var distritoId = $(this).val();
                        cargarOpcionesOrdenSuelo(distritoId);
                    });

                    // Evento change para el select de orden de suelo
                    $('#ordenSueloSelect').change(function() {
                        var ordenSuelo = $(this).val();
                        if (ordenSuelo) {
                            $('#btnCalcularRotacion').prop('disabled', false);
                        } else {
                            $('#btnCalcularRotacion').prop('disabled', true);
                        }
                    });

                    // Evento click para el botón Calcular Rotación
                    $('#btnCalcularRotacion').click(function() {
                        var ordenSuelo = $('#ordenSueloSelect').val();

                        if (ordenSuelo) {
                            axios.post('{{ route('calcular') }}', {
                                    ordenSuelo: ordenSuelo
                                })
                                .then(function(response) {
                                    var cultivosRecomendados = response.data;
                                    var cultivosHTML = '';
                                    var columnasRequeridas = Math.ceil(cultivosRecomendados.length /
                                        8); // Máximo 10 cultivos por columna
                                    var cultivosPorColumna = Math.ceil(cultivosRecomendados.length / columnasRequeridas);

                                    // Mostrar el div de "Cultivos recomendados"
                                    $('#cultivosRecomendados').show();

                                    for (var i = 0; i < columnasRequeridas; i++) {
                                        cultivosHTML += '<div class="col-md-' + (12 / columnasRequeridas) + '">';
                                        cultivosHTML += '<ul class="list-group list-group-flush cultivos-columna">';

                                        var inicioIndice = i * cultivosPorColumna;
                                        var finIndice = inicioIndice + cultivosPorColumna;

                                        for (var j = inicioIndice; j < finIndice && j < cultivosRecomendados.length; j++) {
                                            cultivosHTML += '<li class="list-group-item">' + (j + 1) + '. ' +
                                                cultivosRecomendados[j] + '</li>';
                                        }

                                        cultivosHTML += '</ul>';
                                        cultivosHTML += '</div>';
                                    }

                                    $('.cultivos-container').html(cultivosHTML);
                                })
                                .catch(function(error) {
                                    console.error(error);
                                });
                        }
                    });
                    cargarOpcionesDistrito();

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
                    //sera cambia jajaja
                    bounds_group.addLayer(layer_Distritos_Caaguazucopiar_1);
                    map.addLayer(layer_Distritos_Caaguazucopiar_1);
                    var caaguazuBounds = layer_Distritos_Caaguazucopiar_1.getBounds();

                    var osmGeocoder = new L.Control.Geocoder({
                        collapsed: true,
                        position: 'topleft',
                        text: 'Buscar en Caaguazú',
                        title: 'Buscar en Caaguazú',
                        geocoder: new L.Control.Geocoder.Nominatim({
                            geocodingQueryParams: {
                                viewbox: caaguazuBounds.toBBoxString(),
                                bounded: 1
                            }
                        })
                    }).addTo(map);
                    document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
                        .className += ' fa fa-search';
                    document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
                        .title += 'Search for a place';

                    function pop_Taxonomiadesuelos_DeptoCaaguazucopiar_2(feature, layer) {
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
                                                                                                                                                                                                                                                                                                                                                                                                                                            <td class="visible-with-data" id="desc_cult"colspan="2"><strong></strong><br />' +
                            (
                                feature.properties['desc_cult'] !== null ? autolinker.link(feature.properties['desc_cult']
                                    .toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                        </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    </table>';
                        layer.bindPopup(popupContent, {
                            maxHeight: 400
                        });
                        var popup = layer.getPopup();
                        var content = popup.getContent();
                        var updatedContent = removeEmptyRowsFromPopupContent(content, feature);
                        popup.setContent(updatedContent);
                    }

                    function style_Taxonomiadesuelos_DeptoCaaguazucopiar_2_0(feature) {
                        switch (String(feature.properties['ORDEN'])) {
                            case 'AGUA':
                                return {
                                    pane: 'pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
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
                                    pane: 'pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
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
                            case 'ENTISOL':
                                return {
                                    pane: 'pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
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
                                    pane: 'pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
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
                                    pane: 'pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
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
                                    pane: 'pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
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
                                    pane: 'pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
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

                    map.createPane('pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2');
                    map.getPane('pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2').style.zIndex = 402;
                    map.getPane('pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2').style['mix-blend-mode'] = 'normal';
                    var layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2 = new L.geoJson(json_Taxonomiadesuelos_DeptoCaaguazucopiar_2, {
                        attribution: '',
                        interactive: true,
                        dataVar: 'json_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
                        layerName: 'layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
                        pane: 'pane_Taxonomiadesuelos_DeptoCaaguazucopiar_2',
                        onEachFeature: pop_Taxonomiadesuelos_DeptoCaaguazucopiar_2,
                        style: style_Taxonomiadesuelos_DeptoCaaguazucopiar_2_0,
                    });
                    bounds_group.addLayer(layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2);
                    map.addLayer(layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2);

                    function pop_Ciudades_Caaguazu_3(feature, layer) {
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
                        var popup = layer.getPopup();
                        var content = popup.getContent();
                        var updatedContent = removeEmptyRowsFromPopupContent(content, feature);
                        popup.setContent(updatedContent);
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
                    bounds_group.addLayer(layer_Ciudades_Caaguazu_3);
                    map.addLayer(layer_Ciudades_Caaguazu_3);

                    function pop_Distritos_Caaguazu_4(feature, layer) {
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
                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                        <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'M.O.'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties[
                                        'M.O.'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                        <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'ph'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties[
                                        'ph'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                        <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'Al+3'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties[
                                        'Al+3'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                        <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'Fosforo'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties['Fosforo'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                        <td colspan="2">' +
                            (
                                feature
                                .properties[
                                    'Fertilidad'] !==
                                null ?
                                autolinker
                                .link(
                                    feature
                                    .properties['Fertilidad'].toLocaleString()) : '') +
                            '</td>\
                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>\
                                                                                                                                                                                                                                                                                                                                                                                                                                </table>';
                        layer.bindPopup(popupContent, {
                            maxHeight: 400
                        });
                        var popup = layer.getPopup();
                        var content = popup.getContent();
                        var updatedContent = removeEmptyRowsFromPopupContent(content, feature);
                        popup.setContent(updatedContent);
                    }

                    function style_Distritos_Caaguazu_4_0() {
                        return {
                            pane: 'pane_Distritos_Caaguazu_4',
                            opacity: 1,
                            color: 'rgba(36,17,133,1.0)',
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
                    setBounds();
                    var i = 0;
                    layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2.eachLayer(function(layer) {
                        var context = {
                            feature: layer.feature,
                            variables: {}
                        };
                        layer.bindTooltip(function(layer) {
                            var cultivos = layer.feature.properties['cultivos'];
                            if (cultivos !== null) {
                                var lines = chunkString(cultivos, 25); // Ajusta el máximo de caracteres por línea
                                var html =
                                    '<div style="color: #323232; font-size: 7pt; font-weight: bold; font-family: \'Open Sans\', sans-serif;">';
                                for (var i = 0; i < lines.length; i++) {
                                    html += '<div style="background-color: white; padding: 2px;">' + lines[i] +
                                        '</div>';
                                }
                                html += '</div>';
                                return html;
                            }
                            return '';
                        }, {
                            permanent: true,
                            direction: 'top',
                            offset: [0, -15] // Ajusta el desplazamiento vertical de la etiqueta
                        });
                        layer.added = true;
                        addLabel(layer, i);
                        i++;
                    });

                    function chunkString(str, length) {
                        return str.match(new RegExp('.{1,' + length + '}', 'g'));
                    }
                    var i = 0;
                    layer_Distritos_Caaguazu_4.eachLayer(function(layer) {
                        var context = {
                            feature: layer.feature,
                            variables: {}
                        };
                        layer.bindTooltip((layer.feature.properties['DIST_DESC'] !== null ? String(
                            '<div style="color: #401db3; font-size: 5pt; font-family: \'Georgia\', sans-serif;font-weight: bold;">' +
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
                    resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2,
                        layer_Distritos_Caaguazu_4
                    ]);
                    map.on("zoomend", function() {
                        resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2,
                            layer_Distritos_Caaguazu_4
                        ]);
                    });
                    map.on("layeradd", function() {
                        resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2,
                            layer_Distritos_Caaguazu_4
                        ]);
                    });
                    map.on("layerremove", function() {
                        resetLabels([layer_Distritos_Caaguazucopiar_1, layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2,
                            layer_Distritos_Caaguazu_4
                        ]);
                    });
                    layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2.setStyle({
                        fillOpacity: 1
                    });

                    // Creamos el control deslizante para la opacidad
                    var opacidadControl = L.control.opacity(layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2, {
                        label: 'Opacidad de la capa',
                        compact: true,
                        opacityChanged: function(opacity) {
                            layer_Taxonomiadesuelos_DeptoCaaguazucopiar_2.setStyle({
                                fillOpacity: opacity
                            });
                        }
                    });

                    // Agregamos el control deslizante al mapa
                    opacidadControl.addTo(map);
                    var caaguazuBounds = [
                        [-25.623907375757902, -57.13184809789239], // Sudoeste
                        [-24.744947521447436, -55.0321961867199] // Noreste
                    ];
                    // Agregar evento de clic al mapa
                    // Agregar evento de clic al mapa
                    // Agregar evento de clic al mapa
                    map.on('click', function(e) {
                        // Obtener las coordenadas del clic
                        var latlng = e.latlng;

                        // Crear una instancia del servicio de geocodificación inversa
                        var geocoder = L.Control.Geocoder.nominatim();

                        // Realizar la geocodificación inversa
                        geocoder.reverse(latlng, map.options.crs.scale(map.getZoom()), function(geocodedLocation) {
                            if (geocodedLocation && geocodedLocation.name) {
                                // Verificar si el resultado está dentro del departamento de Caaguazú
                                var departamento = '';
                                geocodedLocation.address.country_code === 'py' && geocodedLocation.address.state &&
                                    (departamento = geocodedLocation.address.state.toLowerCase());

                                if (departamento === 'caaguazú') {
                                    // Mostrar el nombre y la dirección en un cuadro de diálogo o cualquier otro lugar
                                    alert('Nombre: ' + geocodedLocation.name + '\nDirección: ' + geocodedLocation
                                        .properties.address.road);
                                } else {
                                    alert('La ubicación seleccionada no está dentro del departamento de Caaguazú');
                                }
                            }
                        });
                    });
                </script>
            @endpush
