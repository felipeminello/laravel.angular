angular.module('app.controllers')
    .controller('ProjectFileEditController',
        ['$scope', '$location', '$routeParams', 'ProjectFile', function ($scope, $location, $routeParams, ProjectFile) {
            $scope.projectFile = ProjectFile.get({id: $routeParams.id, idFile: $routeParams.idFile}, function(data) {
                $scope.project = data.project.data[0];

                $scope.projectFile.project_id = $scope.project.project_id;
            });

            $scope.save = function () {
                if ($scope.form.$valid) {
                    delete $scope.projectFile.project;

                    ProjectFile.update({
                        id: $routeParams.id,
                        idFile: $routeParams.idFile
                    }, $scope.projectFile, function () {
                        $location.path('/project/' + $routeParams.id + '/file');
                    });
                }
            }
        }]
    );