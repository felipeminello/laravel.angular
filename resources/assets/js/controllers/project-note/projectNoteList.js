angular.module('app.controllers')
    .controller('ProjectNoteListController', ['$scope', '$routeParams', 'ProjectNote', function ($scope, $routeParams, ProjectNote) {
        $scope.projectNotes = new ProjectNote.query({id: $routeParams.id});
    }]);