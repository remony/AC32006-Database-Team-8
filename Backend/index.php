<?php
include_once 'api.php';
include_once 'crud/storage_types_crud.php';
include_once 'crud/camera_types_crud.php';
include_once 'crud/lens_types_crud.php';
include_once 'crud/hobby_types_crud.php';
include_once 'crud/camera_crud.php';
include_once 'crud/customer_crud.php';
include_once 'crud/profession_crud.php';
include_once 'crud/sales_crud.php';

include_once 'epiphany/Epi.php';
Epi::setPath('base', 'epiphany');
Epi::setPath('config', dirname(__FILE__));
Epi::setSetting('exceptions', true);
Epi::init('route', 'api', 'database');

// type = mysql, database = mysql, host = localhost, user = root, password = [empty]
//EpiDatabase::employ('mysql','AC32006_Database_Team_10','127.0.0.1','AC32006','Team10IsAwesome'); // Yago Database
//EpiDatabase::employ('mysql','14ac3d55','127.0.0.1','14ac3u55','a1bc23'); // Yago Database
EpiDatabase::employ('mysql','14ac3d55','localhost','root','lemon'); // Stuart Database
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

getApi()->get('/type/popular/country/(\w+)',  array('CameraTypesCrud', 'popular_type_camera_in_country'), EpiApi::external); // Read

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

// Profession
getApi()->post('/profession',          array('ProfessionCrud', 'create_profession'), EpiApi::external); // Create
getApi()->post('/profession/(\w+)',    array('ProfessionCrud', 'update_profession'), EpiApi::external); // Update
getApi()->get('/profession',           array('ProfessionCrud', 'read_profession'),   EpiApi::external); // Read
getApi()->delete('/profession/(\w+)',  array('ProfessionCrud', 'delete_profession'), EpiApi::external); // Delete

// Camera
getApi()->post('/camera',          array('CameraCrud', 'create_camera'), EpiApi::external); // Create
getApi()->post('/camera/(\w+)',    array('CameraCrud', 'update_camera'), EpiApi::external); // Update
getApi()->get('/camera',           array('CameraCrud', 'read_camera'),   EpiApi::external); // Read
getApi()->delete('/camera/(\w+)',  array('CameraCrud', 'delete_camera'), EpiApi::external); // Delete

getApi()->get('/camera/popular/country/(\w+)',  array('CameraCrud', 'popular_camera_in_country'), EpiApi::external); // Read
// Customer
getApi()->post('/customer',          array('CustomerCrud', 'create_customer'), EpiApi::external); // Create
getApi()->post('/customer/(\w+)',    array('CustomerCrud', 'update_customer'), EpiApi::external); // Update
getApi()->get('/customer',           array('CustomerCrud', 'read_customer'),   EpiApi::external); // Read
getApi()->delete('/customer/(\w+)',  array('CustomerCrud', 'delete_customer'), EpiApi::external); // Delete

// Sale
getApi()->post('/sale',          array('SalesCrud', 'create_sale'), EpiApi::external); // Create
getApi()->post('/sale/(\w+)',    array('SalesCrud', 'update_sale'), EpiApi::external); // Update
getApi()->get('/sale',           array('SalesCrud', 'read_sale'),   EpiApi::external); // Read
getApi()->delete('/sale/(\w+)',  array('SalesCrud', 'delete_sale'), EpiApi::external); // Delete

getApi()->get('/customer/(\w+)/sales', array('SalesCrud', 'read_sales_user'),   EpiApi::external); // Read
getApi()->get('/sales/statistics/(\w+)', array('SalesCrud', 'numberOfSales'),   EpiApi::external); // Read

// Customer Hobbies
getApi()->post('/customer/(\w+)/hobby/(\w+)',           array('CustomerCrud', 'add_hobby_to_customer'),      EpiApi::external); // Create
getApi()->get('/customer/(\w+)/hobby',                  array('CustomerCrud', 'hobby_from_customer'),        EpiApi::external); // Read
getApi()->delete('/customer/(\w+)/hobby/(\w+)',         array('CustomerCrud', 'remove_hobby_from_customer'), EpiApi::external); // Delete

// Customer Professions
getApi()->post('/customer/(\w+)/profession/(\w+)',           array('CustomerCrud', 'add_profession_to_customer'),      EpiApi::external); // Create
getApi()->get('/customer/(\w+)/profession',                  array('CustomerCrud', 'profession_from_customer'),        EpiApi::external); // Read
getApi()->delete('/customer/(\w+)/profession/(\w+)',         array('CustomerCrud', 'remove_profession_from_customer'), EpiApi::external); // Delete

// Type Lenses
getApi()->post('/type/(\w+)/lens/(\w+)',           array('LensTypesCrud', 'add_lens_to_type'),      EpiApi::external); // Create
getApi()->get('/type/(\w+)/lens',                  array('LensTypesCrud', 'lens_from_type'),        EpiApi::external); // Read
getApi()->delete('/type/(\w+)/lens/(\w+)',         array('LensTypesCrud', 'remove_lens_from_type'), EpiApi::external); // Delete


getRoute()->run();