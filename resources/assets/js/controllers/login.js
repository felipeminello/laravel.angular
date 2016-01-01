angular.module('app.controllers')
    .controller('LoginController', ['$scope', function ($scope) {
        $scope.user = {
            username: '',
            password: ''
        };

        $scope.login = function () {

        };
    }]);