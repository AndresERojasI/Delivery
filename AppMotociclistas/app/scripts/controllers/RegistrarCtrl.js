'use strict';

angular.module('shipper.controllers')

.controller('RegistrarCtrl', ['$scope', '$ionicLoading', 'UsuarioModel', '$ionicPopup', function($scope, $ionicLoading, UsuarioModel, $ionicPopup){
	//Model de usuario para las validaciones
	$scope.userMod = {};

	//Función de validación del Formulario
	$scope.registrar = function(modelo, formulario){
		$ionicLoading.show({
	      template: 'Enviando la solicitud...'
	    });

		if (formulario.$valid === true) {
			UsuarioModel.registrar(modelo).then(
				function(respuesta){
					$ionicLoading.hide();
					$ionicPopup.alert({
						title: 'Registro Completado',
						template: '<span style="color:#000;">Se ha realizado la petición de Registro, revisa tu correo.<span>'
					});
				},
				function(error){
					$ionicLoading.hide();
					$ionicPopup.alert({
						title: 'Error en la solicitud',
						template: '<span style="color:#000;">Ha ocurrido un error, intentalo de nuevo en un momento.<span>'
					});
				}
				);
		}else{
			$ionicLoading.hide();
			$ionicPopup.alert({
				title: 'Error en el formulario',
				template: '<span style="color:#000;">Revisa los datos ingresados, al parecer hay un error.<span>'
			});
		}
	    
	}
}]);