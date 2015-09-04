'use strict';
angular.module('shipper.services')

//Servicio de Database
.provider('Database', [function () {

  this.$get = [function() {
    var baseDatos = window.openDatabase("DBShipper", "1.0", "RPM Club", 400000000);

    return {
      exitoConsulta: function(tx, resultado){
        return resultado;
      },
      errorConsulta: function(error, SQL){
        return error;
      },
      ejecutarSQL: function(SQL, ArregloReplace){
        var me = this;

        return new Promise(
          function(fulfill, reject){
            baseDatos.transaction(
              function(tx){
                tx.executeSql(
                  SQL,
                  ArregloReplace,
                  function(tx, resultado){
                    fulfill(me.exitoConsulta(tx, resultado));
                  },
                  function(error){
                    reject(me.errorConsulta(error, SQL));
                  }
                );
              },
              function(error){
                reject(me.errorConsulta(error));
              },
              function(tx, resultado){
                fulfill(me.exitoConsulta(tx, resultado));
              }
                            
            );
          }
        );
        
      },
    };
  }];
}]);