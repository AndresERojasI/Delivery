'use strict';
angular.module('shipper.services')

.provider('AuthService', [function () {

	this.$get = [function() {
		var authObj = {};

		//Login
		authObj.iniciarSesion = function(email, contrasena, API){
			return new Promise(function(fulfill, reject){
				//llamado a la API
				API.Login().save(
					{username: email, password: contrasena},
					function(resultado){
						if (resultado.success === true) {
							fulfill(resultado.data);
						}else{
							reject('AuthService2');
						}
						
					},
					function(error){
						reject(error);
					}
				);
			});
		}

		return authObj;
	}];
}]);