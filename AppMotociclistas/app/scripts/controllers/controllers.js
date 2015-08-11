angular.module('starter.controllers', [])

.controller('AppCtrl', ['$scope', '$ionicModal', '$timeout', function($scope, $ionicModal, $timeout){
	
}])

.controller('PlaylistsCtrl', ['$scope', function($scope){
	$scope.map = {
	  center: {
	      lng:  -77.029,
	      lat: -12.018
	  },
	  zoom: 12
	};

	require([
		"esri/map",
		"esri/symbols/PictureMarkerSymbol",
		"esri/layers/graphics",
		"esri/geometry/Point"
	], function (Map, PictureMarkerSymbol,GraphicsLayer, Point) {
		console.log($scope.map);
		var map = new Map("mapDiv", {
		  sliderOrientation : "horizontal",
		  center: [-77.029, -12.018],
		  zoom: 12,
		  basemap: "streets",
		  sliderPosition: "bottom-right"
		});

		var graphicsLayer = new esri.layers.GraphicsLayer(); 
		map.addLayer(graphicsLayer);
		navigator.geolocation.getCurrentPosition(
			function(position){
				map.centerAndZoom([position.coords.longitude, position.coords.latitude], 18);
				var blue = new PictureMarkerSymbol("images/map-pointer.png", 32, 32);
				point = new esri.geometry.Point(position.coords.longitude, position.coords.latitude);  
				graphic = new esri.Graphic(point, blue);  
				graphicsLayer.add(graphic);  
			}, 
			function(error){
				alert('code: '    + error.code    + '\n' +
          		'message: ' + error.message + '\n');
			}, 
			{enableHighAccuracy: true}
		);

	});
	
}])

.controller('PlaylistCtrl', function($scope, $stateParams) {
});
