<?php
include_once 'api.php';
include_once 'crud/storage_types_crud.php';
include_once 'crud/camera_types_crud.php';
include_once 'crud/lens_types_crud.php';
include_once 'crud/hobby_types_crud.php';
include_once 'crud/camera_crud.php';

include_once 'epiphany/Epi.php';
Epi::setPath('base', 'epiphany');
Epi::setPath('config', dirname(__FILE__));
Epi::setSetting('exceptions', true);
Epi::init('route', 'api', 'database');

// type = mysql, database = mysql, host = localhost, user = root, password = [empty]
EpiDatabase::employ('mysql','AC32006_Database_Team_10','127.0.0.1','AC32006','Team10IsAwesome'); // Yago Database
//EpiDatabase::employ('mysql','14ac3d55','localhost','root','lemon'); // Stuart Database
//EpiDatabase::employ('mysql','14ac3d55','silva.computing.dundee.ac.uk','14ac3u55','a1bc23'); // Remote Database

// creates the database, if it doesn't exist
include_once 'db_schema.php';

getApi()->get('/', array('API', 'version'), EpiApi::external);

getApi()->post('/login', array('API', 'login'), EpiApi::external);

getApi()->post('/register', array('API', 'register'), EpiApi::external);

getApi()->get('/profile/(\w+)', array('API', 'profile'), EpiApi::external);

getApi()->get('/countries', array('API', 'countries'), EpiApi::external);

getApi()->post('/cameras/feature', array('API', 'queryFeatures'), EpiApi::external);

// Storage
getApi()->post('/storage',          array('StorageTypesCrud', 'create_storage'), EpiApi::external); // Create
getApi()->post('/storage/(\w+)',    array('StorageTypesCrud', 'update_storage'), EpiApi::external); // Update
getApi()->get('/storage',           array('StorageTypesCrud', 'read_storage'),   EpiApi::external); // Read
getApi()->delete('/storage/(\w+)',  array('StorageTypesCrud', 'delete_storage'), EpiApi::external); // Delete

// Type
getApi()->post('/type',             array('CameraTypesCrud', 'create_type'), EpiApi::external); // Create
getApi()->post('/type/(\w+)',       array('CameraTypesCrud', 'update_type'), EpiApi::external); // Update
getApi()->get('/type',              array('CameraTypesCrud', 'read_type'),   EpiApi::external); // Read
getApi()->delete('/type/(\w+)',     array('CameraTypesCrud', 'delete_type'), EpiApi::external); // Delete

// Lens
getApi()->post('/lens',          array('LensTypesCrud', 'create_lens'), EpiApi::external); // Create
getApi()->post('/lens/(\w+)',    array('LensTypesCrud', 'update_lens'), EpiApi::external); // Update
getApi()->get('/lens',           array('LensTypesCrud', 'read_lens'),   EpiApi::external); // Read
getApi()->delete('/lens/(\w+)',  array('LensTypesCrud', 'delete_lens'), EpiApi::external); // Delete

// Hobby
getApi()->post('/hobby',          array('HobbyTypesCrud', 'create_hobby'), EpiApi::external); // Create
getApi()->post('/hobby/(\w+)',    array('HobbyTypesCrud', 'update_hobby'), EpiApi::external); // Update
getApi()->get('/hobby',           array('HobbyTypesCrud', 'read_hobby'),   EpiApi::external); // Read
getApi()->delete('/hobby/(\w+)',  array('HobbyTypesCrud', 'delete_hobby'), EpiApi::external); // Delete

// Camera
getApi()->post('/camera',          array('CameraCrud', 'create_camera'), EpiApi::external); // Create
getApi()->post('/camera/(\w+)',    array('CameraCrud', 'update_camera'), EpiApi::external); // Update
getApi()->get('/camera',           array('CameraCrud', 'read_camera'),   EpiApi::external); // Read
getApi()->delete('/camera/(\w+)',  array('CameraCrud', 'delete_camera'), EpiApi::external); // Delete

getRoute()->run();