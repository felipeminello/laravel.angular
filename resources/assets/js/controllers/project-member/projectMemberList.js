angular.module('app.controllers')
    .controller('ProjectMemberListController', ['$scope', '$routeParams', 'ProjectMember', 'Project', function ($scope, $routeParams, ProjectMember, Project) {
        $scope.projectMembers = ProjectMember.query({id: $routeParams.id});
        $scope.project = Project.get({id: $routeParams.id});
    }]);