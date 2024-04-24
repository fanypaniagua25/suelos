@extends('admin.layouts.master')
@push('style')
    <style>
        #map {
            width: 1450px;
            height: 800px;

        }
    </style>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="/assets/css/leaflet.css">
        <link rel="stylesheet" href="/assets/css/L.Control.Locate.min.css">
        <link rel="stylesheet" href="/assets/css/qgis2web.css">
        <link rel="stylesheet" href="/assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="/assets/css/MarkerCluster.css">
        <link rel="stylesheet" href="/assets/css/MarkerCluster.Default.css">
        @endpush
        @section('content')
        <div id="map">
        </div>
        @endsection
        @push('script')
        <script src="/assets/js/qgis2web_expressions.js"></script>
        <script src="/assets/js/leaflet.js"></script>
        <script src="/assets/js/L.Control.Locate.min.js"></script>
        <script src="/assets/js/leaflet.rotatedMarker.js"></script>
        <script src="/assets/js/leaflet.pattern.js"></script>
        <script src="/assets/js/leaflet-hash.js"></script>
        <script src="/assets/js/Autolinker.min.js"></script>
        <script src="/assets/js/rbush.min.js"></script>
        <script src="/assets/js/labelgun.min.js"></script>
        <script src="/assets/js/labels.js"></script>
        <script src="/assets/js/leaflet.markercluster.js"></script>
        <script src="/assets/js/data/usosuelo_0.js"></script>
        <script src="/assets/js/data/Ciudades_Caaguazu_1.js"></script>
        <script src="/assets/js/data/Distritos_Caaguazu_2.js"></script>
        <script src="/assets/js/data/Viasprincipales_Caaguazu_3.js"></script>
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
        map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank"></a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps"></a> &middot; <a href="https://qgis.org"></a>');
        var autolinker = new Autolinker({truncate: {length: 30, location: 'smart'}});
        L.control.locate({locateOptions: {maxZoom: 19}}).addTo(map);
        var bounds_group = new L.featureGroup([]);
        function setBounds() {
            if (bounds_group.getLayers().length) {
                map.fitBounds(bounds_group.getBounds());
            }
            map.setMaxBounds(map.getBounds());
        }
        function pop_usosuelo_0(feature, layer) {
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
                        <th scope="row"></th>\
                        <td>' + (feature.properties['name'] !== null ? autolinker.link(feature.properties['name'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_usosuelo_0_0(feature) {
            switch(String(feature.properties['DN'])) {
                case '1':
                    return {
                pane: 'pane_usosuelo_0',
                stroke: false,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(65,155,223,1.0)',
                interactive: true,
            }
                    break;
                case '2':
                    return {
                pane: 'pane_usosuelo_0',
                stroke: false,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(57,125,73,1.0)',
                interactive: true,
            }
                    break;
                case '4':
                    return {
                pane: 'pane_usosuelo_0',
                stroke: false,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(122,135,198,1.0)',
                interactive: true,
            }
                    break;
                case '5':
                    return {
                pane: 'pane_usosuelo_0',
                stroke: false,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(228,150,53,1.0)',
                interactive: true,
            }
                    break;
                case '7':
                    return {
                pane: 'pane_usosuelo_0',
                stroke: false,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(196,40,27,1.0)',
                interactive: true,
            }
                    break;
                case '8':
                    return {
                pane: 'pane_usosuelo_0',
                stroke: false,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(165,155,143,1.0)',
                interactive: true,
            }
                    break;
                case '11':
                    return {
                pane: 'pane_usosuelo_0',
                stroke: false,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(227,226,195,1.0)',
                interactive: true,
            }
                    break;
            }
        }
        map.createPane('pane_usosuelo_0');
        map.getPane('pane_usosuelo_0').style.zIndex = 400;
        map.getPane('pane_usosuelo_0').style['mix-blend-mode'] = 'normal';
        var layer_usosuelo_0 = new L.geoJson(json_usosuelo_0, {
            attribution: '',
            interactive: true,
            dataVar: 'json_usosuelo_0',
            layerName: 'layer_usosuelo_0',
            pane: 'pane_usosuelo_0',
            onEachFeature: pop_usosuelo_0,
            style: style_usosuelo_0_0,
        });
        bounds_group.addLayer(layer_usosuelo_0);
        map.addLayer(layer_usosuelo_0);
        function pop_Ciudades_Caaguazu_1(feature, layer) {
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
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_Ciudades_Caaguazu_1_0(feature));
            },
        });
        var cluster_Ciudades_Caaguazu_1 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_Ciudades_Caaguazu_1.addLayer(layer_Ciudades_Caaguazu_1);

        bounds_group.addLayer(layer_Ciudades_Caaguazu_1);
        cluster_Ciudades_Caaguazu_1.addTo(map);
        function pop_Distritos_Caaguazu_2(feature, layer) {
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
        L.control.layers(baseMaps,{'<img src="/assets/legend/Viasprincipales_Caaguazu_3.png" /> Vias principales_Caaguazu': layer_Viasprincipales_Caaguazu_3,'<img src="/assets/legend/Distritos_Caaguazu_2.png" /> Distritos_Caaguazu': layer_Distritos_Caaguazu_2,'<img src="/assets/legend/Ciudades_Caaguazu_1.png" /> Ciudades_Caaguazu': cluster_Ciudades_Caaguazu_1,'usosuelo<br /><table><tr><td style="text-align: center;"><img src="/assets/legend/usosuelo_0_AGUA0.png" /></td><td>AGUA</td></tr><tr><td style="text-align: center;"><img src="/assets/legend/usosuelo_0_ÁRBOLES1.png" /></td><td>ÁRBOLES</td></tr><tr><td style="text-align: center;"><img src="/assets/legend/usosuelo_0_VEGETACIÓNINUNDADA2.png" /></td><td>VEGETACIÓN INUNDADA</td></tr><tr><td style="text-align: center;"><img src="/assets/legend/usosuelo_0_CULTIVOS3.png" /></td><td>CULTIVOS</td></tr><tr><td style="text-align: center;"><img src="/assets/legend/usosuelo_0_ÁREACONSTRUÍDA4.png" /></td><td>ÁREA CONSTRUÍDA</td></tr><tr><td style="text-align: center;"><img src="/assets/legend/usosuelo_0_SUELODESNUDO5.png" /></td><td>SUELO DESNUDO</td></tr><tr><td style="text-align: center;"><img src="/assets/legend/usosuelo_0_PASTIZALES6.png" /></td><td>PASTIZALES</td></tr></table>': layer_usosuelo_0,}).addTo(map);
        setBounds();
        var i = 0;
        layer_Distritos_Caaguazu_2.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['DIST_DESC'] !== null?String('<div style="color: #000000; font-size: 6pt; font-family: \'Forte\', sans-serif;">' + layer.feature.properties['DIST_DESC']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_Distritos_Caaguazu_2'});
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
            layer.bindTooltip((layer.feature.properties['NOMBRE'] !== null?String('<div style="color: #28449b; font-size: 5pt; font-weight: bold; font-family: \'Open Sans\', sans-serif;">' + layer.feature.properties['NOMBRE']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_Viasprincipales_Caaguazu_3'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
        resetLabels([layer_Distritos_Caaguazu_2,layer_Viasprincipales_Caaguazu_3]);
        map.on("zoomend", function(){
            resetLabels([layer_Distritos_Caaguazu_2,layer_Viasprincipales_Caaguazu_3]);
        });
        map.on("layeradd", function(){
            resetLabels([layer_Distritos_Caaguazu_2,layer_Viasprincipales_Caaguazu_3]);
        });
        map.on("layerremove", function(){
            resetLabels([layer_Distritos_Caaguazu_2,layer_Viasprincipales_Caaguazu_3]);
        });
        </script>
 @endpush
