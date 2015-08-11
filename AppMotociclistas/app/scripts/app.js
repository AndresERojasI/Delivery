// Ionic Shipper App
'use strict';
angular.module('shipper', ['ionic', 'shipper.controllers', 'shipper.services', 'shipper.models', 'shipper.directives'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      cordova.plugins.Keyboard.disableScroll(true);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider
    .state('inicio', {
      url: '/inicio',
      templateUrl: 'templates/inicio.html',
      controller: 'InicioCtrl'
    })
      .state('registrar', {
        url: '/registrar',
        templateUrl: 'templates/registrar.html',
        controller: 'RegistrarCtrl'
      })
      .state('login', {
        url: '/login',
        templateUrl: 'templates/login.html',
        controller: 'RegistrarCtrl'
      })
        .state('olvidoContrasena', {
          url: '/olvidoContrasena',
          templateUrl: 'templates/olvidoContrasena.html',
          controller: 'OlvidoContrasenaCtrl'
        })

    .state('home', {
      url: '/home',
      templateUrl: 'templates/home.html',
      controller: 'HomeCtrl'
    })
    ;
  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/inicio');
});

//Inicializamos el módulo de servicios
angular.module('shipper.services', ['ngResource', 'ionic']);
//Inicializamos el módulo de Controladores
angular.module('shipper.controllers', ['ionic', 'angular-flexslider']);
//Inicializamos el módulo de modelos
angular.module('shipper.models', ['ionic']);
//Inicializamos el módulo de Directivas
angular.module('shipper.directives', []);