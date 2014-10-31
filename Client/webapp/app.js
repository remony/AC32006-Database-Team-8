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
  $scope.message = 'Everyone look its home';
});

client.controller('aboutController', function($scope){
  $scope.message = 'Everyone look its about';
});

client.controller('contactController', function($scope){
  $scope.message = 'Everyone look its contact';
});

client.config(['$httpProvider', function($httpProvider) {

        $httpProvider.defaults.headers.common["FROM-ANGULAR"] = "true";
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';

    }]);


client.controller('loginController', function($scope, $cookies){
  $scope.login={};
  var hash = CryptoJS.SHA1($scope.login.password);
  $scope.submit = function()  {
    $.ajax({
      type: "POST",
      url: "https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/?__route__=/login",
      data: JSON.stringify({username: $scope.login.username, password: hash.toString()}),
      //5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8
      success: console.log("yay "),//$scope.status = data.status,
      dataType: "JSON"
      }).done(function(data){

      $scope.status=data.status;
      $scope.message=data.message;
      $scope.access_token = data.access_token;
      console.log(JSON.stringify(data, null, 5));
      //alert(JSON.stringify(data, null, 4));
      }).fail(function(data){
      console.log("oh it failed " + data.status);
      //$.cookie('token', null);
      //delete $window.sessionStorage.token;
      }).success(function(data){
      //$window.sessionStorage.token = data.access_token;
      //document.cookie="monster_cookie = data.access_token";
      //var json = jQuery.parseJSON(data);
      //console.out(data.user);
      $cookies.monster_cookie = data.user[0].access_token;
      console.log(data.user[0].access_token);
      console.log("yay success " + data.status);
      });

      }

});

client.controller('profileController', function($scope, $cookies) {
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
    });
});
