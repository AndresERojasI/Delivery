'use strict';

angular.module('shipper.controllers')

.controller('MenuCtrl', ['$scope', '$ionicPopup', '$ionicPlatform', '$state', '$ionicHistory',
    function($scope, $ionicPopup, $ionicPlatform, $state, $ionicHistory) {
        var intento = 0;
        // Disable BACK button on home
        var deregister = $ionicPlatform.registerBackButtonAction(function(event) {
            console.log(navigator.app);
            if (intento == 1) {
                $ionicPopup.confirm({
                    title: '¿Deseas cerrar la aplicación?',
                    template: '<span style="color:#000;">Si deseas cerrar la aplicación presiona "Ok".</span>'
                }).then(function(res) {
                    if (res) {
                        cordova.plugins.backgroundMode.disable();
                        if (navigator.app) {
                            navigator.app.exitApp();
                        } else if (navigator.device) {
                            navigator.device.exitApp();
                        }
                    }
                });
                intento = 0;
            } else {
                intento++;
            }
        }, 100);

        $scope.currentUrl = "#/app"+$state.current.url;

        document.addEventListener("offline", function() {
            $ionicPopup.alert({
                title: 'No tienes conexión a Internet',
                template: '<span style="color:#000;">En este momento no tienes conexión a internet, la aplicación no funcionará al 100%<span>'
            });
        }, false);
    }
]);