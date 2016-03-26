angular.module('app.controllers')
    .controller('ProjectNoteRemoveController', ['$scope', '$location', '$routeParams', 'ProjectNote', function ($scope, $location, $routeParams, ProjectNote) {
        $scope.projectNote = ProjectNote.get({id: $routeParams.id, idNote: $routeParams.idNote});

        //console.log($scope.projectNote);

        $scope.remove = function () {
            $scope.projectNote.$delete({id: $routeParams.id, idNote: $routeParams.idNote}).then(function() {
                $location.path('/project/' + $routeParams.id + '/notes');
            });
        }
    }]);