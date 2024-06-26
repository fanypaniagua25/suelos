(function(factory) {
    if (typeof define === 'function' && define.amd) {
      // AMD
      define(['leaflet'], factory);
    } else if (typeof module !== 'undefined') {
      // Node/CommonJS
      module.exports = factory(require('leaflet'));
    } else {
      // Browser globals
      if (typeof window.L === 'undefined') {
        throw 'Leaflet must be loaded first';
      }
      factory(window.L);
    }
  }(function(L) {
    L.Control.Opacity = L.Control.extend({
      options: {
        position: 'topright',
        label: null,
        compact: false,
        opacityControl: true,
        outlineControl: false,
        outlineSymbols: {
          glow: '\ue61c',
          outline: '\ue61b'
        }
      },

      initialize: function(overlayLayer, options) {
        this._overlayLayer = overlayLayer;
        L.setOptions(this, options);
      },

      onAdd: function(map) {
        if (this.options.compact) {
          this._initializeCompact(map);
        } else {
          this._initializeFullyFeatured(map);
        }
      },

      _initializeCompact: function(map) {
        this._opacitySlider = L.Browser.mobile ? L.control.opacity(this._overlayLayer, {
          opacityControl: this.options.opacityControl,
          label: false,
          orientation: 'horizontal'
        }) : L.control.opacity(this._overlayLayer, {
          opacityControl: this.options.opacityControl,
          label: false
        });
        if (this.options.label) {
          this._opacitySlider.addOverlay(this.options.label, this._overlayLayer.getOpacity());
        }
        return this._opacitySlider.addTo(map);
      },

      _initializeFullyFeatured: function(map) {
        var container = L.DomUtil.create('div', 'leaflet-bar');
        var wrappedContainer = L.DomUtil.create('div', 'leaflet-opacity-control', container);
        var opacityContainer, opacitySlider;

        if (this.options.opacityControl) {
          opacityContainer = L.DomUtil.create('div', 'leaflet-opacity-control-container', wrappedContainer);

          if (this.options.label) {
            var labelContainer = L.DomUtil.create('div', 'leaflet-opacity-control-label-container', opacityContainer);
            var labelContent = L.DomUtil.create('span', 'leaflet-opacity-control-label', labelContainer);
            labelContent.textContent = this.options.label;
          }

          opacitySlider = L.DomUtil.create('input', 'leaflet-opacity-control-opacity', opacityContainer);
          opacitySlider.type = 'range';
          opacitySlider.min = '0';
          opacitySlider.max = '1';
          opacitySlider.step = '0.01';
          opacitySlider.value = this._overlayLayer.options.opacity;

          L.DomEvent.on(opacitySlider, 'input', this._setOpacityLevel, this);
          L.DomEvent.disableClickPropagation(opacityContainer);

          if (!L.Browser.android) {
            L.DomEvent.on(opacityContainer, 'mousewheel', L.DomEvent.preventDefault, L.DomEvent);
          }
        }

        if (this.options.outlineControl) {
          var outlineContainer = L.DomUtil.create('div', 'leaflet-opacity-control-container', wrappedContainer);
          var outlineContent = L.DomUtil.create('div', 'leaflet-opacity-control-outline', outlineContainer);
          var outline = L.DomUtil.create('span', null, outlineContent);
          var glow = L.DomUtil.create('span', null, outlineContent);

          outline.textContent = this.options.outlineSymbols.outline;
          glow.textContent = this.options.outlineSymbols.glow;

          L.DomEvent.on(outlineContent, 'click', this._toggleOutline, this);
          L.DomEvent.disableClickPropagation(outlineContainer);
        }

        return container;
      },

      _setOpacityLevel: function(e) {
        var opacityLevel = e.target.value;
        this._overlayLayer.setOpacity(opacityLevel);
      },

      _toggleOutline: function() {
        this._overlayLayer.options.outline = !this._overlayLayer.options.outline;
        this._overlayLayer.redraw();
      }
    });

    L.control.opacity = function(overlayLayer, options) {
      return new L.Control.Opacity(overlayLayer, options);
    };
  }));
