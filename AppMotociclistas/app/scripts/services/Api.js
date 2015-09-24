'use strict';
angular.module('shipper.services')

.factory('API', function($resource) {
    var apiEndpoint = 'http://api.e-cademy.in/v1.5.0/';
    var token = null;

    return {
        ClientID: 'XjpyWnxZxD5aYBkcBhlitZPJsp60LSYa1z9b2eEF',
        ClientSecret: 'NXBJPQKn4fgHppSU8adn6X5QPVNrHzRbtILAHSQg',
        SetToken: function(newToken) {
            token = newToken;
        },
        Autenticar: function() {
            return $resource(apiEndpoint + 'auth/access_token');
        },
        Login: function() {
            return $resource(apiEndpoint + 'auth/login', {
                access_token: token,
                state_param: 'yn1aetye1wre3w58ern7ywr7y8'
            });
        },
        Logout: function() {
            return $resource(apiEndpoint + 'auth/logout', {
                access_token: token,
                state_param: 'yn1aetye1wre3w58ern7ywr7y8'
            });
        },
        BuscarUsuario: function(campo, valor) {
            return $resource(apiEndpoint + 'usuarios/' + campo + "/" + valor, {
                access_token: token,
                state_param: 'yn1aetye1wre3w58ern7ywr7y8'
            });
        },
        BuscarUsuario: function(campo, valor) {
            return $resource(apiEndpoint + 'usuarios/' + campo + "/" + valor, {
                access_token: token,
                state_param: 'yn1aetye1wre3w58ern7ywr7y8'
            });
        },
        Disponibilidad: function(id) {
            return $resource(apiEndpoint + 'usuarios/motociclistas/'+id+'/disponibilidad', {
                access_token: token,
                state_param: 'yn1aetye1wre3w58ern7ywr7y8'
            });
        },
        Geoposicion: function(id) {
            return $resource(apiEndpoint + 'usuarios/motociclistas/'+id+'/geoposicion', {
                access_token: token,
                state_param: 'yn1aetye1wre3w58ern7ywr7y8'
            });
        },
        RegistrarUsuario: $resource(apiEndpoint + 'registrarUsuario'),
        ActualizarUsuario: $resource(apiEndpoint + 'actualizarUsuario')
    };
});