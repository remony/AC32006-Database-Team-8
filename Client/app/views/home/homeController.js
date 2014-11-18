angular.module('app.homeController', [])


.controller('homeController', function($scope, $http) {
  $scope.title = "Home";
  $http({url: backend + '/', method:'GET',dataType:'json', headers: {
  }}).success($scope.online=true);

});
