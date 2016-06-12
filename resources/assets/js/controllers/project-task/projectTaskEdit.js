angular.module('app.controllers')
    .controller('ProjectTaskEditController',
        ['$scope', '$location', '$routeParams', '$filter', 'ProjectTask', function ($scope, $location, $routeParams, $filter, ProjectTask) {
            $scope.projectTask = ProjectTask.get({id: $routeParams.id, idTask: $routeParams.idTask}, function(data) {
                $scope.project = data.project.data[0];

                $scope.projectTask.project_id = $scope.project.project_id;
            });

            $scope.due_date = {
                status: {
                    opened: false
                }
            };

            $scope.start_date = {
                status: {
                    opened: false
                }
            };

            $scope.open = function($event, type) {
//                $event.preventDefault();
//                $event.stopPropagation();

                $scope[type].status.opened = true;
            };

            $scope.dateOptions = {
                startingDay: 0
            };


            $scope.save = function () {
                if ($scope.form.$valid) {
                    delete $scope.projectTask.project;

                    ProjectTask.update({
                        id: $routeParams.id,
                        idTask: $routeParams.idTask
                    }, $scope.projectTask, function () {
                        $location.path('/project/' + $routeParams.id + '/task');
                    });
                }
            }
        }]
    );