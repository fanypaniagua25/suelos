var wms_layers = [];

var format_mapita_0 = new ol.format.GeoJSON();
var features_mapita_0 = format_mapita_0.readFeatures(json_mapita_0, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_mapita_0 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_mapita_0.addFeatures(features_mapita_0);
var lyr_mapita_0 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_mapita_0, 
                style: style_mapita_0,
                interactive: true,
                title: '<img src="styles/legend/mapita_0.png" /> mapita'
            });
var format_etiquetitas_1 = new ol.format.GeoJSON();
var features_etiquetitas_1 = format_etiquetitas_1.readFeatures(json_etiquetitas_1, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_etiquetitas_1 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_etiquetitas_1.addFeatures(features_etiquetitas_1);
var lyr_etiquetitas_1 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_etiquetitas_1, 
                style: style_etiquetitas_1,
                interactive: true,
                title: '<img src="styles/legend/etiquetitas_1.png" /> etiquetitas'
            });
var format_Viasprincipales_Caaguazu_2 = new ol.format.GeoJSON();
var features_Viasprincipales_Caaguazu_2 = format_Viasprincipales_Caaguazu_2.readFeatures(json_Viasprincipales_Caaguazu_2, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_Viasprincipales_Caaguazu_2 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Viasprincipales_Caaguazu_2.addFeatures(features_Viasprincipales_Caaguazu_2);
var lyr_Viasprincipales_Caaguazu_2 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Viasprincipales_Caaguazu_2, 
                style: style_Viasprincipales_Caaguazu_2,
                interactive: true,
                title: '<img src="styles/legend/Viasprincipales_Caaguazu_2.png" /> Vias principales_Caaguazu'
            });
var format_Distritos_Caaguazu_3 = new ol.format.GeoJSON();
var features_Distritos_Caaguazu_3 = format_Distritos_Caaguazu_3.readFeatures(json_Distritos_Caaguazu_3, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_Distritos_Caaguazu_3 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Distritos_Caaguazu_3.addFeatures(features_Distritos_Caaguazu_3);
var lyr_Distritos_Caaguazu_3 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Distritos_Caaguazu_3, 
                style: style_Distritos_Caaguazu_3,
                interactive: true,
                title: '<img src="styles/legend/Distritos_Caaguazu_3.png" /> Distritos_Caaguazu'
            });
var format_Ciudades_Caaguazu_4 = new ol.format.GeoJSON();
var features_Ciudades_Caaguazu_4 = format_Ciudades_Caaguazu_4.readFeatures(json_Ciudades_Caaguazu_4, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_Ciudades_Caaguazu_4 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Ciudades_Caaguazu_4.addFeatures(features_Ciudades_Caaguazu_4);
var lyr_Ciudades_Caaguazu_4 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Ciudades_Caaguazu_4, 
                style: style_Ciudades_Caaguazu_4,
                interactive: true,
                title: '<img src="styles/legend/Ciudades_Caaguazu_4.png" /> Ciudades_Caaguazu'
            });
var group_tipo_suelos = new ol.layer.Group({
                                layers: [lyr_mapita_0,lyr_etiquetitas_1,lyr_Viasprincipales_Caaguazu_2,lyr_Distritos_Caaguazu_3,lyr_Ciudades_Caaguazu_4,],
                                title: "tipo_suelos"});

