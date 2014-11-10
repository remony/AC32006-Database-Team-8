angular.module('clientApp.userAuth', ['ngRoute', 'ngCookies', 'ngMaterial'])

.factory('authService', function( ){
  var sdo = {
		isLogged: false,
		username: ''
	};
	return sdo;
});
