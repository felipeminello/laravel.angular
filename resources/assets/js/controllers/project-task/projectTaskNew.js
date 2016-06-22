angular.module('app.controllers')
    .controller('ProjectTaskNewController',
        ['$scope', '$location', '$routeParams', 'appConfig', 'Url', 'ProjectTask', 'Project',
        function ($scope, $location, $routeParams, appConfig, Url, ProjectTask, Project) {
            $scope.projectTask = new ProjectTask();
            $scope.projectTask.project_id = $routeParams.id;

            $scope.project = Project.get({id: $routeParams.id});

            $scope.projects = Project.query();

            $scope.status = appConfig.project.status;

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
                maxDate: new Date(2020, 5, 22),
                minDate: new Date(),
                startingDay: 0
            };


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.projectTask.$save({id: $routeParams.id}).then(function () {
                        $location.path(Url.getUrlFromUrlSymbol(appConfig.urls.projectTask, {
                            id: $routeParams.id
                        }));
                    });
                }
            }
        }
    ]
);