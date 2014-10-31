//Create the module
var client = angular.module('clientApp', ['ngRoute', 'ngCookies']);

//Configure routes
client.config(function($routeProvider){
  $routeProvider
    .when('/', {
      templateUrl: 'views/home.html',
      controller: 'appController'
    })
    .when('/about', {
      templateUrl: 'views/about.html',
      controller: 'aboutController'
    })
    .when('/contact', {
      templateUrl: 'views/contact.html',
      controller: 'contactController'
    })
    .when('/login', {
      templateUrl: 'views/login.html',
      controller: 'loginController'
    })
    .when('/profile', {
      templateUrl: 'views/profile.html',
      controller: 'profileController'
    })
})

//Controllers
client.controller('appController', function($scope){

});

client.controller('aboutController', function($scope){
  $scope.message = 'About';
  $.ajax({
    type: "get",
    url: "https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/",
    //header: {monster_cookie: $cookies.monster_cookie},
    //beforeSend: function(xhr){xhr.setRequestHeader('monster_token',myCookie );},
    //5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8
    success: console.log("yay"),//$scope.status = data.status,
    }).done(function(data){
      console.log(data);
    console.log("done");
    }).fail(function(data){
    //delete $window.sessionStorage.token;
    }).success(function(data){
      $scope.profile = data.message;
      $scope.module = data.module;
      $scope.team = data.team;
      $scope.version = data.version;
      $scope.members = data.members;
      console.log(JSON.stringify(data, null, 5));
    console.log("yay success " + data.status);
    $scope.$apply();
    });
});

client.controller('contactController', function($scope){
  $scope.message = 'Contact';
});

client.config(['$httpProvider', function($httpProvider) {

        $httpProvider.defaults.headers.common["FROM-ANGULAR"] = "true";
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';

    }]);


client.controller('loginController', function($scope, $cookies){
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
      url: "https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/?__route__=/login",
      data: JSON.stringify({username: $scope.login.username, password: hash}),
      //5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8
      success: console.log(JSON.stringify({username: $scope.login.username, password: hash})),//$scope.status = data.status,
      dataType: "JSON"
      }).done(function(data){

      $scope.status=data.status;
      $scope.message=data.message;
      $scope.access_token = data.access_token;
      //console.log(JSON.stringify(data, null, 5));
      //alert(JSON.stringify(data, null, 4));
    }).error(function(data){
      console.log("oh it failed " + data.status);
      $scope.loginStatus = data.status;
        //should delete cookie
      }).success(function(data){
      if(data.status == "200"){
      $cookies.monster_cookie = data.user[0].access_token;
        $scope.loginSuccess = data.status;
      } else if(data.status == "403") {
        $scope.loginError = data.status;
      }
      $scope.$apply();
    });

      }

});

client.controller('profileController', function($scope, $cookies) {
  $scope.message = 'Profile';
var myCookie = document.cookie;
  $.ajax({
    type: "get",
    url: "https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/?__route__=/profile/johndoe",
    beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
    //header: {monster_cookie: $cookies.monster_cookie},
    //beforeSend: function(xhr){xhr.setRequestHeader('monster_token',myCookie );},
    //5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8
    success: console.log("yay "),//$scope.status = data.status,
    }).done(function(data){
      console.log(data);
    console.log("done");
    }).fail(function(data){
    //delete $window.sessionStorage.token;
    }).success(function(data){
      $scope.profile = data.message;
      console.log(JSON.stringify(data, null, 5));
    console.log("yay success " + data.status);
    $scope.$apply();
    //$window.location.href = 'http://www.google.com';
    });
});
