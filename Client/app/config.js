/*
      Set the url to your domain
      Exclude http:// and do not add / at the end
*/

var domain = 'localhost';




/*
        Do not touch unless developers
*/

var backend = 'http://' + domain + "/backend";
angular.module('app.config', [])

    .factory('Configuration', function() {
        return {
            backend: backend
        }
    });
