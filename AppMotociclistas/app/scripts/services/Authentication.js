'use strict';
angular.module('shipper.services')

.provider('AuthService', [function () {

	this.$get = [function() {
		var authObj = {};

		//Login
		authObj.iniciarSesion = function(email, contrasena, API){
			return new Promise(function(fulfill, reject){
				//llamado a la API
				API.LoginCorreo.save(
					{correo: email, contrasena: contrasena, return: true},
					function(resultado){
						if (resultado.success === true) {
							fulfill(resultado.user);
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