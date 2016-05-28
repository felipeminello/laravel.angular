angular.module('app.controllers')
    .controller('ProjectFileRemoveController',
        ['$scope', '$location', '$routeParams', 'ProjectFile', function ($scope, $location, $routeParams, ProjectFile) {
            $scope.projectFile = ProjectFile.get({id: $routeParams.id, idFile: $routeParams.idFile}, function (data) {
                $scope.project = data.project.data[0];

                $scope.projectFile.project_id = $scope.project.project_id;
            });

            $scope.remove = function () {
                $scope.projectFile.$delete({id: $routeParams.id, idFile: $routeParams.idFile}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/file');
                });
            }
        }]
    );