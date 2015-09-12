'use strict';

angular.module('shipper.controllers')

.controller('HomeCtrl', 
		['$scope', '$ionicLoading', 'UsuarioModel', '$ionicPopup', 'Map', '$ionicActionSheet', 
function($scope, $ionicLoading, UsuarioModel, $ionicPopup, Map, $ionicActionSheet){
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
			Map.AgregarPopupUsuario('<div class="card" style="width:220px">'+
			  '<div class="item item-text-wrap">'+
			    'This is a basic Card which contains an item that has wrapping text.'+
			  '</div>'+
			'</div>');
			$ionicLoading.hide();
			console.log(respuesta);
		},
		function(error){
			console.log(error);
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
				console.log(result);
				$ionicLoading.hide();
			},
			function(error){
				console.log(error);
				$ionicLoading.hide();
				$ionicPopup.alert({
					title: 'Error al ubicarte en el mapa',
					template: '<span style="color:#000;">Ha ocurido un error al intentar ubicarte en el mapa, verifica que el GPS esté activado.<span>'
				});
			}
		);
	};

	$scope.estoyDisponible = true;
	$scope.msjDisponibilidad = 'Estoy Disponible';
	$scope.cambiarEstado = function(){
		$scope.estoyDisponible = !$scope.estoyDisponible;
		if ($scope.estoyDisponible) {
			$scope.msjDisponibilidad = 'Estoy Disponible';
		}else{
			$scope.msjDisponibilidad = 'No Disponible';
		}
	};

	$scope.abrirOpcionesMapa = function(){
		// Show the action sheet 
		var hideSheet = $ionicActionSheet.show({
			buttons: [
				{ text: '<i class="icon ion-ios-navigate"></i>Navegar a...' },
				{ text: '<i class="icon ion-ios-people"></i>Mostrar mis Amigos' },
				{ text: '<i class="icon ion-ios-pricetags"></i>Mostrar Establecimientos' },
			],
			destructiveText: '<i class="icon ion-loop"></i>Reiniciar Mapa',
			titleText: 'Opciones del Mapa',
			cancelText: 'Cancelar',
			cancelOnStateChange : false,
			cancel: function() {
			  return true;
			},
			buttonClicked: function(index) {
				console.log(index);
				return true;
			},
			destructiveButtonClicked : function(){

			}
		});
	};

}]);