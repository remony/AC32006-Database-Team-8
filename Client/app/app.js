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

  //Services
  'app.toast',
  'app.auth',

  //Routes
  'app.routes'



  ]);
