var sampleApp = angular.module('lemon', []);

sampleApp .config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/login', {
        templateUrl: 'views\login.html',
        controller: 'loginController'
      }).
      when('/about', {
        templateUrl: 'views\about.html',
        controller: 'aboutController'
      }).
      otherwise({
        redirectTo: '/login'
      });
  }]);

sampleApp.controller('loginController', function($scope) {

    $scope.message = 'This is Add new order screen';

});


sampleApp.controller('aboutController', function($scope) {

    $scope.message = 'This is Show orders screen';

});
