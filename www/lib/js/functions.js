//Model
var users = '[]';
var cities = '[]';
var qualifications = '[]';
//Controller
var employeeApp = angular.module('employeeApp', []);
employeeApp.controller('employeeCtrl', function ($scope, $http) {
    $scope.searchMessage = "Количество найденных работников ";
    $http.get(window.location.hostname + "/ajax/getAllUsersWithCity")
        .success(function (data, status, headers, config) {
            $scope.users = data;
        })
        .error(function (data, status, headers, config) {
            console.log(status);
            $scope.users = [];
        });
    $http.get(window.location.hostname + "/ajax/getAllCities")
        .success(function (data, status, headers, config) {
            $scope.cities = data;
        })
        .error(function (data, status, headers, config) {
            console.log(status);
            $scope.users = [];
        });

    $http.get(window.location.hostname + "/ajax/getAllQualifications")
        .success(function (data, status, headers, config) {
            $scope.qualifications = data;
        })
        .error(function (data, status, headers, config) {
            console.log(status);
            $scope.users = [];
        });
    $scope.usersFilter = function () {
        var selectedCities = ($scope.selectedCities !== undefined) ? [$scope.selectedCities] : [];
        var selectedQualifications = ($scope.selectedQualifications !== undefined) ? [$scope.selectedQualifications] : [];
        $http({
            url: window.location.hostname + "/ajax/getUsers",
            method: "GET",
            params: {
                cities: selectedCities,
                qualifications: selectedQualifications
            },
            headers : {'Accept' : 'application/json'}
        }).success(function (data, status, headers, config) {
            $scope.users = data;
        }).error(function (data, status, headers, config) {
            console.log(status);
            $scope.users = [];
        });
    };
    console.log($scope.users);
});
