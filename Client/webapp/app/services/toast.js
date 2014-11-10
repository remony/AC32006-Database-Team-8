angular.module('clientApp.toast', ['ngRoute', 'ngCookies', 'ngMaterial'])

.factory('toastService', function($http, $mdToast, $cookies){
  return {
    getCountries: function(callback){
      return $http.get('http://localhost/Backend/countries').success(callback);
    },
    getCameraTypes: function(callback){
      return $http({url:'http://localhost/Backend/type', method:'GET',dataType:'json', headers: {
                'Content-Type': 'application/json; charset=utf-8',
                'Authorization': $cookies.monster_cookie
            }}).success(callback);
    },
    getStorageTypes: function(callback){
      return $http({url:'http://localhost/Backend/storage', method:'GET',dataType:'json', headers: {
                'Content-Type': 'application/json; charset=utf-8',
                'Authorization': $cookies.monster_cookie
            }}).success(callback);
    },

     displayToast: function(message) {
       $mdToast.show({
         template: '<md-toast>' + message + '</md-toast>',
         hideDelay: 5000,
         position: 'top right'
       });
     }
   }
});
