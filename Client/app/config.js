/*
      Set the url to your domain
      Exclude http:// and do not add / at the end
*/

var domain = 'https://zeno.computing.dundee.ac.uk/2014-ac32006/yagocarballo/?__route__=';




/*
        Do not touch unless developers
*/

var backend = domain;
angular.module('app.config', [])

    .factory('Configuration', function() {
        return {
            backend: backend
        }
    });
