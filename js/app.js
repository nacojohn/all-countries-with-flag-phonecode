(function () {
	'use strict';

	angular.module('AllCountries', [])
	.service('FetchCountryData', FetchCountryData)
	.controller('LoadCountryData', LoadCountryData)
	.constant('SERVER_URL', 'http://localhost/testing/all_countries/process_request.php?_request=');

	FetchCountryData.$inject = ['$http', 'SERVER_URL'];
	function FetchCountryData ($http, SERVER_URL) {
		var fetchData = this;

		fetchData.requestData = function() {
			return $http({
				method: "GET",
				url: (SERVER_URL + 'all')
			});
		}

		fetchData.requestPhoneCode = function (countryCode) {
			return $http({
				method: "GET",
				url: (SERVER_URL + 'getCountry&_code=' + countryCode)
			});
		}
	}

	LoadCountryData.$inject = ['FetchCountryData'];
	function LoadCountryData (FetchCountryData) {
		var allCountries = this;
		allCountries.countryCode = "ng";
		allCountries.countryPhoneCode = "234";

		var promise = FetchCountryData.requestData();
		promise.then(function (response) {
			allCountries.countries = response.data;
		}).catch(function(error) {
			console.log(error)
		});

		allCountries.fetchPhoneCode = function (countryCode) {
			var promise = FetchCountryData.requestPhoneCode(countryCode);
			promise.then(function(response) {
				allCountries.countryPhoneCode = response.data[0]['Phone Code'];
			}).catch(function(error) {
				console.log(error);
			})
		}
	}

})();