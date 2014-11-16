'use strict';

angular.module('clientApp.query', ['ngRoute', 'ngCookies', 'ngMaterial', 'clientApp.toast'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/query', {
    templateUrl: 'views/query.html',
    controller: 'queryController'
  });
}])




.controller('queryController', function($scope, $cookies, $mdToast, $location, toastService) {
  var cookie = $cookies.monster_cookie;
  if (checkAuth(cookie)){
  console.log("hey query");
    $scope.message="Query";
    toastService.getCountries(function(data)  {
      $scope.countries = data.countries;
    })
  } else {
    toastService.displayToast("You must be logged in to access this!");
    $location.path("/");
    $rootScope.errorReply = "Not authorized";
  };

});
