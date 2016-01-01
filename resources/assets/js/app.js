var app = angular.module('app', ['ngRoute', 'app.controllers']);

angular.module('app.controllers', []);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/login', {
            templateUrl: 'build/views/login.html',
            controller: 'LoginController'
        })
        .when('/home', {
            templateUrl: 'build/views/home.html',
            controller: 'HomeController'
        });
});