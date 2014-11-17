angular.module('app.query.statsController', [])


.controller('numberController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Stats";

$scope.config = {
    title: 'Products',
    tooltips: true,
    labels: false,
    mouseover: function() {},
    mouseout: function() {},
    click: function() {},
    legend: {
      display: true,
      //could be 'left, right'
      position: 'right'
    }
  };

  $scope.data = {
    series: ['Sales', 'Income', 'Expense', 'Laptops', 'Keyboards'],
    data: [{
      x: "Laptops",
      y: [100, 500, 0],
      tooltip: "this is tooltip"
    }, {
      x: "Desktops",
      y: [300, 100, 100]
    }, {
      x: "Mobiles",
      y: [351]
    }, {
      x: "Tablets",
      y: [54, 0, 879]
    }]
  };






  $.ajax({
    type: "GET",
    url: "http://localhost/Backend/sales/statistics/number",
    beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
    }).done(function(data){
      console.log(data);
    console.log("done");
    }).fail(function(data){
      console.log("Error fetching profile info");
    }).success(function(data){
      $scope.data = data.sales;
      $scope.datas = JSON.Stringify(data);
      $scope.$apply();
    });






});
