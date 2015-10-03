'use strict';
angular.module('shipper.services')

.provider('Map', [

    function() {

        this.$get = ['Sockets', 'API', 'UsuarioModel',
            function(Sockets, API, UsuarioModel) {
                /**
                 * Bloque de variables
                 */
                var objServicio = {};
                var mapa;
                var centro;
                var marcadorDelivery;
                var BASE;
                var bgGeo;
                //inicialización del Mapa
                objServicio.init = function($dataMap) {
                    centro = L.latLng({
                        lon: $dataMap.center.lng,
                        lat: $dataMap.center.lat
                    });
                    return new Promise(function(fulfill, reject) {
                        //verificamos si la geolocalización está activa en el dispositivo
                        objServicio.obtenerPosicionActual().then(
                            function(position) {
                                try {
                                    //inicializamos el Mapa
                                    mapa = L.map($dataMap.elemId, {
                                        zoomControl: false,
                                        tap: false,
                                        closePopupOnClick: true,
                                        attributionControl: false
                                    });


                                    //agregamos el mapa base de Esri
                                    try {
                                        BASE = L.tileLayerCordova('http://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                                            // these options are perfectly ordinary L.TileLayer options
                                            maxZoom: 19,
                                            maxNativeZoom: 19,
                                            attribution: 'Esri &copy;',
                                            // these are specific to L.TileLayer.Cordova and mostly specify where to store the tiles on disk
                                            folder: 'cacheMapShipper',
                                            name: 'shipper',
                                            debug: false
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


                                    centro = L.latLng({
                                        lon: position.coords.longitude,
                                        lat: position.coords.latitude
                                    });
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
                                        icon: detallesIcono
                                    }).addTo(mapa);

                                    fulfill(true);



                                } catch (e) {
                                    reject(e);
                                }
                            },
                            function(error) {
                                reject(false)
                            }
                        );


                    });
                };

                objServicio.obtenerPosicionActual = function() {
                    return new Promise(
                        function(fulfill, reject) {
                            navigator.geolocation.getCurrentPosition(
                                function(position) {
                                    fulfill(position);
                                },
                                function(error) {
                                    reject(error);
                                }, {
                                    enableHighAccuracy: true
                                }
                            );
                        }
                    );
                };

                objServicio.centrarPosActual = function() {
                    return new Promise(function(fulfill, reject) {
                        objServicio.obtenerPosicionActual().then(
                            function(posicion) {
                                centro = L.latLng({
                                    lon: posicion.coords.longitude,
                                    lat: posicion.coords.latitude
                                });
                                marcadorDelivery.setLatLng(centro);
                                mapa.setView(centro, 19);
                                fulfill(true);
                            },
                            function(error) {
                                reject(error);
                            }
                        );
                    });
                };

                objServicio.sinConexion = function() {
                    BASE.goOffline();
                };

                objServicio.conConexion = function() {
                    BASE.goOnline();
                    objServicio.guardarActual();
                };

                objServicio.guardarActual = function() {
                    var listaTiles = BASE.calculateXYZListFromBounds(mapa.getBounds(), 1, 19);
                    BASE.downloadXYZList(
                        // 1st param: a list of XYZ objects indicating tiles to download
                        listaTiles,
                        // 2nd param: overwrite existing tiles on disk? if no then a tile already on disk will be kept, which can be a big time saver
                        false,
                        // 3rd param: progress callback
                        // receives the number of tiles downloaded and the number of tiles total; caller can calculate a percentage, update progress bar, etc.
                        function(done, total) {
                            var percent = Math.round(100 * done / total);

                        },
                        // 4th param: complete callback
                        // no parameters are given, but we know we're done!
                        function() {
                            // for this demo, on success we use another L.TileLayer.Cordova feature and show the disk usage
                            BASE.getDiskUsage(function(filecount, bytes) {
                                var kilobytes = Math.round(bytes / 1024);

                            });
                        },
                        // 5th param: error callback
                        // parameter is the error message string
                        function(error) {
                            alert("Failed\nError code: " + error.code);
                        }
                    );
                };

                objServicio.AgregarPopupUsuario = function(html) {
                    var popup = L.popup({
                            maxWidth: 500,
                            offset: L.point(-4, 60)
                        })
                        .setContent(html);
                    marcadorDelivery.bindPopup(popup);
                };


                objServicio.iniciarTransmicionPosicion = function() {

                    // Get a reference to the plugin.
                    bgGeo = window.plugins.backgroundGeoLocation;;

                    /**
                     * This callback will be executed every time a geolocation is recorded in the background.
                     */
                    var callbackFn = function(location, taskId) {
                        var lat = location.latitude;
                        var lng = location.longitude;


                        centro = L.latLng({
                            lon: lng,
                            lat: lat
                        });
                        marcadorDelivery.setLatLng(centro);
                        mapa.setView(centro, 19);
                        API.Geoposicion(UsuarioModel.data._id).save({
                                latitud: lat,
                                longitud: lng
                            },
                            function(respuesta) {

                            },
                            function(error) {

                            }
                        );

                        bgGeo.finish(taskId);
                    };

                    var failureFn = function(error) {


                    }

                    // BackgroundGeoLocation is highly configurable.
                    bgGeo.configure(callbackFn, failureFn, {
                        desiredAccuracy: 5,
                        stationaryRadius: 3,
                        distanceFilter: 2,
                        notificationTitle: 'GeoShipper', // <-- android only, customize the title of the notification
                        notificationText: 'Se está transmitiendo tu posición', // <-- android only, customize the text of the notification
                        activityType: 'AutomotiveNavigation',
                        debug: false, // <-- enable this hear sounds for background-geolocation life-cycle.
                        stopOnTerminate: false // <-- enable this to clear background location settings when the app terminates
                    });

                    // Turn ON the background-geolocation system.  The user will be tracked whenever they suspend the app.
                    bgGeo.start();
                    window.plugins.insomnia.keepAwake();
                };

                objServicio.detenerTransmicionPosicion = function() {
                    bgGeo.stop();
                    window.plugins.insomnia.allowSleepAgain();
                };

                return objServicio;
            }
        ];
    }
]);