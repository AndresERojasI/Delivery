'use strict';
angular.module('shipper.services')

.factory('API', function($resource) {
  var apiEndpoint = 'http://api.e-cademy.in/v1.5.0/';
  var token = null;

  return {
  	ClientID: 'XjpyWnxZxD5aYBkcBhlitZPJsp60LSYa1z9b2eEF',
  	ClientSecret: 'NXBJPQKn4fgHppSU8adn6X5QPVNrHzRbtILAHSQg',
  	Autenticar: function(){
  		return $resource(apiEndpoint + 'auth/access_token');
  	},
    Login: function(){
      return $resource(apiEndpoint + 'auth/login');
    },
  	BuscarUsuarioID: $resource(apiEndpoint + 'buscarUsuarioID'),
  	RegistrarUsuario: $resource(apiEndpoint + 'registrarUsuario'),
  	ActualizarUsuario: $resource(apiEndpoint + 'actualizarUsuario')
  };
})
;