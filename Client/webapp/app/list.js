'use strict';

angular.module('clientApp.list', ['ngRoute', 'ngCookies', 'ngMaterial', 'clientApp.toast'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/list/:query', {
    templateUrl: 'views/list.html',
    controller: 'listController'
  });
}])




.controller('listController', function($routeParams, $scope, $cookies, $mdToast, $location, toastService) {
  $scope.message="list";
  //var cookie = $cookies.monster_cookie;
  //if (checkAuth(cookie)){
  console.log($routeParams.query);

  if ($routeParams.query == "countries")  {
    toastService.getCountries(function(data)  {
      $scope.output = data.countries;
    })
  } else if ($routeParams.query == "type")  {
    toastService.getCameraTypes(function(data)  {
      $scope.output = data.camera_type;
    })

    $scope.delete = function(id)  {
    toastService.deleteCameraType(id, function () {});
    }

  } else if ($routeParams.query == "storage") {
    toastService.getStorageTypes(function(data)  {
      $scope.output = data.storage_types;
    })
  } else  {
    $scope.listError = "Invalid list query";
  }
  /*} else {
    toastService.displayToast("You must be logged in to access this!");
    $location.path("/");
    $rootScope.errorReply = "Not authorized";

  */
});

//});
