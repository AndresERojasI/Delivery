'use strict';
angular.module('shipper.services')

.provider('AuthService', [

    function() {

        this.$get = ['API',
            function(API) {
                var authObj = {};

                //Login
                authObj.iniciarSesion = function(email, contrasena) {
                    return new Promise(function(fulfill, reject) {
                        //llamado a la API
                        API.Login().save({
                                username: email,
                                password: contrasena
                            },
                            function(resultado) {
                                if (resultado.success === true) {
                                	console.log(resultado.data);
                                    fulfill(resultado.data);
                                } else {
                                    reject('AuthService2');
                                }

                            },
                            function(error) {
                                reject(error);
                            }
                        );
                    });
                }

                return authObj;
            }
        ];
    }
]);