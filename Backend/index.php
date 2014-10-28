<?php
include_once 'api.php';

include_once 'epiphany/Epi.php';
Epi::setPath('base', 'epiphany');
Epi::setPath('config', dirname(__FILE__));
Epi::init('route', 'api');

getApi()->get('/', array('API', 'version'), EpiApi::external);

getApi()->post('/login', array('API', 'login'), EpiApi::external);

getApi()->get('/profile/(\w+)', array('API', 'profile'), EpiApi::external);

getRoute()->run();