lyr_mapita_0.setVisible(true);lyr_etiquetitas_1.setVisible(true);lyr_Viasprincipales_Caaguazu_2.setVisible(true);lyr_Distritos_Caaguazu_3.setVisible(true);lyr_Ciudades_Caaguazu_4.setVisible(true);
var layersList = [group_tipo_suelos];
lyr_mapita_0.set('fieldAliases', {});
lyr_etiquetitas_1.set('fieldAliases', {});
lyr_Viasprincipales_Caaguazu_2.set('fieldAliases', {'NOMBRE': 'NOMBRE', 'LONG_KM_EN': 'LONG_KM_EN', 'RUTA_NRO': 'RUTA_NRO', 'ANCHO': 'ANCHO', 'TIPO': 'TIPO', 'LONG_MTS': 'LONG_MTS', });
lyr_Distritos_Caaguazu_3.set('fieldAliases', {'DPTO': 'DPTO', 'DISTRITO': 'DISTRITO', 'DPTO_DESC': 'DPTO_DESC', 'DIST_DESC': 'DIST_DESC', 'CLAVE': 'CLAVE', 'auxiliary_storage_labeling_positionx': 'auxiliary_storage_labeling_positionx', 'auxiliary_storage_labeling_positiony': 'auxiliary_storage_labeling_positiony', 'auxiliary_storage_labeling_show': 'auxiliary_storage_labeling_show', 'auxiliary_storage_labeling_labelrotation': 'auxiliary_storage_labeling_labelrotation', 'auxiliary_storage_labeling_family': 'auxiliary_storage_labeling_family', 'auxiliary_storage_labeling_fontstyle': 'auxiliary_storage_labeling_fontstyle', 'auxiliary_storage_labeling_size': 'auxiliary_storage_labeling_size', 'auxiliary_storage_labeling_bold': 'auxiliary_storage_labeling_bold', 'auxiliary_storage_labeling_italic': 'auxiliary_storage_labeling_italic', 'auxiliary_storage_labeling_underline': 'auxiliary_storage_labeling_underline', 'auxiliary_storage_labeling_color': 'auxiliary_storage_labeling_color', 'auxiliary_storage_labeling_strikeout': 'auxiliary_storage_labeling_strikeout', 'auxiliary_storage_labeling_multilinealignment': 'auxiliary_storage_labeling_multilinealignment', 'auxiliary_storage_labeling_buffersize': 'auxiliary_storage_labeling_buffersize', 'auxiliary_storage_labeling_buffercolor': 'auxiliary_storage_labeling_buffercolor', 'auxiliary_storage_labeling_bufferdraw': 'auxiliary_storage_labeling_bufferdraw', 'auxiliary_storage_labeling_labeldistance': 'auxiliary_storage_labeling_labeldistance', 'auxiliary_storage_labeling_hali': 'auxiliary_storage_labeling_hali', 'auxiliary_storage_labeling_vali': 'auxiliary_storage_labeling_vali', 'auxiliary_storage_labeling_scalevisibility': 'auxiliary_storage_labeling_scalevisibility', 'auxiliary_storage_labeling_minscale': 'auxiliary_storage_labeling_minscale', 'auxiliary_storage_labeling_maxscale': 'auxiliary_storage_labeling_maxscale', 'auxiliary_storage_labeling_alwaysshow': 'auxiliary_storage_labeling_alwaysshow', 'auxiliary_storage_labeling_calloutdraw': 'auxiliary_storage_labeling_calloutdraw', 'auxiliary_storage_labeling_labelallparts': 'auxiliary_storage_labeling_labelallparts', });
lyr_Ciudades_Caaguazu_4.set('fieldAliases', {'DPTO': 'DPTO', 'DPTO_DESC': 'DPTO_DESC', 'DISTRITO': 'DISTRITO', 'DIST_DESC': 'DIST_DESC', 'CLAVE': 'CLAVE', });
lyr_mapita_0.set('fieldImages', {});
lyr_etiquetitas_1.set('fieldImages', {});
lyr_Viasprincipales_Caaguazu_2.set('fieldImages', {'NOMBRE': 'TextEdit', 'LONG_KM_EN': 'Range', 'RUTA_NRO': 'TextEdit', 'ANCHO': 'Range', 'TIPO': 'Range', 'LONG_MTS': 'TextEdit', });
lyr_Distritos_Caaguazu_3.set('fieldImages', {'DPTO': 'TextEdit', 'DISTRITO': 'TextEdit', 'DPTO_DESC': 'TextEdit', 'DIST_DESC': 'TextEdit', 'CLAVE': 'TextEdit', 'auxiliary_storage_labeling_positionx': 'Hidden', 'auxiliary_storage_labeling_positiony': 'Hidden', 'auxiliary_storage_labeling_show': 'Hidden', 'auxiliary_storage_labeling_labelrotation': 'Hidden', 'auxiliary_storage_labeling_family': 'Hidden', 'auxiliary_storage_labeling_fontstyle': 'Hidden', 'auxiliary_storage_labeling_size': 'Hidden', 'auxiliary_storage_labeling_bold': 'Hidden', 'auxiliary_storage_labeling_italic': 'Hidden', 'auxiliary_storage_labeling_underline': 'Hidden', 'auxiliary_storage_labeling_color': 'Hidden', 'auxiliary_storage_labeling_strikeout': 'Hidden', 'auxiliary_storage_labeling_multilinealignment': 'Hidden', 'auxiliary_storage_labeling_buffersize': 'Hidden', 'auxiliary_storage_labeling_buffercolor': 'Hidden', 'auxiliary_storage_labeling_bufferdraw': 'Hidden', 'auxiliary_storage_labeling_labeldistance': 'Hidden', 'auxiliary_storage_labeling_hali': 'Hidden', 'auxiliary_storage_labeling_vali': 'Hidden', 'auxiliary_storage_labeling_scalevisibility': 'Hidden', 'auxiliary_storage_labeling_minscale': 'Hidden', 'auxiliary_storage_labeling_maxscale': 'Hidden', 'auxiliary_storage_labeling_alwaysshow': 'Hidden', 'auxiliary_storage_labeling_calloutdraw': 'Hidden', 'auxiliary_storage_labeling_labelallparts': 'Hidden', });
lyr_Ciudades_Caaguazu_4.set('fieldImages', {'DPTO': '', 'DPTO_DESC': '', 'DISTRITO': '', 'DIST_DESC': '', 'CLAVE': '', });
lyr_mapita_0.set('fieldLabels', {});
lyr_etiquetitas_1.set('fieldLabels', {});
lyr_Viasprincipales_Caaguazu_2.set('fieldLabels', {});
lyr_Distritos_Caaguazu_3.set('fieldLabels', {});
lyr_Ciudades_Caaguazu_4.set('fieldLabels', {});
lyr_Ciudades_Caaguazu_4.on('precompose', function(evt) {
    evt.context.globalCompositeOperation = 'normal';
});