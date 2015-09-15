'use strict';
angular.module('shipper.services')

.provider('Map', [function () {

	this.$get = [function() {
		/**
		 * Bloque de variables
		 */
		var objServicio = {};
		var mapa;
		var centro;
		var marcadorDelivery;
		var BASE;
		//inicialización del Mapa
		objServicio.init = function($dataMap){
			centro = L.latLng({lon: $dataMap.center.lng, lat: $dataMap.center.lat});
			return new Promise(function(fulfill, reject){
				try{
					//inicializamos el Mapa
					mapa = L.map($dataMap.elemId, {
						zoomControl: false,
						tap: true,
						closePopupOnClick: true,
						attributionControl: false
					});

					//agregamos el mapa base de Esri
					try {
				        BASE = L.tileLayerCordova('http://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
				            // these options are perfectly ordinary L.TileLayer options
				            maxZoom: 19,
				            attribution: 'Esri &copy;',
				            // these are specific to L.TileLayer.Cordova and mostly specify where to store the tiles on disk
				            folder: 'cacheMapShipper',
				            name:   'shipper',
				            debug:   true
				        }, function() {
							//Evento online
							document.addEventListener("online", objServicio.conConexion, false);
							//Evento Offline
							document.addEventListener("offline", objServicio.sinConexion, false);
						}).addTo(mapa);
				    } catch (e) {
				        alert(e);
				    }
					//L.tileLayer.provider('Esri.WorldStreetMap').addTo(mapa);

					//Obtenemos la posición actual
					objServicio.obtenerPosicionActual().then(function(response){
						centro = L.latLng({lon: response.coords.longitude, lat: response.coords.latitude});
						//Centramos el mapa en la posición actual
						mapa.setView(centro, 19);
						//Creamos el icono marcador de la posición actual
						var detallesIcono = L.icon({
						    iconUrl: 'images/map-pointer.png',
						    iconSize: [30, 40],
						    iconAnchor: [22, 30],
						    popupAnchor: [-3, -76],
						    shadowUrl: 'images/marker-shadow.png',
						    shadowSize: [43, 40],
						    shadowAnchor: [21, 28]
						});
						marcadorDelivery = L.marker(centro, {
							icon: detallesIcono,
							clickable: true,
							riseOnHover: true
						}).addTo(mapa);

						if (BASE.isOnline()) {
							objServicio.guardarActual();
						};

						fulfill(true);
					},
					function(err){
						reject(err);
					});


				}catch(e){
					console.log('here2');
					reject(e);
				}
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
						centro = L.latLng({lon: posicion.coords.longitude, lat: posicion.coords.latitude});
						marcadorDelivery.setLatLng(centro);
						mapa.setView(centro, 19);
						fulfill(true);
					},
					function(error){
						reject(error);
					}
				);
			});
		};

		objServicio.sinConexion = function(){
			BASE.goOffline();
		};

		objServicio.conConexion = function(){
			BASE.goOnline();
			objServicio.guardarActual();
		};

		objServicio.guardarActual = function(){
			var listaTiles = BASE.calculateXYZListFromBounds(mapa.getBounds(), 1, 19);
			BASE.downloadXYZList(
		        // 1st param: a list of XYZ objects indicating tiles to download
		        listaTiles,
		        // 2nd param: overwrite existing tiles on disk? if no then a tile already on disk will be kept, which can be a big time saver
		        false,
		        // 3rd param: progress callback
		        // receives the number of tiles downloaded and the number of tiles total; caller can calculate a percentage, update progress bar, etc.
		        function (done,total) {
		            var percent = Math.round(100 * done / total);
		            console.log('Se ha descargado: ' + done  + " / " + total + " = " + percent + "%");
		        },
		        // 4th param: complete callback
		        // no parameters are given, but we know we're done!
		        function () {
		            // for this demo, on success we use another L.TileLayer.Cordova feature and show the disk usage
		            BASE.getDiskUsage(function (filecount,bytes) {
				        var kilobytes = Math.round( bytes / 1024 );
				        console.log("Cache status" + "<br/>" + filecount + " files" + "<br/>" + kilobytes + " kB");
				    });
		        },
		        // 5th param: error callback
		        // parameter is the error message string
		        function (error) {
		            alert("Failed\nError code: " + error.code);
		        }
		    );
		};

		objServicio.AgregarPopupUsuario = function(html){
			var popup = L.popup({
				maxWidth: 500,
				offset: L.point(-4, 60)
			})
		    .setContent(html);
			marcadorDelivery.bindPopup(popup);
		};

		return objServicio;
	}];
}]);