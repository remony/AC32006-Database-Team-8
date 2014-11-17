angular.module('app.query.statsController', [])


.controller('numberController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
  $scope.title = "Stats";


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
      $scope.$apply();
    });

  var chart1 = {};
    chart1.type = "ColumnChart";
    chart1.cssStyle = "height:500px; width:100%;";
    chart1.data = {"cols": [
        {id: "month", label: "Month", type: "string"},
        {id: "laptop-id", label: "Laptop", type: "number"},
        {id: "desktop-id", label: "Desktop", type: "number"},
        {id: "server-id", label: "Server", type: "number"},
        {id: "cost-id", label: "Shipping", type: "number"}
    ], "rows": [
        {c: [
            {v: "January"},
            {v: 19, f: "42 items"},
            {v: 12, f: "Ony 12 items"},
            {v: 7, f: "7 servers"},
            {v: 4}
        ]},
        {c: [
            {v: "February"},
            {v: 13},
            {v: 1, f: "1 unit (Out of stock this month)"},
            {v: 12},
            {v: 2}
        ]},
        {c: [
            {v: "March"},
            {v: 24},
            {v: 0},
            {v: 11},
            {v: 6}

        ]}
    ]};

    chart1.options = {
        "title": "Sales per month",
        "isStacked": "true",
        "fill": 20,
        "displayExactValues": true,
        "vAxis": {
            "title": "Sales unit", "gridlines": {"count": 6}
        },
        "hAxis": {
            "title": "Date"
        }
    };

    chart1.formatters = {};

    $scope.chart = chart1;




});
