angular.module('app.controllers')
    .controller('LoginController', ['$scope', '$location', 'OAuth', function ($scope, $location, OAuth) {
        $scope.user = {
            username: '',
            password: ''
        };

        $scope.login = function () {
            if ($scope.form.$valid) {
                OAuth.getAccessToken($scope.user).then(function () {
                    $location.path('home');
                }, function () {
                    alert('login inválido');
                });
            }
        };
    }]);