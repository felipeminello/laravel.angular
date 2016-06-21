angular.module('app.controllers')
    .controller('ProjectMemberRemoveController', ['$scope', '$location', '$routeParams', 'ProjectMember', 'Project',
        function ($scope, $location, $routeParams, ProjectMember, Project) {
            $scope.projectMember = ProjectMember.get({id: $routeParams.id, idMember: $routeParams.idMember});

            $scope.project = Project.get({id: $routeParams.id});

            //console.log($scope.projectMember);

            $scope.remove = function () {
                $scope.projectMember.$delete({id: $routeParams.id, idMember: $routeParams.idMember}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/member');
                });
            }
        }
    ]);