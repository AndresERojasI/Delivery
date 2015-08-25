'use strict';

angular.module('shipper.controllers')

.controller('HistorialPedidosCtrl', ['$scope', function($scope){
	$scope.shouldShowDelete = false;
	$scope.shouldShowReorder = false;
	$scope.listCanSwipe = true
}]);