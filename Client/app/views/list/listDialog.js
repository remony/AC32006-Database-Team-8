angular.module('app.listDialog', ['app.listService'])


.controller('listDialog', function($routeParams, $scope, $cookies, $location, $mdDialog, listService, listService) {

  $scope.dialogAdd = function(ev) {
    $mdDialog.show({
      templateUrl: 'app/components/addNewItem.html',
      targetEvent: ev,
      controller: DialogController
    });
  };





  function DialogController($scope, $mdDialog) {
  $scope.hide = function() {
    $mdDialog.hide();
  };

  $scope.cancel = function() {
    $mdDialog.cancel();
  };

  $scope.answer = function(answer) {
    $mdDialog.hide(answer);
  };


  $scope.submitNewType = function(answer)  {
    console.log("user wanted to add something");
    switch($routeParams.query){
        case "camera":
          listService.addCameras(answer)
        break;
        case "countries":
          listService.addCountries()
        break;
        case "customer":
          listService.addCustomers()
        break;
        case "hobby":
          listService.addHobbies()
        break;
        case "lens":
          listService.addLens()
        break;
        case "profession":
          listService.addProfessions()
        break;
        case "sale":
          listService.addSales()
        break;
        case "storage":
          listService.addStorages()
        break;
        case "type":
          listService.addTypes(answer);
          window.location.reload(true);
        break;
      }

    }
  }
});
