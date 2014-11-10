
angular.module('clientApp.admin', ['ngRoute', 'ngCookies', 'ngMaterial'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/admin', {
    templateUrl: 'views/admin.html',
    controller: 'adminController'
  });
}])

.controller('adminController', function ($scope, $cookies,$interpolate , $mdToast, $location){
  $scope.message = "Admin";

  if ($cookies.monster_cookie != null) {
    var tabs = [
      { title: 'User', active: true, content: "Add/edit/change user data", style:"tab1"},
      { title: 'Database', active: false, content: "Add/edit/change database data", style:"tab2" },
      { title: 'Account', active: false, content: '/views/home.html', style:"tab3" },
    ];

    $scope.tabs = tabs;
    $scope.predicate = "title";
    $scope.reversed = true;
    $scope.selectedIndex = 2;
    $scope.allowDisable = true;

    $scope.onTabSelected = onTabSelected;
    $scope.announceSelected = announceSelected;
    $scope.announceDeselected = announceDeselected;




    // **********************************************************
    // Private Methods
    // **********************************************************

    function onTabSelected(tab) {
      $scope.selectedIndex = this.$index;

      $scope.announceSelected(tab);
    }

    function announceDeselected(tab) {
      $scope.farewell = $interpolate("Goodbye {{title}}!")(tab);
    }

    function announceSelected(tab) {
      $scope.greeting = $interpolate("Hello {{title}}!")(tab);
    }
  } else {
    $mdToast.show({
      template: '<md-toast>You must be logged in to access this</md-toast>',
      hideDelay: 5000,
      position: 'top right'
    });
    $location.path("/login");
    $scope.errorReply = "You must be logged in to access Admin Panel";
  }
});
