angular.module('app.routes', ['ngRoute',])

.config(function($routeProvider, $httpProvider) {
  $routeProvider
    .when('/', {
      templateUrl: 'app/views/home/home.html',
      controller: 'homeController'
    })
    .when('/about', {
      templateUrl: 'app/views/about/about.html',
      controller: 'aboutController'
    })
    .when('/login', {
      templateUrl: 'app/views/login/login.html',
      controller: 'loginController',
    })
    .when('/register', {
      templateUrl: 'app/views/register/register.html',
      controller: 'registerController',
    })
    .when('/logout', {
      templateUrl: 'app/views/logout/logout.html',
      controller: 'logoutController'
    })
    .when('/profile', {
      templateUrl: 'app/views/profile/profile.html',
      controller: 'profileController',
    })
    .when('/countries', {
      templateUrl: 'app/views/countries.html',
      controller: 'countriesController'
    })
    .when('/list/:query', {
      templateUrl: 'app/views/list/list.html',
      controller: 'listController'
    })
    .when('/list', {
      templateUrl: 'app/views/list/list.html',
      controller: 'listController'
    })
    .when('/query', {
      templateUrl: 'app/views/query/query.html',
      controller: 'queryController'
    })
    .when('/query/stats/number', {
      templateUrl: 'app/views/query/stats/stats.html',
      controller: 'numberController'
    })
    .when('/query/stats/earning', {
      templateUrl: 'app/views/query/stats/stats.html',
      controller: 'earningController'
    })
    .when('/query/stats/date', {
      templateUrl: 'app/views/query/stats/date.html',
      controller: 'dateController'
    })
    .when('/query/stats/popularbycountry/type', {
      templateUrl: 'app/views/query/stats/byCountries.html',
      controller: 'byCountryController'
    })
    .when('/query/stats/popularbycountry/camera', {
      templateUrl: 'app/views/query/stats/byCountries.html',
      controller: 'popularCameraByCountryController'
    })
    .when('/query/stats/monthlysales', {
      templateUrl: 'app/views/query/stats/stats.html',
      controller: 'monthlySalesByBrandController'
    })
    .when('/query/stats/topsold', {
      templateUrl: 'app/views/query/stats/topSold.html',
      controller: 'topHobbyController'
    })
    .when('/query/stats/topfeatures', {
      templateUrl: 'app/views/query/stats/topfeatures.html',
      controller: 'topFeaturesController'
    })
    .otherwise({
      templateUrl: 'app/views/404.html'
    })




});
