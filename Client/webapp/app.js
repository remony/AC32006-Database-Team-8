//Create the module
var client = angular.module('clientApp', ['ngRoute', 'ngCookies', 'ui.bootstrap']);

//Configure routes
client.config(function($routeProvider, $httpProvider){

 $httpProvider.defaults.useXDomain = true;
 $httpProvider.defaults.withCredentials = true;

  $httpProvider.interceptors.push('authInterceptor');
  $routeProvider
    .when('/', {
      templateUrl: 'views/home.html',
      controller: 'appController',
      requiresLogin: true
    })
    .when('/about', {
      templateUrl: 'views/about.html',
      controller: 'aboutController',
      security: true
    })
    .when('/contact', {
      templateUrl: 'views/contact.html',
      controller: 'contactController',
      requiresLogin: true
    })
    .when('/login', {
      templateUrl: 'views/login.html',
      controller: 'loginController',
      requiresLogin: true
    })
    .when('/profile', {
      templateUrl: 'views/profile.html',
      controller: 'profileController',
      requiresLogin: true
    })
    .when('/controlpanel', {
      templateUrl: 'views/controlpanel.html',
      controller: 'cpController',
      security: true
    })
    .when('/register', {
      templateUrl: 'views/register.html',
      controller: 'registerController',
      requiresLogin: true
    })
    .when('/countries', {
      templateUrl: 'views/countries.html',
      controller: 'countriesController'
    })
    .when('/logout', {
      templateUrl: 'views/home.html',
      controller: 'logoutController'
    })
    .when('/query', {
      templateUrl: 'views/query.html',
      controller: 'queryController'
    })
    .otherwise({
      redirectTo: '/'
    });
});


//Auth



client.factory('authInterceptor', function ($rootScope, $q, $window) {
  return {
    request: function (config) {
      config.headers = config.headers || {};
      if ($window.sessionStorage.token) {
        config.headers.Authorization = 'Bearer ' + $window.sessionStorage.token;
      }
      return config;
    },
    response: function (response) {
      if (response.status === 401) {
        // handle the case where the user is not authenticated
      }
      return response || $q.when(response);
    }
  };
});





//Directives



//Controllers

client.controller('queryController', function($cookies, $scope) {
  if (checkAuth($cookies.monster_cookie){
    
  })
});


client.controller('logoutController', function($cookies, $scope)  {
  var cookie = $cookies.monster_cookie;
  if(cookie != null) {
    console.log("attempted logout");
    document.cookie = 'monster_cookie' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    //$cookies.remove('monster_cookie');
  } else {
    console.log("already logged out");
  }
});

client.controller('countriesController', function($scope){
  $scope.message = 'Countries!';
  $.ajax({
    type: "get",
    url: "https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/?__route__=/countries",
    //header: {monster_cookie: $cookies.monster_cookie},
    //beforeSend: function(xhr){xhr.setRequestHeader('monster_token',myCookie );},
    //5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8
    success: console.log("yay"),//$scope.status = data.status,
    }).done(function(data){
      //console.log(data);
        console.log("done");
    }).fail(function(data){
    //delete $window.sessionStorage.token;
    }).success(function(data){
      $scope.countries = data.countries;
      //console.log(JSON.stringify(data, null, 5));
    console.log("yay success " + data.status);
    $scope.$apply();
    });
});
client.controller('cpController', function($scope){

});

client.controller('appController', function($scope, $cookies, $location){
    if ($cookies.monster_cookie == null)    {
        $location.path("/login");
    }
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

client.controller('loginController', function($scope, $cookies, $location){


  if (!checkAuth($cookies.monster_cookie)){
    $scope.message = 'Login';
    $scope.login={};
    //$scope.login.password = CryptoJS.SHA512($scope.login.password);
    $scope.submit = function()  {


      //auth.login($scope.login);


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
          $scope.$apply(function() { $location.path("/"); });
        } else if(data.status == "403") {
          $scope.loginError = data.status;
        }
        $scope.$apply();
      });
    }
  } else {
    $scope.message='You are already logged in';
  }
});

client.controller('registerController', function($scope, $cookies, $location){
 $scope.message="Register";
 $scope.submit = function(){
     console.log($scope.form);
     var password = $scope.form.password;

   var hash = CryptoJS.SHA512(password).toString();
   $.ajax({
     type:"POST",
     url: "https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/?__route__=/register",
     //beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
     data: JSON.stringify({username: $scope.form.username, password: hash}),
     success: console.log(JSON.stringify({username: $scope.form.username, password: hash})),//$scope.status = data.status,
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
       $scope.registerSuccess = data.status;
         $scope.$apply(function() { $location.path("/login"); });
     } else if(data.status == "403") {
       $scope.registerError = data.status;
     }  else if (data.status == "409"){
        $scope.formError = data.status + " - Username already exists.";
     }
     $scope.$apply();
    console.log(data.status);
   });
 }
});



client.controller('profileController', function($scope, $cookies) {
  $scope.message = 'Profile';

  $scope.$$phase || $scope.$apply();
  if(checkAuth($cookies.monster_cookie)) {
    $.ajax({
      type: "get",
      url: "/Backend/index.php/?__route__=/profile/johndoe",
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
  } else {


  $scope.message = "not authed";

  }
});


client.controller('TypeaheadCtrl', function($scope) {

  $scope.selected = undefined;
});



//Handles the user auth
function checkAuth(cookie)  {
  if (cookie != null){
    return true;
  }
  return false;
}
