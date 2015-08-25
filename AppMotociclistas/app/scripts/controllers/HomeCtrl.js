'use strict';

angular.module('shipper.controllers')

.controller('HomeCtrl', ['$scope', '$ionicLoading', 'UsuarioModel', '$ionicPopup', 'Map', function($scope, $ionicLoading, UsuarioModel, $ionicPopup, Map){
	$scope.map = {
	  center: {
	      lng:  6.254186,
	      lat: -75.570054
	  },
	  zoom: 12,
	  elemId: 'mapa'
	};
	$ionicLoading.show({
      template: 'Espera unos segundos, estas siendo agregado al mapa...'
    });
	Map.init($scope.map).then(
		function(respuesta){
			$ionicLoading.hide();
			
		},
		function(error){
			$ionicLoading.hide();
			$ionicPopup.alert({
				title: 'Error al iniciar el mapa.',
				template: '<span style="color:#000;">Ha ocurido un error al intentar iniciar el mapa, reinicia la aplicación e intenta de nuevo.<span>'
			});
		}
	);

	$scope.centrarPosActual = function(){
		$ionicLoading.show({
	      template: 'Localizándote...'
	    });
		Map.centrarPosActual().then(
			function(result){
				$ionicLoading.hide();
			},
			function(error){
				$ionicLoading.hide();
				$ionicPopup.alert({
					title: 'Error al ubicarte en el mapa',
					template: '<span style="color:#000;">Ha ocurido un error al intentar ubicarte en el mapa, verifica que el GPS esté activado.<span>'
				});
			}
		);
	};

	$scope.estoyDisponible = true;
	$scope.msjDisponibilidad = "Estoy Disponible";
	$scope.cambiarEstado = function(){
		$scope.estoyDisponible = !$scope.estoyDisponible;
		if ($scope.estoyDisponible) {
			$scope.msjDisponibilidad = "Estoy Disponible";
		}else{
			$scope.msjDisponibilidad = "No Disponible";
		}
	}

}]);