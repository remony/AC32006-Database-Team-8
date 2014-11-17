'use strict';

/**
 * @ngdoc overview
 * @name testApp
 * @description
 * # testApp
 *
 * Main module of the application.
 */
angular
  .module('app', [

  //dependencies
  'ngCookies',
  'ngMaterial',
  'ui.bootstrap',
  'app.listDialog',
  'googlechart',

  //Controllers
  'app.indexController',
  'app.homeController',
  'app.aboutController',
  'app.loginController',
  'app.registerController',
  'app.logoutController',
  'app.profileController',
  'app.listController',
  'app.queryController',
  'app.query.statsController',

  //Services
  'app.toast',
  'app.auth',

  //Routes
  'app.routes'



  ]);
