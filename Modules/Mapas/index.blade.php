<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="css/leaflet.css">
        <link rel="stylesheet" href="css/qgis2web.css">
        <link rel="stylesheet" href="css/fontawesome-all.min.css">
        <link rel="stylesheet" href="css/MarkerCluster.css">
        <link rel="stylesheet" href="css/MarkerCluster.Default.css">
        <link rel="stylesheet" href="css/leaflet-control-geocoder.Geocoder.css">
        <link rel="stylesheet" href="css/leaflet-measure.css">
        <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-database.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Otros módulos de Firebase que necesites -->


        <style>
        #map {
            width: 1366px;
            height: 534px;
        }
        </style>
        <title></title>
    </head>
    <body>
        <div id="map">
        </div>
        <script src="js/qgis2web_expressions.js"></script>
        <script src="js/leaflet.js"></script>
        <script src="js/leaflet.rotatedMarker.js"></script>
        <script src="js/leaflet.pattern.js"></script>
        <script src="js/leaflet-hash.js"></script>
        <script src="js/Autolinker.min.js"></script>
        <script src="js/rbush.min.js"></script>
        <script src="js/labelgun.min.js"></script>
        <script src="js/labels.js"></script>
        <script src="js/leaflet-control-geocoder.Geocoder.js"></script>
        <script src="js/leaflet-measure.js"></script>
        <script src="js/leaflet.markercluster.js"></script>
        <script src="data/Taxonomiadesuelos_DeptoCaaguazu_0.js"></script>
        <script src="data/mapita_1.js"></script>
        <script src="data/Ciudades_Caaguazu_2.js"></script>
        <script src="data/Distritos_Caaguazu_3.js"></script>
        <script src="data/Viasprincipales_Caaguazu_4.js"></script>
        <script>
        var highlightLayer;
        function highlightFeature(e) {
            highlightLayer = e.target;
            highlightLayer.openPopup();
        }
        var map = L.map('map', {
            zoomControl:true, maxZoom:28, minZoom:1
        })
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>');
        var autolinker = new Autolinker({truncate: {length: 30, location: 'smart'}});
        var measureControl = new L.Control.Measure({
            position: 'topleft',
            primaryLengthUnit: 'meters',
            secondaryLengthUnit: 'kilometers',
            primaryAreaUnit: 'sqmeters',
            secondaryAreaUnit: 'hectares'
        });
        measureControl.addTo(map);
        document.getElementsByClassName('leaflet-control-measure-toggle')[0]
        .innerHTML = '';
        document.getElementsByClassName('leaflet-control-measure-toggle')[0]
        .className += ' fas fa-ruler';
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
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['ORDEN'] !== null ? autolinker.link(feature.properties['ORDEN'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">DESC</th>\
                        <td>' + (feature.properties['DESC'] !== null ? autolinker.link(feature.properties['DESC'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_Taxonomiadesuelos_DeptoCaaguazu_0_0() {
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
                fillColor: 'rgba(253,239,199,1.0)',
                interactive: true,
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
        function pop_mapita_1(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['FID'] !== null ? autolinker.link(feature.properties['FID'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_mapita_1_0() {
            return {
                pane: 'pane_mapita_1',
                opacity: 1,
                color: 'rgba(195,116,31,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(253,239,199,1.0)',
                interactive: false,
            }
        }

        function user() {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: 'http://localhost:8000/obtener',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }
function editSoil(e) {
    user()
        .then(function(currentUser) {
            console.log("Usuario actual:", currentUser);
    if (userIsAdminOrSuperadmin(currentUser)) {
        // El usuario es un administrador o superadministrador, permite la edición
        var selectedSoil = e.target;

        // Mostrar un cuadro de diálogo con opciones para cambiar el campo "ORDEN"
        var newOrden = prompt("Nuevo valor para 'ORDEN':", selectedSoil.feature.properties.ORDEN);

        // Mostrar un cuadro de diálogo con opciones para cambiar el campo "DESC"
        var newDesc = prompt("Nuevo valor para 'DESC':", selectedSoil.feature.properties.DESC);

        if (newOrden !== null && newDesc !== null) {
            // Actualizar los campos en los datos
            selectedSoil.feature.properties.ORDEN = newOrden;
            selectedSoil.feature.properties.DESC = newDesc;

            // Actualizar el contenido del marcador (esto depende de cómo deseas representar los cambios)
            selectedSoil.bindPopup("ORDEN: " + newOrden + "<br>DESC: " + newDesc);

            // Redibujar la característica para aplicar los cambios
            selectedSoil.redraw();

            // Puedes guardar estos cambios en tus datos GeoJSON si es necesario
            // Por ejemplo, podrías enviar una solicitud al servidor para actualizar los datos.

            // Mostrar un mensaje de confirmación
            alert("Suelo actualizado con éxito.");
        }
    }
})
    .catch(function(error) {
        console.error('Error al obtener el usuario:', error);
        alert("Error al obtener el usuario.");
    });
}
function userIsAdminOrSuperadmin(currentUser) {
    // Asegúrate de ajustar esto según la estructura de tu sistema de usuarios.
    return currentUser && (currentUser.role === 'admin' || currentUser.role === 'superadmin');
}

// Asignar la función de edición a los polígonos
layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function (layer) {
    layer.on('click', editSoil);
});

// Ejemplo de uso:



        /*function editSoil(e) {
    var selectedSoil = e.target;
    var newORDEN = prompt("Nuevo valor para 'ORDEN':");
    var newDESC = prompt("Nuevo valor para 'DESC':");

    // Asigna los nuevos valores a las propiedades
    selectedSoil.feature.properties.ORDEN = newORDEN;
    selectedSoil.feature.properties.DESC = newDESC;

    // Elimina la capa del mapa
    map.removeLayer(selectedSoil);

    // Agrega la capa nuevamente al mapa
    map.addLayer(selectedSoil);
}

layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function(layer) {
    layer.on('click', function(e) {
        editSoil(e);
    });
});*/



        map.createPane('pane_mapita_1');
        map.getPane('pane_mapita_1').style.zIndex = 401;
        map.getPane('pane_mapita_1').style['mix-blend-mode'] = 'normal';
        var layer_mapita_1 = new L.geoJson(json_mapita_1, {
            attribution: '',
            interactive: false,
            dataVar: 'json_mapita_1',
            layerName: 'layer_mapita_1',
            pane: 'pane_mapita_1',
            onEachFeature: pop_mapita_1,
            style: style_mapita_1_0,
        });
        bounds_group.addLayer(layer_mapita_1);
        map.addLayer(layer_mapita_1);
        function pop_Ciudades_Caaguazu_2(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['DPTO'] !== null ? autolinker.link(feature.properties['DPTO'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['DPTO_DESC'] !== null ? autolinker.link(feature.properties['DPTO_DESC'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['DISTRITO'] !== null ? autolinker.link(feature.properties['DISTRITO'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['DIST_DESC'] !== null ? autolinker.link(feature.properties['DIST_DESC'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['CLAVE'] !== null ? autolinker.link(feature.properties['CLAVE'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_Ciudades_Caaguazu_2_0() {
            return {
                pane: 'pane_Ciudades_Caaguazu_2',
                radius: 4.0,
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(141,90,153,1.0)',
                interactive: false,
            }
        }
        map.createPane('pane_Ciudades_Caaguazu_2');
        map.getPane('pane_Ciudades_Caaguazu_2').style.zIndex = 402;
        map.getPane('pane_Ciudades_Caaguazu_2').style['mix-blend-mode'] = 'normal';
        var layer_Ciudades_Caaguazu_2 = new L.geoJson(json_Ciudades_Caaguazu_2, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Ciudades_Caaguazu_2',
            layerName: 'layer_Ciudades_Caaguazu_2',
            pane: 'pane_Ciudades_Caaguazu_2',
            onEachFeature: pop_Ciudades_Caaguazu_2,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_Ciudades_Caaguazu_2_0(feature));
            },
        });
        var cluster_Ciudades_Caaguazu_2 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_Ciudades_Caaguazu_2.addLayer(layer_Ciudades_Caaguazu_2);

        bounds_group.addLayer(layer_Ciudades_Caaguazu_2);
        cluster_Ciudades_Caaguazu_2.addTo(map);
        function pop_Distritos_Caaguazu_3(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['DPTO'] !== null ? autolinker.link(feature.properties['DPTO'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['DISTRITO'] !== null ? autolinker.link(feature.properties['DISTRITO'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['DPTO_DESC'] !== null ? autolinker.link(feature.properties['DPTO_DESC'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['DIST_DESC'] !== null ? autolinker.link(feature.properties['DIST_DESC'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['CLAVE'] !== null ? autolinker.link(feature.properties['CLAVE'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_Distritos_Caaguazu_3_0() {
            return {
                pane: 'pane_Distritos_Caaguazu_3',
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
        map.createPane('pane_Distritos_Caaguazu_3');
        map.getPane('pane_Distritos_Caaguazu_3').style.zIndex = 403;
        map.getPane('pane_Distritos_Caaguazu_3').style['mix-blend-mode'] = 'normal';
        var layer_Distritos_Caaguazu_3 = new L.geoJson(json_Distritos_Caaguazu_3, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Distritos_Caaguazu_3',
            layerName: 'layer_Distritos_Caaguazu_3',
            pane: 'pane_Distritos_Caaguazu_3',
            onEachFeature: pop_Distritos_Caaguazu_3,
            style: style_Distritos_Caaguazu_3_0,
        });
        bounds_group.addLayer(layer_Distritos_Caaguazu_3);
        map.addLayer(layer_Distritos_Caaguazu_3);
        function pop_Viasprincipales_Caaguazu_4(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['NOMBRE'] !== null ? autolinker.link(feature.properties['NOMBRE'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['LONG_KM_EN'] !== null ? autolinker.link(feature.properties['LONG_KM_EN'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['RUTA_NRO'] !== null ? autolinker.link(feature.properties['RUTA_NRO'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['ANCHO'] !== null ? autolinker.link(feature.properties['ANCHO'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['TIPO'] !== null ? autolinker.link(feature.properties['TIPO'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['LONG_MTS'] !== null ? autolinker.link(feature.properties['LONG_MTS'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_Viasprincipales_Caaguazu_4_0() {
            return {
                pane: 'pane_Viasprincipales_Caaguazu_4',
                opacity: 1,
                color: 'rgba(31,120,180,1.0)',
                dashArray: '',
                lineCap: 'square',
                lineJoin: 'bevel',
                weight: 1.0,
                fillOpacity: 0,
                interactive: false,
            }
        }
        map.createPane('pane_Viasprincipales_Caaguazu_4');
        map.getPane('pane_Viasprincipales_Caaguazu_4').style.zIndex = 404;
        map.getPane('pane_Viasprincipales_Caaguazu_4').style['mix-blend-mode'] = 'normal';
        var layer_Viasprincipales_Caaguazu_4 = new L.geoJson(json_Viasprincipales_Caaguazu_4, {
            attribution: '',
            interactive: false,
            dataVar: 'json_Viasprincipales_Caaguazu_4',
            layerName: 'layer_Viasprincipales_Caaguazu_4',
            pane: 'pane_Viasprincipales_Caaguazu_4',
            onEachFeature: pop_Viasprincipales_Caaguazu_4,
            style: style_Viasprincipales_Caaguazu_4_0,
        });
        bounds_group.addLayer(layer_Viasprincipales_Caaguazu_4);
        map.addLayer(layer_Viasprincipales_Caaguazu_4);
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
        L.control.layers(baseMaps,{'<img src="legend/Viasprincipales_Caaguazu_4.png" /> Vias principales_Caaguazu': layer_Viasprincipales_Caaguazu_4,'<img src="legend/Distritos_Caaguazu_3.png" /> Distritos_Caaguazu': layer_Distritos_Caaguazu_3,'<img src="legend/Ciudades_Caaguazu_2.png" /> Ciudades_Caaguazu': cluster_Ciudades_Caaguazu_2,'<img src="legend/mapita_1.png" /> mapita': layer_mapita_1,'<img src="legend/Taxonomiadesuelos_DeptoCaaguazu_0.png" /> Taxonomia de suelos_Depto Caaguazu': layer_Taxonomiadesuelos_DeptoCaaguazu_0,}).addTo(map);
        setBounds();
        var i = 0;
        layer_Taxonomiadesuelos_DeptoCaaguazu_0.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['ORDEN'] !== null?String('<div style="color: #323232; font-size: 5pt; font-family: \'Open Sans\', sans-serif;">' + layer.feature.properties['ORDEN']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_Taxonomiadesuelos_DeptoCaaguazu_0'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
        var i = 0;
        layer_Distritos_Caaguazu_3.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['DIST_DESC'] !== null?String('<div style="color: #323232; font-size: 7pt; font-weight: bold; font-style: italic; font-family: \'Open Sans\', sans-serif;">' + layer.feature.properties['DIST_DESC']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_Distritos_Caaguazu_3'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
        var i = 0;
        layer_Viasprincipales_Caaguazu_4.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['NOMBRE'] !== null?String('<div style="color: #28449b; font-size: 5pt; font-weight: bold; font-style: italic; font-family: \'Open Sans\', sans-serif;">' + layer.feature.properties['NOMBRE']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_Viasprincipales_Caaguazu_4'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
        resetLabels([layer_Taxonomiadesuelos_DeptoCaaguazu_0,layer_Distritos_Caaguazu_3,layer_Viasprincipales_Caaguazu_4]);
        map.on("zoomend", function(){
            resetLabels([layer_Taxonomiadesuelos_DeptoCaaguazu_0,layer_Distritos_Caaguazu_3,layer_Viasprincipales_Caaguazu_4]);
        });
        map.on("layeradd", function(){
            resetLabels([layer_Taxonomiadesuelos_DeptoCaaguazu_0,layer_Distritos_Caaguazu_3,layer_Viasprincipales_Caaguazu_4]);
        });
        map.on("layerremove", function(){
            resetLabels([layer_Taxonomiadesuelos_DeptoCaaguazu_0,layer_Distritos_Caaguazu_3,layer_Viasprincipales_Caaguazu_4]);
        });
        </script>
    </body>
</html>
