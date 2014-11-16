angular.module('app.listController', ['app.listService'])


.controller('listController', function($routeParams, $scope, $rootScope, $cookies, $location, $mdDialog, toastService, listService, listService) {
  $scope.title = "List";
  $scope.subject = $routeParams.query;
  if ($scope.isLoggedIn)  {
  switch($routeParams.query){
    case "camera":
      listService.getCameras(function(data)  {
        $scope.output = data.camera_camera;
      })
    break;
    case "countries":
      listService.getCountries(function(data)  {
        $scope.output = data.countries;
      })
    break;
    case "customer":
      listService.getCustomers(function(data)  {
        $scope.output = data.customer;
      })
    break;
    case "hobby":
      listService.getHobbies(function(data)  {
        $scope.output = data.hobby;
      })
    break;
    case "lens":
      listService.getLens(function(data)  {
        $scope.output = data.lens;
      })
    break;
    case "profession":
      listService.getProfessions(function(data)  {
        $scope.output = data.profession;
      })
    break;
    case "sale":
      listService.getSales(function(data)  {
        $scope.output = data.sale;
      })
    break;
    case "storage":
      listService.getStorages(function(data)  {
        $scope.output = data.storage_types;
      })
    break;
    case "type":
      listService.getTypes(function(data)  {
        $scope.output = data.camera_type;
      })
    break;
    default:
      toastService.displayToast("No results returned for " + $routeParams.query);
      $location.path("/list");
      break;
  }
} else {
  toastService.displayToast("You must be logged in to access this.");
  $location.path("/login");
}





});
