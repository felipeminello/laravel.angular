angular.module('app.controllers')
    .controller('ClientRemoveController', ['$scope', '$location', '$routeParams', 'Client', function ($scope, $location, $routeParams, Client) {
        $scope.client = new Client.get({id: $routeParams.id});

        $scope.remove = function () {
            $scope.client.$delete().then(function() {
                $location.path('/clients');
            });
        }
    }]);