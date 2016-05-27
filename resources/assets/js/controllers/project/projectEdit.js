angular.module('app.controllers')
    .controller('ProjectEditController',
        ['$scope', '$location', '$cookies', '$routeParams', 'Project', 'Client', 'appConfig',
            function ($scope, $location, $cookies, $routeParams, Project, Client, appConfig) {

                Project.get({id: $routeParams.id}, function (data) {
                    $scope.project = data;
                    $scope.clientSelected = data.client;
                    $scope.project.progress = parseInt($scope.project.progress);

                    Client.get({id: data.client_id}, function (data) {
                        $scope.clientSelected = data;
                    });
                });

                $scope.status = appConfig.project.status;

                $scope.due_date = {
                    status: {
                        opened: false
                    }
                };

                $scope.dateOptions = {
                    maxDate: new Date(2020, 5, 22),
                    minDate: new Date(),
                    startingDay: 0
                };


                $scope.open = function() {
                    $scope.due_date.status.opened = true;
                };

                $scope.save = function () {
                    if ($scope.form.$valid) {
                        $scope.project.owner_id = $cookies.getObject('user').id;

                        Project.update({id: $scope.project.id}, $scope.project, function () {
                            $location.path('/projects');
                        });
                    }
                };

                $scope.formatName = function (model) {
                    if (model) {
                        return model.name;
                    }

                    return '';
                };

                $scope.getClients = function (name) {
                    return Client.query({
                        search: name,
                        searchFields: 'name:like'
                    }).$promise;
                };

                $scope.selectClient = function (item) {
                    $scope.project.client_id = item.id;
                };

            }
        ]
    );
