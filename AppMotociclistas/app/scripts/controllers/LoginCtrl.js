'use strict';

angular.module('shipper.controllers')

.controller('LoginCtrl', ['$scope', '$ionicLoading', 'UsuarioModel', '$ionicPopup', '$location', function($scope, $ionicLoading, UsuarioModel, $ionicPopup, $location){
	//Model de usuario para las validaciones
	$scope.userMod = {};

	//Función de validación del Formulario
	$scope.iniciarSesion = function(modelo, formulario){
		$ionicLoading.show({
	      template: 'Iniciando Sesión.'
	    });

		if (formulario.$valid === true) {
            UsuarioModel.iniciarSesion(modelo).then(
				function(respuesta){
					$ionicLoading.hide();
					$location.path( "/app/home" );
					if (!$scope.$$phase) {
                        $scope.$apply();
                    }
				},
				function(error){
					console.log(error);
					$ionicLoading.hide();
					$ionicPopup.alert({
						title: 'Error en inicio de Sesión',
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