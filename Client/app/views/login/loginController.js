angular.module('app.loginController', [])

.controller('loginController', function($scope, $cookies, $location, toastService, authService, $rootScope){
    $scope.message = 'Login';
    $scope.login={};
    //$scope.login.password = CryptoJS.SHA512($scope.login.password);
    $scope.submit = function()  {

      var pass = $scope.login.password;
      console.log(pass);
      var hash = CryptoJS.SHA512(pass).toString();
      console.log(hash);
      $.ajax({
        type: "POST",
        url: "http://localhost/Backend/login",
        data: JSON.stringify({username: $scope.login.username, password: hash}),
        dataType: "JSON"
        }).done(function(data){
          authService.checkLoggedIn();
        $scope.status=data.status;
        $scope.access_token = data.access_token;
        console.log(JSON.stringify(data, null, 5));
        //alert(JSON.stringify(data, null, 4));
      }).error(function(data){
        $scope.toast = "Something went wrong";
        $scope.loginStatus = data.status;
          //should delete cookie
        }).success(function(data){
        if(data.status == "200"){
         cookie = data.user.access_token;
          $cookies.monster_cookie = cookie;
          $rootScope.isLoggedIn = true;
          $location.path("/");
          if(!$rootScope.$$phase) {
            $rootScope.$apply();
          }
        } else if(data.status == "403") {
          console.log("incorrect login");
        }
          toastService.displayToast(data.message);
        $scope.$apply();
      });
    }

});
