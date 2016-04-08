angular.module('app.controllers')
    .controller('HomeController', ['$scope', '$cookies', function ($scope, $cookies) {
        console.log('email: ', $cookies.getObject('user').email);
    }]);