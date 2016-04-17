angular.module('app.controllers')
    .controller('ProjectFileShowController', ['$scope', '$routeParams', 'ProjectFile', function ($scope, $routeParams, ProjectFile) {
        $scope.projectFile = ProjectFile.get({id: $routeParams.id, idFile: $routeParams.idFile});
    }]);