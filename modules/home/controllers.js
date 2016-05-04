'use strict';

Object.values = function(object) {
  var values = [];
  for(var property in object) {
    values.push(object[property]);
  }
  return values;
}

angular.module('Home')

.filter("asDate", function () {
    return function (input) {
        return new Date(input);
    }
})

.controller('HomeController', ['$scope', '$http', function ($scope, $http) {
		var myChart = {};
		$scope.area = "jonkoping";
		$scope.links = [
			{
				key: "blekinge",
				name: "Blekinge"
			},
			{
				key: "dalarna",
				name: "Dalarna"
			},
			{
				key: "gotland",
				name: "Gotland"
			},
			{
				key: "gavleborg",
				name: "Gävleborg"
			},
			{
				key: "halland",
				name: "halland"
			},
			{
				key: "jamtland",
				name: "Jämtland"
			},
			{
				key: "jonkoping",
				name: "Jönköping"
			},
			{
				key: "kalmar",
				name: "kalmar"
			},
			{
				key: "kronoberg",
				name: "Kronoberg"
			},
			{
				key: "norrbotten",
				name: "Norrbotten"
			},
			{
				key: "skane",
				name: "Skåne"
			},
			{
				key: "stockholm",
				name: "Stockholm"
			},
			{
				key: "sodermanland",
				name: "Södermanland"
			},
			{
				key: "uppsala",
				name: "Uppsala"
			},
			{
				key: "varmland",
				name: "Värmland"
			},
			{
				key: "vasterbotten",
				name: "Västerbotten"
			},
			{
				key: "vasternorrland",
				name: "Västernorrland"
			},
			{
				key: "vastmanland",
				name: "Västmanland"
			},
			{
				key: "vastra-gotaland",
				name: "Västra Götaland"
			},
			{
				key: "orebro-lan",
				name: "Örebro Län"
			},
			{
				key: "ostergotland",
				name: "Östergötland"
			}
		];

		$scope.areaChanged = function(area) {
	        getReports(area);
	    };

	    $scope.getPic = function(category) {
	    	category = category.trim().toLowerCase();
	    	var pic;
	    	switch (category) {
	    		case "trafikolycka":
	    			pic = "car-accident";
	    			break;
	    		case "snatteri":
	    			pic = "stealing";
	    			break;
	    		case "stöld/inbrott":
	    			pic = "stealing";
	    			break;
	    		case "rattfylleri":
	    			pic = "car-drunk";
	    			break;
	    		default:
	    			pic ="";
	    			break;
	    	}

	    	return pic;
	    }

	    var getReports = function(area) { 
		    $http.get("api/getReports.php?area="+area).success(function(response) {
		    	if (response)	{
		    		$scope.reports = response.reports;
		    		$scope.resultsEmpty = false;

		    		//initChart(response.statisticsAll)
		    	}
		    	else {
		    		$scope.resultsEmpty = true;
		    	}
		    }).error(function(error) {
		    	alert("Something went wrong, couldn't fetch data.");
		    	console.log(error);
		    });
		}

		var updateChart = function(dataset) {
			myChart.data.labels = Object.keys(dataset);
			myChart.data.datasets
		}

		// var initChart = function(dataset) {
		// 	var ctx = document.getElementById("myChart");
		// 	myChart = new Chart(ctx, {
		// 	    type: 'bar',
		// 	    data: {
		// 	        labels: Object.keys(dataset),
		// 	        datasets: [{
		// 	            label: '# av händelser',
		// 	            data: Object.values(dataset),
		// 	            backgroundColor: "rgba(255,99,132,0.2)",
		// 	            borderColor: "rgba(255,99,132,1)",
		// 	            borderWidth: 1,
		// 	            hoverBackgroundColor: "rgba(255,99,132,0.4)",
		// 	            hoverBorderColor: "rgba(255,99,132,1)"
		// 	        }]
		// 	    },
		// 	    options: {
		// 	        scales: {
		// 	                xAxes: [{
		// 	                        stacked: true
		// 	                }],
		// 	                yAxes: [{
		// 	                        stacked: true
		// 	                }]
		// 	        }
		// 	    }
		// 	});
		// }

		getReports('jonkoping');
    }]);