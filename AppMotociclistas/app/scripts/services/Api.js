'use strict';
angular.module('shipper.services')

.factory('API', function($resource) {
  return {
  	LoginCorreo: $resource('http://46.101.250.129/loginCorreo'),
  	BuscarUsuarioID: $resource('http://46.101.250.129/buscarUsuarioID'),
  	BuscarUsuarioTel: $resource('http://46.101.250.129/buscarUsuarioTel'),
  	BuscarUsuarioRS: $resource('http://46.101.250.129/buscarUsuarioRS'),
  	SolicitarSMS: $resource('http://46.101.250.129/solicitarSMS'),
  	ValidarTokenInsatalacion: $resource('http://46.101.250.129/validarTokenInsatalacion'),
  	RegistrarUsuario: $resource('http://46.101.250.129/registrarUsuario'),
  	ActualizarUsuario: $resource('http://46.101.250.129/actualizarUsuario'),
  	AgregarContacto: $resource('http://46.101.250.129/agregarContacto'),
  };
})
;