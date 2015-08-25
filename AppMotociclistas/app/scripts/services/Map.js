'use strict';
angular.module('shipper.services')

.provider('Map', [function () {
	this.$get = [function() {
		/**
		 * Bloque de variables
		 */
		var mapa = undefined;
		var objServicio = {};
		var graphicsLayer = undefined;
		var puntoUsuario = undefined;
		var graficoUsuario = undefined;
		var imagenUsuario = undefined;

		//inicialización del Mapa
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
					  sliderPosition: "bottom-left"
					});

					graphicsLayer = new esri.layers.GraphicsLayer();
					mapa.addLayer(graphicsLayer);
					objServicio.obtenerPosicionActual().then(
						function(posicion){
							$dataMap.lat = posicion.coords.latitude;
							$dataMap.lng = posicion.coords.longitude;
							$dataMap.zoom = 18;
							mapa.centerAndZoom([posicion.coords.longitude, posicion.coords.latitude], 18);
							imagenUsuario = new PictureMarkerSymbol("images/map-pointer.png", 32, 43);
							puntoUsuario = new esri.geometry.Point(posicion.coords.longitude, posicion.coords.latitude);  
							graficoUsuario = new esri.Graphic(puntoUsuario, imagenUsuario);  
							graficoUsuario = graphicsLayer.add(graficoUsuario);  
							fulfill(true);
						},
						function(error){
							reject(error);
						}
					);
				});
			});
		};

		objServicio.obtenerPosicionActual = function(){
			return new Promise(
				function(fulfill, reject){
					navigator.geolocation.getCurrentPosition(
						function(position){
							fulfill(position);
						}, 
						function(error){
							reject(error);
						}, 
						{enableHighAccuracy: true}
					);
				}
			);
		};

		objServicio.centrarPosActual = function(){
			return new Promise(function(fulfill, reject){
				objServicio.obtenerPosicionActual().then(
					function(posicion){
						//movemos el punto a la posición obtenida
						puntoUsuario.setLatitude(posicion.coords.latitude);
						puntoUsuario.setLongitude(posicion.coords.longitude);
						graficoUsuario.setAttributes(puntoUsuario, imagenUsuario); 
						//centramos el mapa en la posición
						mapa.centerAndZoom([posicion.coords.longitude, posicion.coords.latitude], 18);
						fulfill(true);
					},
					function(error){
						reject(error);
					}
				);
			});
		};

		return objServicio;
	}];
}]);