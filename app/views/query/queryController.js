angular.module('app.queryController', [])


.controller('queryController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Query";


  $scope.data = {
      selectedIndex : 0,
      secondLocked : true,
      secondLabel : "Item Two"
    };

    $scope.next = function() {
      $scope.data.selectedIndex = Math.min($scope.data.selectedIndex + 1, 2) ;
    };

    $scope.previous = function() {
      $scope.data.selectedIndex = Math.max($scope.data.selectedIndex - 1, 0);
    };
    $scope.getAll = function(){
      console.log("whoa thats alot");
      listService.getCameras(function(data)  {
        $scope.camera = data.camera_camera;
      })
      listService.getCountries(function(data)  {
        $scope.countries = data.countries;
      })
      listService.getStorages(function(data)  {
        $scope.storage = data.storage_types;
      })
      listService.getTypes(function(data)  {
        $scope.types = data.camera_type;
      })
    }
});
