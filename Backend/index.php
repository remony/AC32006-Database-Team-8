<?php
include_once 'api.php';

include_once 'epiphany/Epi.php';
Epi::setPath('base', 'epiphany');
Epi::setPath('config', dirname(__FILE__));
Epi::init('route', 'api');

getApi()->get('/', array('API', 'version'), EpiApi::external);

// Load the routes from routes.ini then call run()
getRoute()->load('routes.ini');
getRoute()->run();