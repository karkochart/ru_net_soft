<!DOCTYPE html>
<html lang="en" ng-app="employeeApp">
<head>
    <meta charset="UTF-8">
    <title>Employees</title>
    <!--    Jquery-->
    <script type="text/javascript" src="/lib/js/jquery-3.1.0.min.js"></script>
    <!--    Bootstrap-->
    <link rel="stylesheet" href="/lib/bootstrap-v3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/lib/bootstrap-v3.3.7/css/bootstrap-theme.min.css">
    <script type="text/javascript" src="/lib/bootstrap-v3.3.7/js/bootstrap.min.js"></script>
    <!--    Angular JS-->
    <script src="/lib/js/angular-1.5.8.min.js"></script>
    <!--    Custom functions-->
    <script src="/lib/js/functions.js"></script>
</head>
<body ng-controller="employeeCtrl">
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-xs-6">
                <select multiple
                        ng-change="usersFilter()"
                        ng-model="selectedCities"
                        ng-options="citie.name for citie in cities">
                </select>
            </div>
            <div class="col-xs-6">
                <select multiple
                        ng-change="usersFilter()"
                        ng-model="selectedQualifications"
                        ng-options="qualification.name for qualification in qualifications">
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <h3>{{searchMessage}}{{users.length}}</h3>
            </div>
        </div>
    </div>
    <div class="panel">
        <table class="table table-hover">
            <thead>
            <tr class="well">
                <th>ФИО</th>
                <th>Оразование</th>
                <th>Города</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="user in users">
                <td class="col-xs-4">{{ user.userName }}</td>
                <td class="col-xs-4">{{ user.qualificationName }}</td>
                <td class="col-xs-4">{{ user.citiesList }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>