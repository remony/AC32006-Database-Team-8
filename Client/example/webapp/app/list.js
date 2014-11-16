'use strict';

angular.module('clientApp.list', ['ngRoute', 'ngCookies', 'ngMaterial', 'clientApp.toast'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/list/:query', {
    templateUrl: 'views/list.html',
    controller: 'listController'
  });
}])




.controller('listController', function($routeParams, $scope, $cookies, $mdToast, $location, toastService, $mdDialog, $log) {
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
  } else if ($routeParams.query == "storage") {
    toastService.getStorageTypes(function(data)  {
      $scope.output = data.storage_types;
    })
  } else  {
    $scope.listError = "Invalid list query";
  }

$scope.dialogBasic = function(ev, id) {
    $mdDialog.show({
      templateUrl: 'app/partials/deleteNotify.html',
      targetEvent: ev,
      controller: DialogController
    }).then(function() {
      toastService.deleteCameraType(id, function () {});
        if($routeParams.query == "type")  {
          toastService.getCameraTypes(function(data)  {
            $scope.output = data.camera_type;
          })
        }

    }, function() {
      $scope.alert = 'You cancelled the dialog.';
    });
  };

  $scope.dialogAdd = function(ev) {
    $mdDialog.show({
      templateUrl: 'app/partials/addNewObject.html',
      targetEvent: ev,
      controller: DialogController
    }).then(function()  {
      if($routeParams.query == "type")  {
        toastService.getCameraTypes(function(data)  {
          $scope.output = data.camera_type;
        })
      }
    });
  };

function DialogController($scope, $mdDialog) {
  $scope.hide = function() {
    $mdDialog.hide();
  };

  $scope.cancel = function() {
    $mdDialog.cancel();
  };

  $scope.answer = function(answer) {
    $mdDialog.hide(answer);
  };
}
  /*} else {
    toastService.displayToast("You must be logged in to access this!");
    $location.path("/");
    $rootScope.errorReply = "Not authorized";

  */
});





//});
