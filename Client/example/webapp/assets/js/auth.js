angular.module('clientApp')
  .factory('UserService'. ['$http', function($http){
    var service = {
      isLoggedIn: false;

      session: function(){
        return $http.get('')
        .then(function(response){
          service.isLoggedIn = true;
          return response;
        });
      },
      login: function(user) {
        return $http.post('/api/login', user)
        .then(function(response)  {
          service.isLoggedIn = true;
          return response;
        });
      }
    };
    return service;
  }]);
