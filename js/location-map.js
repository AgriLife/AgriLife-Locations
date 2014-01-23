var $, AgLocations, apikey, encodedQuery, encryptedid, keystring, query, queryUrlHead, queryUrlTail, queryurl;

$ = jQuery;

apikey = "AIzaSyAwvTAlWZ9tj8b4-1QWHwFl3ILodM7u0jA";

queryUrlHead = "https://www.googleapis.com/fusiontables/v1/query?sql=";

queryUrlTail = "&callback=?";

encryptedid = "19aSULi0NxobDXvjbc6ygoNoYhYLrFLhACu7Dyuw";

query = "SELECT 'Unit Name', 'Type' FROM " + encryptedid + " ORDER BY 'Unit Name'";

encodedQuery = encodeURIComponent(query);

keystring = "&key=" + apikey;

queryurl = encodeURI(queryUrlHead + query + queryUrlTail);

AgLocations = {};

AgLocations.Model = {};

AgLocations.View = {};

AgLocations.Part = {};

AgLocations.Router = {};

AgLocations.Collection = {};

AgLocations.Layer = {};

AgLocations.url = [queryUrlHead];

AgLocations.url.push(encodedQuery);

AgLocations.url.push(keystring);

AgLocations.url.push(queryUrlTail);

AgLocations.tableid = 2891754;

AgLocations.Model.Map = Backbone.Model.extend({
  defaults: {
    id: '',
    currentLatLng: {},
    mapOptions: {},
    map: {},
    position: {},
    zoom: 1,
    maxZoom: 18,
    minZoom: 3
  },
  initMap: function(position) {
    var currentLatLng, mapOptions;
    this.set('position', position);
    currentLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    this.set('currentLatLng', currentLatLng);
    mapOptions = {
      zoom: this.get('zoom'),
      minZoom: this.get('minZoom'),
      maxZoom: this.get('maxZoom'),
      center: currentLatLng,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControl: false
    };
    return this.set('mapOptions', mapOptions);
  }
});

AgLocations.View.Map = Backbone.View.extend({
  defaults: {
    region: 'us',
    language: 'en'
  },
  id: 'locations-map',
  initialize: function() {
    var aghq, marker;
    this.model.set('map', new google.maps.Map(this.el, this.model.get('mapOptions')));
    aghq = new google.maps.LatLng(30.5997762, -96.3522229);
    return marker = new google.maps.Marker({
      map: this.model.get('map'),
      position: aghq,
      icon: new google.maps.MarkerImage("http://agrilife.org/template-agriflex/wp-content/themes/AgriLife-Locations/images/agrilife-marker.png")
    });
  },
  render: function() {
    $("#" + this.id).replaceWith(this.el);
    return this;
  }
});

AgLocations.Model.Location = Backbone.Model.extend({});

AgLocations.Collection.Locations = Backbone.Collection.extend({
  model: AgLocations.Model.Location,
  url: AgLocations.url.join(''),
  initialize: function() {
    return this.deferred = this.fetch();
  },
  parse: function(response) {
    return response.rows;
  }
});

AgLocations.View.Layer = Backbone.View.extend({
  initialize: function(options) {
    this.options = options || {};
    this.layer = new google.maps.FusionTablesLayer;
    return this.layer.setMap(this.model.get('map'));
  },
  render: function() {
    query = {
      select: 'Location',
      from: AgLocations.tableid
    };
    if (_.isObject(this.options.filter)) {
      query.where = "'" + this.options.filter.type + "' = '" + this.options.filter.parameter + "'";
    }
    return this.layer.setQuery(query);
  }
});

AgLocations.View.Options = Backbone.View.extend({
  events: {
    "click .legend-button": "togglePanel",
    "click .office": "selectAgency",
    "change select": "selectUnit",
    "click #reset": "showAll"
  },
  selectAgency: function(event) {
    var type;
    event.preventDefault();
    type = $(event.currentTarget).attr("value");
    return AgLocations.App.navigate("type/" + type, {
      trigger: true
    });
  },
  selectUnit: function(event) {
    var unit;
    event.preventDefault();
    unit = encodeURIComponent($(event.currentTarget).attr("value"));
    return AgLocations.App.navigate("unit/" + unit, {
      trigger: true
    });
  },
  showAll: function(event) {
    event.preventDefault();
    return AgLocations.App.navigate("", {
      trigger: true
    });
  },
  render: function() {
    var _this = this;
    return this.collection.deferred.then(function(response, error, xhr) {
      _this.extension = _this.collection.where({
        1: "1"
      });
      _this.research = _this.collection.where({
        1: "2"
      });
      _this.tvmdl = _this.collection.where({
        1: "3"
      });
      _this.tfs = _this.collection.where({
        1: "4"
      });
      new AgLocations.View.Select({
        collection: _this.extension,
        el: "#ext-locations"
      });
      return new AgLocations.View.Select({
        collection: _this.research,
        el: "#res-locations"
      });
    });
  },
  togglePanel: function(event) {
    return this.$(".legend-inner").slideToggle('medium');
  }
});

AgLocations.View.Select = Backbone.View.extend({
  initialize: function() {
    return this.render();
  },
  render: function() {
    var _this = this;
    return this.collection.forEach(function(model) {
      return _this.$el.append("<option value=\"" + (model.get(0)) + "\">" + (model.get(0)) + "</option>");
    });
  }
});

$(function() {
  AgLocations.Router = Backbone.Router.extend({
    routes: {
      "": "index",
      "type/:type": "type",
      "unit/:unit": "unit"
    },
    initialize: function() {
      var zoom;
      zoom = this.getZoom();
      console.log(zoom);
      this.map = new AgLocations.Model.Map({
        zoom: zoom
      });
      this.map.initMap({
        coords: {
          latitude: 31.7093197,
          longitude: -99.9911611
        }
      });
      this.mapView = new AgLocations.View.Map({
        model: this.map
      });
      this.mapView.render();
      return this.locations = new AgLocations.View.Layer({
        model: this.map
      });
    },
    index: function() {
      this.locations.options.filter = null;
      return this.locations.render();
    },
    type: function(type) {
      this.locations.options.filter = null;
      this.locations.options.filter = {
        type: 'Type',
        parameter: type
      };
      return this.locations.render();
    },
    unit: function(unit) {
      this.locations.options.filter = null;
      unit = decodeURIComponent(unit);
      this.locations.options.filter = {
        type: 'Unit Name',
        parameter: unit
      };
      return this.locations.render();
    },
    getZoom: function() {
      var height, small, width;
      width = $(window).width();
      console.log(width);
      height = $(window).height();
      small = width <= 300;
      if (width <= 300) {
        return 4;
      } else if ((300 < width && width <= 600)) {
        return 5;
      } else if (width > 600) {
        return 6;
      }
    }
  });
  AgLocations.App = new AgLocations.Router();
  Backbone.history.start({
    pushState: true,
    root: "/locations/"
  });
  $('.legend-inner').hide();
  AgLocations.Part.LocationList = new AgLocations.Collection.Locations;
  AgLocations.Part.OptionsPanel = new AgLocations.View.Options({
    el: ".legend",
    collection: AgLocations.Part.LocationList
  });
  return AgLocations.Part.OptionsPanel.render();
});

/*
//@ sourceMappingURL=location-map.js.map
*/