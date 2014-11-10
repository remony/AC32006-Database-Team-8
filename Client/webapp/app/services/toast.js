angular.module('clientApp.toast', ['ngRoute', 'ngCookies', 'ngMaterial'])

.factory('toastService', function($http, $mdToast){
  return {
    getCountries: function(callback){
      return $http.get('http://localhost/Backend/countries').success(callback);
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
