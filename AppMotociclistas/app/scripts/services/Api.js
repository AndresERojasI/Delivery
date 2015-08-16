'use strict';
angular.module('shipper.services')

.factory('API', function($resource) {
  var apiEndpoint = 'http://apimoto.e-cademy.in/';
  return {
  	LoginCorreo: $resource(apiEndpoint + 'loginCorreo'),
  	BuscarUsuarioID: $resource(apiEndpoint + 'buscarUsuarioID'),
  	RegistrarUsuario: $resource(apiEndpoint + 'registrarUsuario'),
  	ActualizarUsuario: $resource(apiEndpoint + 'actualizarUsuario')
  };
})
;