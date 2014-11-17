angular.module('app.query.statsController', ['nvd3'])


.controller('numberController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Stats";

        /* Chart options */
        $scope.options = {
            chart: {
                type: 'pieChart',
                height: 500,
                x: function(d){return d.label;},
                y: function(d){return d.value;},
                showLabels: true,
                transitionDuration: 500,
                labelThreshold: 0.01,
                legend: {
                    margin: {
                        top: 5,
                        right: 35,
                        bottom: 5,
                        left: 0
                    }
                }
            }
        };

        $scope.data = [];

  $.ajax({
    type: "GET",
    url: "http://localhost/backend/sales/statistics/number",
    beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
    }).done(function(data){
      console.log(data);
    console.log("done");
    }).fail(function(data){
      console.log("Error fetching profile info");
    }).success(function(data){
      console.log(data);
      $scope.data = data.sales;
    });

})

.controller('earningController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Stats";

        /* Chart options */
        $scope.options = {
            chart: {
                type: 'pieChart',
                height: 500,
                x: function(d){return d.label;},
                y: function(d){return d.value;},
                showLabels: true,
                transitionDuration: 500,
                labelThreshold: 0.01,
                legend: {
                    margin: {
                        top: 5,
                        right: 35,
                        bottom: 5,
                        left: 0
                    }
                }
            }
        };

        $scope.data = [];

  $.ajax({
    type: "GET",
    url: "http://localhost/backend/sales/statistics/earnings",
    beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
    }).done(function(data){
      console.log(data);
    console.log("done");
    }).fail(function(data){
      console.log("Error fetching profile info");
    }).success(function(data){
      console.log(data);
      $scope.data = data.sales;
    });

});
