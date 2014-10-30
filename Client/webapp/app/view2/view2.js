'use strict';

angular.module('myApp.view2', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/view2', {
    templateUrl: 'view2/view2.html',
    controller: 'View2Ctrl'
  });
}])

.controller('View2Ctrl', [function() {

}]);

angular.module('lemon', [])
    .controller('aboutController', function($scope, $http) {
      $http.get('https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/').success(function (data) {
        console.log("Succe<s></s> s\n" + data);
        $scope.modules = data.module;
        $scope.teams = data.team;
        $scope.version = data.version;
        $scope.members = data.members;
        $scope.state = data.status;
      }).error(function(data, status) {
        //Should pick up errors and display, not yet tested.
        console.log("Error, " + data);
        $scope.data = data || "Request failed";
        $scope.status = status;
      });
    });