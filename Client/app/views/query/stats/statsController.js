angular.module('app.query.statsController', ['nvd3'])


.controller('numberController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  if ($scope.isLoggedIn){
    $scope.title = "Stats";
    $scope.stats = "Number of cameras sold by country";
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
      url: backend + "/sales/statistics/number",
      beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
      }).done(function(data){
        console.log(data);
      console.log("done");
      }).fail(function(data){
        toastService.displayToast("Error contacting database");
      }).success(function(data){
        console.log(data);
        $scope.data = data.sales;
        $scope.$apply();
      });
  } else {
    $scope.title="You must be logged in";
    toastService.displayToast("You must be logged in to access in");
    $location.path("/login");
    $rootScope.$Apply();

  }

})

.controller('earningController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  if ($scope.isLoggedIn)  {
    $scope.title = "Stats";
    $scope.stats = "Earning by countries";

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
      url: backend + "/sales/statistics/earnings",
      beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
      }).done(function(data){
        console.log(data);
      console.log("done");
      }).fail(function(data){
        toastService.displayToast("Error contacting database");
      }).success(function(data){
        console.log(data);
        $scope.data = data.sales;
        $scope.$apply();
    });
  } else {
    $scope.title="You must be logged in";
    toastService.displayToast("You must be logged in to access in");
    $location.path("/login");
    $rootScope.$Apply();
  }

})

.controller('dateController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  if ($scope.isLoggedIn)  {
    $scope.title = "Stats";
    $scope.stats = "Earning and number sold by date";
    $scope.options = {
    chart: {
        type: 'linePlusBarChart',
        height: 450,
        margin : {
            top: 30,
            right: 75,
            bottom: 50,
            left: 75
        },
        x: function(d, i){return i;},
        y: function(d){return d[1];},
        color: d3.scale.category10().range(),
        transitionDuration: 250,
        xAxis: {
            axisLabel: 'X Axis',
            showMaxMin: false,
            tickFormat: function(d) {
                var dx = $scope.data[0].values[d] && $scope.data[0].values[d][0] || 0;
                return dx ? d3.time.format('%d/%m/%y')(new Date(dx)) : '';
            },
            staggerLabels: true
        },
        y1Axis: {
            axisLabel: 'Y1 Axis',
            tickFormat: function(d){return d3.format(',f')(d)}
        },
        y2Axis: {
            axisLabel: 'Y2 Axis',
            tickFormat: function(d) { return '$' + d3.format(',.2f')(d);}
        }
    }
  };

  /* Chart data */
  $scope.data = [];

    $.ajax({
      type: "GET",
      url: backend + "/sales/statistics/date",
      beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
      }).done(function(data){
        console.log(data);
        console.log("done");

      }).fail(function(data){
        toastService.displayToast("Error contacting database");
      }).success(function(data){
        $scope.data = data.data;
        $scope.$apply();
      });
  } else {
      $scope.title="You must be logged in";
      toastService.displayToast("You must be logged in to access in");
      $location.path("/login");
      $rootScope.$Apply();
    }
})

.controller('TypeaheadCtrl', function(listService, $scope, $cookies, toastService)  {

})

.controller('byCountryController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Show popular camera types by country";
  $.ajax({
    type: "get",
    url: config+"/countries",
    }).done(function(data){
      //console.log(data);
        console.log("done");
    }).fail(function(data){
    //delete $window.sessionStorage.token;
    }).success(function(data){
      $scope.countries = data.countries;
      //console.log(JSON.stringify(data, null, 5));
    });

  $scope.selected = undefined;
  $scope.submitQuery = function(answer)  {
    if (answer != undefined || answer != null)  {
      console.log(answer);
      /* Chart options */
      $scope.options = {
          chart: {
              type: 'pieChart',
              height: 500,
              x: function(d){return d.type;},
              y: function(d){return d.sales;},
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
        url: backend + "/type/popular/country/" + answer.id,
        beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
      }).done(function(data){
          console.log(data);
          console.log("done");

        }).fail(function(data){
          toastService.displayToast("Error contacting database");
        }).success(function(data){
          $scope.data = data.data;
          $scope.countryName = answer.name;
          $scope.$apply();
        });
    } else {
      toastService.displayToast("You have entered an invalid query");
    }

  }
})
.controller('popularCameraByCountryController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Show popular camera types by country";
  $.ajax({
    type: "get",
    url: config+"/countries",
    }).done(function(data){
      //console.log(data);
        console.log("done");
    }).fail(function(data){
    //delete $window.sessionStorage.token;
    }).success(function(data){
      $scope.countries = data.countries;
      //console.log(JSON.stringify(data, null, 5));
    });

  $scope.selected = undefined;
  $scope.submitQuery = function(answer)  {
    if (answer != undefined || answer != null)  {
      console.log(answer);
      /* Chart options */
      $scope.options = {
          chart: {
              type: 'pieChart',
                height: 500,
                donut: true,
                x: function(d){return d.label;},
                y: function(d){return d.value;},
                showLabels: true,

                pie: {
                    startAngle: function(d) { return d.startAngle},
                    endAngle: function(d) { return d.endAngle }
                },
                transitionDuration: 500,
                legend: {
                    margin: {
                        top: 5,
                        right: 70,
                        bottom: 5,
                        left: 0
                    }
                }
          }
      };

      $scope.data = [];
      $.ajax({
        type: "GET",
        url: backend + "/camera/popular/country/" + answer.id,
        beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
      }).done(function(data){
          console.log(data);
          console.log("done");

        }).fail(function(data){
          toastService.displayToast("Error contacting database");
        }).success(function(data){
          $scope.data = data.data;
          $scope.countryName = answer.name;
          $scope.$apply();
        });
    } else {
      toastService.displayToast("You have entered an invalid query");
    }

  }
});
