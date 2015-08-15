'use strict';
angular.module('shipper.services')

.provider('Map', [function () {
	this.$get = [function() {
		var mapa = undefined;
		var objServicio = {};
		var graphicsLayer = undefined;
		var puntoUsuario = undefined;
		var graficoUsuario = undefined;
		objServicio.init = function($dataMap){
			return new Promise(function(fulfill, reject){
				require([
					"esri/map",
					"esri/symbols/PictureMarkerSymbol",
					"esri/layers/graphics",
					"esri/geometry/Point"
				], function (Map, PictureMarkerSymbol,GraphicsLayer, Point) {

					mapa = new Map($dataMap.elemId, {
					  sliderOrientation : "horizontal",
					  center: [$dataMap.lat, $dataMap.lng],
					  zoom: $dataMap.zoom,
					  basemap: "streets",
					  sliderPosition: "bottom-right"
					});

					graphicsLayer = new esri.layers.GraphicsLayer();
					mapa.addLayer(graphicsLayer);
					navigator.geolocation.getCurrentPosition(
						function(position){
							$dataMap.lat = position.coords.latitude;
							$dataMap.lng = position.coords.longitude;
							$dataMap.zoom = 18;
							mapa.centerAndZoom([position.coords.longitude, position.coords.latitude], 18);
							var blue = new PictureMarkerSymbol("images/map-pointer.png", 32, 43);
							puntoUsuario = new esri.geometry.Point(position.coords.longitude, position.coords.latitude);  
							graficoUsuario = new esri.Graphic(puntoUsuario, blue);  
							graphicsLayer.add(graficoUsuario);  
							fulfill(true);
						}, 
						function(error){
							reject(error);
						}, 
						{enableHighAccuracy: true}
					);

				});
			});
		};

		return objServicio;
	}];
}]);