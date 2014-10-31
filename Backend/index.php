<?php
include_once 'api.php';

include_once 'epiphany/Epi.php';
Epi::setPath('base', 'epiphany');
Epi::setPath('config', dirname(__FILE__));
Epi::setSetting('exceptions', true);
Epi::init('route', 'api', 'database');

// type = mysql, database = mysql, host = localhost, user = root, password = [empty]
EpiDatabase::employ('mysql','AC32006_Database_Team_10','127.0.0.1','AC32006','Team10IsAwesome'); // Local Database
//EpiDatabase::employ('mysql','14ac3d55','silva.computing.dundee.ac.uk','14ac3u55','a1bc23'); // Remote Database

// creates the database, if it doesn't exist
include_once 'db_schema.php';

getApi()->get('/', array('API', 'version'), EpiApi::external);

getApi()->post('/login', array('API', 'login'), EpiApi::external);

getApi()->get('/profile/(\w+)', array('API', 'profile'), EpiApi::external);

getRoute()->run();