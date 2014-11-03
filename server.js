/*
      Dir server!
      Author: Remon
      Desc: Makes a webserver which hosts all files in the directory.
            Please note that this is not secure and can/will break.
            Think of this as a quick server for testing when developing.
*/
var connect = require('connect');
var serveStatic = require('serve-static');
//You can change this to any port
var port = 80;
connect().use(serveStatic(__dirname)).listen(port);
console.log("listening on http://localhost:" + port);
