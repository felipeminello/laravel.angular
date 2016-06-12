angular.module('app.controllers')
    .controller('ProjectTaskRemoveController',
        ['$scope', '$location', '$routeParams', 'ProjectTask', function ($scope, $location, $routeParams, ProjectTask) {
            $scope.projectTask = ProjectTask.get({id: $routeParams.id, idTask: $routeParams.idTask}, function (data) {
                $scope.project = data.project.data[0];

                $scope.projectTask.project_id = $scope.project.project_id;
            });

            $scope.remove = function () {
                $scope.projectTask.$delete({id: $routeParams.id, idTask: $routeParams.idTask}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/task');
                });
            }
        }]
    );