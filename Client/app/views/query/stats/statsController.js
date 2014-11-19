angular.module('app.query.statsController', ['nvd3'])
/*
    This controller shows the amount of cameras sold by each camera
*/

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

/*
      This controller shows the earning of each country


*/

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


/*
    This controller displays the amount sold by date

*/
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
      beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)}
      }).done(function(data){
        console.log(data);
        console.log("done");

      }).fail(function(data){
        toastService.displayToast("Error contacting database");
      }).success(function(data){
        $scope.data = data.data;

        var parsed_data = [];
        for (var i=0;i<data.data[0].values.length;i+=1) {
            parsed_data.push({
                'date' : data.data[0].values[i][0],
                'price' : data.data[0].values[i][1],
                'quantity' : data.data[1].values[i][1]
            });
        }

        $scope.table = parsed_data;
        $scope.$apply();
      });
  } else {
      $scope.title="You must be logged in";
      toastService.displayToast("You must be logged in to access in");
      $location.path("/login");
      $rootScope.$Apply();
    }
})

/*

    This controller hows the the popular computer types in the defined country
    this could be goPro, compact, etc.

*/

.controller('byCountryController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Show popular camera types by country";
  $.ajax({
    type: "get",
    url: backend + "/countries"
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
          $scope.isType = true;
          $scope.$apply();
        });
    } else {
      toastService.displayToast("You have entered an invalid query");
    }

  }
})

/*
      This controller shows the most sold camera in the defined country

*/


.controller('popularCameraByCountryController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Show popular camera types by country";
  $.ajax({
    type: "get",
    url: backend + "/countries"
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
          $scope.isCamera = true;
          $scope.countryName = answer.name;
          $scope.$apply();
        });
    } else {
      toastService.displayToast("You have entered an invalid query");
    }

  }
})

/*

    This controller displays the monthly sales of all the brands in the database

*/


.controller('monthlySalesByBrandController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Monthly sales by brand";

      /* Chart options */
                //x: function(d){return d[0];},
                //y: function(d){return d[1];},
      $scope.options = {
          chart: {
                type: 'cumulativeLineChart',
                height: 450,
                margin : {
                    top: 20,
                    right: 20,
                    bottom: 60,
                    left: 65
                },
                x: function(d){ return new Date(d[0]); },
                y: function(d){ return d[1]; },
                average: function(d) { return d.mean/100; },

                color: d3.scale.category10().range(),
                transitionDuration: 600,
                useInteractiveGuideline: true,
                clipVoronoi: false,

                xAxis: {
                    axisLabel: 'X Axis',
                    tickFormat: function(d) {
                        return d3.time.format('%m/%d/%y')(new Date(d))
                    },
                    showMaxMin: false,
                    staggerLabels: true
                },

                yAxis: {
                    axisLabel: 'Y Axis',
                    tickFormat: function(d){
                        return d3.format(',.1%')(d);
                    },
                    axisLabelDistance: 20
                }
            }
      };

      $scope.data = [];
      $.ajax({
        type: "GET",
        url: backend + "/camera/sales/month/brand",
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


})

///hobby/top
///profession/top

.controller('topHobbyController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Most used cameras";
  $scope.data = {
      selectedIndex : 0,
      secondLocked : false,
      secondLabel : "Graph"
    };

    $scope.next = function() {
      $scope.data.selectedIndex = Math.min($scope.data.selectedIndex + 1, 2) ;
    };

    $scope.previous = function() {
      $scope.data.selectedIndex = Math.max($scope.data.selectedIndex - 1, 0);
    };

    $scope.options = {
        chart: {
            type: 'pieChart',
              height: 500,
              donut: true,
              x: function(d){return d.camera;},
              y: function(d){return d.sales;},
              showLabels: true,

              pie: {
                  startAngle: function(d) { return d.startAngle},
                  endAngle: function(d) { return d.endAngle }
              },
              transitionDuration: 300,
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

    $scope.graph = [];
    $.ajax({
      type: "GET",
      url: backend + "/hobby/top",
      beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
    }).done(function(data){
        console.log(data);
        console.log("done");

      }).fail(function(data){
        toastService.displayToast("Error contacting database");
      }).success(function(data){
        $scope.graph = data.data;
        $scope.$apply();
      });


})

.controller('topProfessionController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Most used cameras";
  $scope.data = {
    selectedIndex : 0,
    secondLocked : false,
    secondLabel : "Graph"
  };

  $scope.next = function() {
    $scope.data.selectedIndex = Math.min($scope.data.selectedIndex + 1, 2) ;
  };

  $scope.previous = function() {
    $scope.data.selectedIndex = Math.max($scope.data.selectedIndex - 1, 0);
  };
      $scope.options = {
          chart: {
              type: 'pieChart',
                height: 300,
                donut: true,
                x: function(d){return d.profession;},
                y: function(d){return d.sales;},
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

      $scope.graph = [];
      $.ajax({
        type: "GET",
        url: backend + "/profession/top",
        beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
      }).done(function(data){
          console.log(data);
          console.log("done");

        }).fail(function(data){
          toastService.displayToast("Error contacting database");
        }).success(function(data){
          $scope.graphProfession = data.data;
          $scope.$apply();
        });


})

.controller('topSalesBarController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
        $scope.hobby_options = {
            chart: {
                type: 'discreteBarChart',
                height: 450,
                margin : {
                    top: 20,
                    right: 20,
                    bottom: 60,
                    left: 55
                },
                x:  function(d){return d.hobby;},
                y: function(d){ return d.sales; },
                showValues: true,
                valueFormat: function(d){
                    return d3.format('')(d);
                },
                transitionDuration: 500,
                xAxis: {
                    axisLabel: 'X Axis'
                },
                yAxis: {
                    axisLabel: 'Y Axis',
                    axisLabelDistance: 30
                }
            }
        };

        $scope.options = {
            chart: {
                type: 'discreteBarChart',
                height: 450,
                margin : {
                    top: 20,
                    right: 20,
                    bottom: 60,
                    left: 55
                },
                x: function(d){return d.profession;},
                y: function(d){return d.sales;},
                showValues: true,
                valueFormat: function(d){
                    return d3.format('')(d);
                },
                transitionDuration: 500,
                xAxis: {
                    axisLabel: 'X Axis'
                },
                yAxis: {
                    axisLabel: 'Y Axis',
                    axisLabelDistance: 30
                }
            }
        };




      $scope.graph = [];
    $.ajax({
        type: "GET",
        url: backend + "/profession/top",
        beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)}
    }).done(function(data){
        console.log(data);

    }).fail(function(data){
        toastService.displayToast("Error contacting database");

    }).success(function (data) {
        $scope.graphProfession = [{
          'key' : 'professions',
          'values' : data.data
        }];

        $scope.$apply();
    });

    $.ajax({
        type: "GET",
        url: backend + "/hobby/top",
        beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)}
    }).done(function(data){
        console.log(data);

    }).fail(function(data){
        toastService.displayToast("Error contacting database");

    }).success(function(data){
        $scope.graphHobby = [{
            'key' : 'hobbies',
            'values' : data.data
        }];

        $scope.$apply();
    });


});
