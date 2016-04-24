angular.module('app.controllers')
    .controller('ProjectFileNewController',
        ['$scope', '$location', '$routeParams', 'ProjectFile', 'Project', function ($scope, $location, $routeParams, ProjectFile, Project) {
            
        $scope.projectFile = new ProjectFile();
        $scope.projectFile.project_id = $routeParams.id;

        $scope.project = Project.get({id: $routeParams.id});

        $scope.projects = Project.query();

        console.log('project: ', $scope.projects);

        $scope.save = function () {
            if ($scope.form.$valid) {
                $scope.projectFile.$save({id: $routeParams.id}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/files');
                });
            }
        }
    }]);