angular.module('app.indexController', [])
.controller('appController', function($scope, $cookies, $location, $timeout, $mdSidenav, $mdDialog, authService){

      var isLoggedIn;
      if ($cookies.monster_cookie != null)  {
        console.log("yay");
        $.ajax({
          type: "get",
          url: "http:/Backend/profile/userid",
          beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
          }).done(function(data){
            //something
          }).fail(function(data){
            console.log("service says boo");
            false;
          }).success(function(data){
              if ($cookies.monster_cookie == data.access_token)  {
                console.log("valid user");
                $scope.isLoggedIn = true;
                isLoggedIn = true;

                $scope.$apply();
              } else {
                console.log("Invalid user");
                isLoggedIn = false;
              }
          });
    } else  {
      console.log("boo");
    }


  $scope.toggleRight = function() {
    $mdSidenav('right').toggle();
  };

      $scope.toggleLeft = function() {
        $mdSidenav('left').toggle();
      };
      console.log(isLoggedIn);
  if ( isLoggedIn == true){
    var tabs = [
        { title: 'One', content: "Tabs will become paginated if there isn't enough room for them."},
        { title: 'Two', content: "You can swipe left and right on a mobile device to change tabs."},
        { title: 'Three', content: "You can bind the selected tab via the selected attribute on the md-tabs element."},
      ];

      $scope.tabs = tabs;
      $scope.selectedIndex = 2;
  } else {
    var tabs = [
        { title: 'One', content: "Tabs will become paginated if there isn't enough room for them."},
        { title: 'Two', content: "You can swipe left and right on a mobile device to change tabs."},
        { title: 'Three', content: "You can bind the selected tab via the selected attribute on the md-tabs element."},
        { title: 'Four', content: "If you set the selected tab binding to -1, it will leave no tab selected."},
        { title: 'Five', content: "If you remove a tab, it will try to select a new one."},
        { title: 'Six', content: "There's an ink bar that follows the selected tab, you can turn it off if you want."},
        { title: 'Seven', content: "If you set ng-disabled on a tab, it becomes unselectable. If the currently selected tab becomes disabled, it will try to select the next tab."},
        { title: 'Eight', content: "If you look at the source, you're using tabs to look at a demo for tabs. Recursion!"},
        { title: 'Nine', content: "If you set md-theme=\"green\" on the md-tabs element, you'll get green tabs."},
        { title: 'Ten', content: "If you're still reading this, you should just go check out the API docs for tabs!"}
      ];

      $scope.tabs = tabs;
      $scope.selectedIndex = 2;
  }
  if(!$scope.$$phase) {
    $scope.$apply();
  }


})

.controller('LeftCtrl', function($scope, $timeout, $mdSidenav, $location) {
  $scope.close = function() {
    $mdSidenav('left').close();
  };

})


.controller('RightCtrl', function($scope, $timeout, $mdSidenav) {
  $scope.close = function() {
    $mdSidenav('right').close();
  };
});

var cookie = null;
//Handles the user auth
function checkAuth(cookie)  {
  if (cookie != null){
    //$scope.isLoggedIn = true;
    return true;
  }
  return null;
}
