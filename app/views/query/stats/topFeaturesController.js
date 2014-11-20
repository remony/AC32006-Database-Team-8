angular.module('app.query.statsFeaturesController', ['nvd3'])

.controller('topFeaturesController', function($scope, $cookies, $location, toastService, $rootScope, listService) {
	$scope.title = "Top camera features!";

	$.ajax({
		type: "GET",
		url: backend + "/camera/all",
		beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
	}).done(function(data){
			console.log(data);
			console.log("done");

		}).fail(function(data){
			toastService.displayToast("Error contacting database");
		}).success(function(data){
			$scope.cameraAll = data.data;
			$scope.cameraAllSuccess = true;
			$scope.$apply();
		});

		$.ajax({
			type: "GET",
			url: backend + "/camera/features/popular",
			beforeSend: function (xhr) {xhr.setRequestHeader ("Authorization", $cookies.monster_cookie)},
		}).done(function(data){
				console.log(data);
				console.log("done");

			}).fail(function(data){
				toastService.displayToast("Error contacting database");
			}).success(function(data){
				$scope.cameraTopFeature = data.data[0];
				$scope.cameraTopFeatureSuccess = true;
				$scope.$apply();
			});




});
