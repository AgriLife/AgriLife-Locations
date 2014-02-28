$ = jQuery
apikey = "AIzaSyAwvTAlWZ9tj8b4-1QWHwFl3ILodM7u0jA";
queryUrlHead = "https://www.googleapis.com/fusiontables/v1/query?sql=";
queryUrlTail = "&callback=?";
encryptedid = "19aSULi0NxobDXvjbc6ygoNoYhYLrFLhACu7Dyuw";
query = "SELECT 'Unit Name', 'Type' FROM " + encryptedid + " ORDER BY 'Unit Name'";
encodedQuery = encodeURIComponent(query);
keystring = "&key=" + apikey;
queryurl = encodeURI(queryUrlHead + query + queryUrlTail);

AgLocations = {}
AgLocations.Model = {}
AgLocations.View = {}
AgLocations.Part = {}
AgLocations.Router = {}
AgLocations.Collection = {}
AgLocations.Layer = {}
AgLocations.url = [queryUrlHead];
AgLocations.url.push(encodedQuery);
AgLocations.url.push(keystring);
AgLocations.url.push(queryUrlTail);
AgLocations.tableid = 2891754;

AgLocations.Model.Map = Backbone.Model.extend
	defaults:
		id: ''
		currentLatLng: {}
		mapOptions: {}
		map: {}
		position: {}
		zoom: 1
		maxZoom: 18
		minZoom: 3

	initMap: (position) ->
		@set 'position', position
		currentLatLng = new google.maps.LatLng position.coords.latitude, position.coords.longitude
		@set 'currentLatLng', currentLatLng

		mapOptions =
			zoom: @get 'zoom'
			minZoom: @get 'minZoom'
			maxZoom: @get 'maxZoom'
			center: currentLatLng
			mapTypeId: google.maps.MapTypeId.ROADMAP
			mapTypeControl: false

		@set 'mapOptions', mapOptions

# The map view. This is what's called to render the map.
AgLocations.View.Map = Backbone.View.extend
	defaults:
		region: 'us'
		language: 'en'

	id: 'locations-map'

	initialize: ->
		@model.set 'map', new google.maps.Map @el, @model.get 'mapOptions'

		aghq = new google.maps.LatLng( 30.5997762, -96.3522229 )
		marker = new google.maps.Marker
			map: @model.get 'map'
			position: aghq
			icon: new google.maps.MarkerImage "http://agrilife.org/template-agriflex/wp-content/themes/AgriLife-Locations/images/agrilife-marker.png"

	render: ->
		$("#" + @id).replaceWith @el
		return this

AgLocations.Model.Location = Backbone.Model.extend {}

AgLocations.Collection.Locations = Backbone.Collection.extend
	model: AgLocations.Model.Location
	url: AgLocations.url.join('')
	initialize: ->
		@deferred = @fetch()
	parse: (response) ->
		return response.rows

AgLocations.View.Layer = Backbone.View.extend
	initialize: (options) ->
		@options = options || {}
		@layer = new google.maps.FusionTablesLayer
			templateId: 2
		@layer.setMap @model.get 'map'

	render: ->
		query =
			select: 'Location'
			from: AgLocations.tableid
		if _.isObject @options.filter
			query.where = "'#{@options.filter.type}' = '#{@options.filter.parameter}'"
		@layer.setQuery query

AgLocations.View.Options = Backbone.View.extend
	events:
		"click .legend-button": "togglePanel"
		"click .office": "selectAgency"
		"change select": "selectUnit"
		"click #reset": "showAll"

	selectAgency: (event) ->
		event.preventDefault()
		type = $(event.currentTarget).attr "value"
		AgLocations.App.navigate "type/#{type}", {trigger: true}

	selectUnit: (event) ->
		event.preventDefault()
		unit = encodeURIComponent( $(event.currentTarget).attr "value" )
		AgLocations.App.navigate "unit/#{unit}", {trigger: true}

	showAll: (event) ->
		event.preventDefault()
		AgLocations.App.navigate "", {trigger: true}

	render: ->
		@collection.deferred.then (response, error, xhr ) =>
			@extension = @collection.where
				1: "1"
			@research = @collection.where
				1: "2"
			@tvmdl = @collection.where
				1: "3"
			@tfs = @collection.where
				1: "4"

			new AgLocations.View.Select
				collection: @extension
				el: "#ext-locations"

			new AgLocations.View.Select
				collection: @research
				el: "#res-locations"

	togglePanel: (event) ->
		@$(".legend-inner").slideToggle 'medium'

AgLocations.View.Select = Backbone.View.extend
	initialize: () ->
		@render()

	render: () ->
		@collection.forEach (model) =>
			@$el.append "<option value=\"#{model.get 0}\">#{model.get 0}</option>"

$ ->
	AgLocations.Router = Backbone.Router.extend
		routes:
			"": "index"
			"type/:type": "type"
			"unit/:unit": "unit"

		initialize: ->
			zoom = @getZoom()
			console.log zoom
			@map = new AgLocations.Model.Map
				zoom: zoom
			@map.initMap
				coords:
					latitude: 31.7093197
					longitude: -99.9911611
			@mapView = new AgLocations.View.Map
				model: @map
			@mapView.render()
			@locations = new AgLocations.View.Layer
				model: @map
			google.maps.event.addListener @map, 'click', (e) =>
				console.log e
				newContent = e.infoWindowHtml.replace("/<a /<a target='_blank' /g");
				infowindow.setOptions
					content: newContent

		index: ->
			@locations.options.filter = null
			@locations.render()

		type: (type) ->
			@locations.options.filter = null
			@locations.options.filter =
				type: 'Type'
				parameter: type
			@locations.render()

		unit: (unit) ->
			@locations.options.filter = null
			unit = decodeURIComponent(unit)
			@locations.options.filter =
				type: 'Unit Name'
				parameter: unit
			@locations.render()

		getZoom: ->
			width = $(window).width()
			console.log width
			height = $(window).height()
			small = width <= 300
			if width <= 300
				return 4
			else if 300 < width <= 600
				return 5
			else if width > 600
				return 6


	AgLocations.App = new AgLocations.Router()
	Backbone.history.start
		pushState: true
		root: "/locations/"

	$('.legend-inner').hide();

	AgLocations.Part.LocationList = new AgLocations.Collection.Locations

	AgLocations.Part.OptionsPanel = new AgLocations.View.Options
		el: ".legend"
		collection: AgLocations.Part.LocationList

	AgLocations.Part.OptionsPanel.render()