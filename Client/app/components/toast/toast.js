angular.module('app.toast', ['ngRoute', 'ngCookies', 'ngMaterial'])

.factory('toastService', function($http, $mdToast, $cookies, $location){
  return {


     displayToast: function(message) {
       $mdToast.show({
         template: '<md-toast>' + message + '</md-toast>',
         hideDelay: 3000,
         position: 'top right'
       });
     }
   }
});
