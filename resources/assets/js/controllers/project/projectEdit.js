angular.module('app.controllers')
    .controller('ProjectEditController',
        ['$scope', '$location', '$cookies', '$routeParams', 'Project', 'Client', 'appConfig', function ($scope, $location, $cookies, $routeParams, Project, Client, appConfig) {

            $scope.project = Project.get({id: $routeParams.id});
            $scope.clients = Client.query();
            $scope.status = appConfig.project.status;

            $scope.project.progress = parseInt($scope.project.progress);

            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project.owner_id = $cookies.getObject('user').id;

                    Project.update({id: $scope.project.id}, $scope.project, function() {
                        $location.path('/projects');
                    });
                }
            }
        }]);
