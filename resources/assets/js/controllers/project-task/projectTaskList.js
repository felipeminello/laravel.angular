angular.module('app.controllers')
    .controller('ProjectTaskListController', ['$scope', '$routeParams', 'ProjectTask', function ($scope, $routeParams, ProjectTask) {
        $scope.projectTasks = ProjectTask.query({id: $routeParams.id});
    }]);