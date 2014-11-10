
angular.module('clientApp.admin', ['ngRoute', 'ngCookies', 'ngMaterial'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/admin', {
    templateUrl: 'views/admin.html',
    controller: 'adminController'
  });
}])

.controller('adminController', function ($scope, $cookies,$interpolate , $mdToast, $location, $mdDialog, $log){
  $scope.message = "Admin";
  $scope.alert = '';

  if ($cookies.monster_cookie != null) {

    var tabs = [
      { title: 'User', active: true, content: "Add/edit/change user data", style:"tab1"},
      { title: 'Database', active: false, content: "Add/edit/change database data", style:"tab2" },
      { title: 'Account', active: false, content: '/views/home.html', style:"tab3" },
    ];

    $scope.tabs = tabs;
    $scope.predicate = "title";
    $scope.reversed = true;
    $scope.selectedIndex = 1;
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


  $scope.storage = {};
    $scope.submitNewStorage = function()  {
      console.log("entering new storage");
      console.log($scope.storage);
      console.log($scope.storage.type);
      $.ajax({
        type:"POST",
        url: "http://localhost/Backend/storage",
        beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
        //beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
        data: JSON.stringify({name: $scope.storage.type}),
        success: console.log("yay"),//$scope.status = data.status,
        dataType: "JSON"

        }).done(function(data){
             console.log("done");
          //$scope.status=data.status;
          //$scope.message=data.message;

        }).error(function(data){
          //console.log("oh it failed " + data.status);
          $scope.registerStatus = data.status;
            console.log("error");
          }).success(function(data){
          if(data.status == "200"){
            $scope.storageAlert = "Added " + $scope.storage.type + " Successfully";
            $scope.storage = null;
          } else if(data.status == "403") {
            $scope.registerError = data.status;
          }  else if (data.status == "409"){
             $scope.formError = data.status + " - Username already exists.";
          }
          $scope.$apply();
         console.log(data.status);
        });
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
