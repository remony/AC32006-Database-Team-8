//Create the module
var client = angular.module('clientApp', [
  'ngRoute',
  'ngCookies',
  'ngAnimate',
  'ui.bootstrap',
  'ngMaterial',
  'clientApp.query',
  'clientApp.register',
  'clientApp.admin',
  'ngRouteAnimationManager',
  'clientApp.toast',
  'clientApp.userAuth',
  'clientApp.list'
  ]);


var cookie = null;
//Configure routes
client.config(function($routeProvider, $httpProvider, RouteAnimationManagerProvider){

 //$httpProvider.defaults.useXDomain = true;
 //$httpProvider.defaults.withCredentials = true;
RouteAnimationManagerProvider.setDefaultAnimation('fade');

  //$httpProvider.interceptors.push('authInterceptor');
  $routeProvider
    .when('/', {
      templateUrl: 'views/home.html',
      controller: 'appController',

    })
    .when('/about', {
      templateUrl: 'views/about.html',
      controller: 'aboutController',
      security: true
    })
    .when('/contact', {
      templateUrl: 'views/contact.html',
      controller: 'contactController',

    })
    .when('/login', {
      templateUrl: 'views/login.html',
      controller: 'loginController',

    })
    .when('/profile', {
      templateUrl: 'views/profile.html',
      controller: 'profileController',

    })
    .when('/controlpanel', {
      templateUrl: 'views/controlpanel.html',
      controller: 'cpController',
      security: true
    })
    .when('/register', {
      templateUrl: 'views/register.html',
      controller: 'registerController',

    })
    .when('/countries', {
      templateUrl: 'views/countries.html',
      controller: 'countriesController'
    })
    .when('/logout', {
      templateUrl: 'views/home.html',
      controller: 'logoutController'
    })
    .otherwise('/');

});


//Auth


//*
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




client.controller('logoutController', function($cookies, $scope, $mdToast, $location)  {
  var cookie = $cookies.monster_cookie;

  if(cookie != null) {
    console.log("attempted logout");
    document.cookie = 'monster_cookie' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    cookie = null;
    $mdToast.show({
      template: '<md-toast>You have logged out!</md-toast>',
      hideDelay: 5000,
      position: 'top right'
    });
    $location.path("/login");
    //$cookies.remove('monster_cookie');
  } else {
    $mdToast.show({
      template: '<md-toast>You are already logged out</md-toast>',
      hideDelay: 5000,
      position: 'top right'
    });
    console.log("already logged out");
  }
});

client.controller('countriesController', function($scope){
  $scope.message = 'Countries!';

  $.ajax({
    type: "get",
    url: "https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/?__route__=/countries",
    }).done(function(data){
      //console.log(data);
        console.log("done");
    }).fail(function(data){
    //delete $window.sessionStorage.token;
    }).success(function(data){
      $scope.countries = data.countries;
      //console.log(JSON.stringify(data, null, 5));
    });
});
client.controller('cpController', function($scope){

});

function DialogController($scope, $mdDialog) {
  $scope.hide = function() {
    $mdDialog.hide();
  };

  $scope.cancel = function() {
    $mdDialog.cancel();
  };

  $scope.answer = function(answer) {
    $mdDialog.hide(answer);
  };
}



client.controller('appController', function($scope, $cookies, $location, $timeout, $mdSidenav, $mdDialog){
      checkAuth($cookies.monster_cookie);

      $scope.toggleLeft = function() {
        $mdSidenav('left').toggle();
      };

      $scope.dialogBasic = function(ev) {
      $mdDialog.show({
        templateUrl: 'app/partials/loginTemplate.html',
        targetEvent: ev,
        controller: DialogController
      }).then(function() {
        $scope.alert = 'You said "Okay".';
      }, function() {
        $scope.alert = 'You cancelled the dialog.';
      });
    };
});

client.controller('aboutController', function($scope, $cookies){
  checkAuth($cookies.monster_cookie);
  $scope.message = 'About';
  $.ajax({
    type: "get",
    url: "http://localhost/Backend/"
    }).done(function(data){

    }).fail(function(data){
      //delete $window.sessionStorage.token;
      console.log("failed to get about data");
    }).success(function(data){
      $scope.profile = data.message;
      $scope.module = data.module;
      $scope.team = data.team;
      $scope.version = data.version;
      $scope.members = data.members;
    $scope.$apply();
    });
});

client.controller('contactController', function($scope, $cookies){
  checkAuth($cookies.monster_cookie);
  $scope.message = 'Contact';
});

client.controller('loginController', function($scope, $cookies, $location, $mdToast){
function toastIt() {
$mdToast.show({
  template: '<md-toast>' + $scope.toast + '</md-toast>',
  hideDelay: 2000,
  position: getToastPosition()
});
function getToastPosition() {
return Object.keys($scope.toastPosition)
  .filter(function(pos) { return $scope.toastPosition[pos]; })
  .join(' ');
};


};

$scope.toastPosition = {
  bottom: false,
  top: true,
  left: false,
  right: true
};


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
        url: "http://localhost/Backend/login",
        data: JSON.stringify({username: $scope.login.username, password: hash}),
        //5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8
        dataType: "JSON"
        }).done(function(data){
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
          $scope.toast = "You have logged in!";
          $location.path("/query");
        } else if(data.status == "403") {
          $scope.toast = "Incorrect username or password";
        }
        toastIt();
        $scope.$apply();
      });
    }

});








client.controller('profileController', function($scope, $cookies, $mdToast, $location) {
  $scope.message = 'Profile';

  $scope.$$phase || $scope.$apply();
  if(checkAuth($cookies.monster_cookie)) {
    $.ajax({
      type: "get",
      url: "http:/Backend/profile/userid",
      beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
      }).done(function(data){
        console.log(data);
      console.log("done");
      }).fail(function(data){
        console.log("Error fetching profile info");
      }).success(function(data){
        $scope.profileUsername = data[0].username;
        $scope.profileGroup = data[0].group_name;
        console.log(JSON.stringify(data, null, 5));
        console.log("yay success " + data.status);
        console.log(data[0].username);
        $scope.$apply();
      });
  } else {


  $mdToast.show({
    template: '<md-toast>You must be logged in to access this</md-toast>',
    hideDelay: 3000,
    position: 'top right'
  });
  $location.path("/login");

  }
});


client.controller('TypeaheadCtrl', function($scope) {

  $scope.selected = undefined;
});



client.controller('AppCtrl', function($scope, $timeout, $mdSidenav) {
  $scope.toggleLeft = function() {
    $mdSidenav('left').toggle();
  };
  $scope.toggleRight = function() {
    $mdSidenav('right').toggle();
  };
})

client.controller('LeftCtrl', function($scope, $timeout, $mdSidenav) {
  $scope.close = function() {
    $mdSidenav('left').close();
  };
})





//Handles the user auth
function checkAuth(cookie)  {
  if (cookie != null){
    //$scope.isLoggedIn = true;
    return true;
  }
  return null;
}
